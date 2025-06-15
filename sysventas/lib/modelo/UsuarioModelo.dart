
import 'package:json_annotation/json_annotation.dart';

/// Modelo para el request de login en tu backend Laravel.
/// Laravel espera un JSON así:
/// {
///   "email": "usuario@ejemplo.com",
///   "password": "MiClave123"
/// }
class UsuarioLogin {
  late final String email;
  late final String password;

  /// Constructor estándar
  UsuarioLogin({
    required this.email,
    required this.password,
  });

  /// Constructor corto, para instanciar rápido:
  /// UsuarioLogin.login("correo@e.com", "MiClave123");
  UsuarioLogin.login(this.email, this.password);

  /// Crea una instancia de UsuarioLogin a partir de un Map (por si en algún
  /// flujo necesitas parsear algo que venga de JSON, aunque para login no
  /// se use habitualmente fromJson).
  factory UsuarioLogin.fromJson(Map<String, dynamic> json) {
    return UsuarioLogin(
      email: json['email'] as String,
      password: json['password'] as String,
    );
  }

  /// Convierte esta instancia a Map<String, dynamic> para enviarlo en el
  /// body del POST /login.
  Map<String, dynamic> toJson() {
    return {
      'email': email,
      'password': password,
    };
  }
}


/// Modelo que mapea la respuesta del login en Laravel.
/// Ejemplo de JSON de respuesta:
/// {
///   "token": "1|hmtN9ebw…",
///   "id": 1,
///   "name": "Franck Coaquira",
///   "last_name": "Coaquira",
///   "email": "franck@gmail.com",
///   "roles": ["Administrador"],
///   "is_active": 1,          // <-- Laravel devuelve 1 en lugar de true
///   "motivo_inactivo": null
/// }
class UsuarioResp {
  late final String token;
  late final int idUsuario;
  late final String name;
  late final String lastName;
  late final String email;
  late final List<String> roles;
  late final bool isActive;
  late final String? motivoInactivo;

  UsuarioResp({
    required this.token,
    required this.idUsuario,
    required this.name,
    required this.lastName,
    required this.email,
    required this.roles,
    required this.isActive,
    this.motivoInactivo,
  });

  /// Crea una instancia a partir del JSON que devuelve Laravel.
  factory UsuarioResp.fromJson(Map<String, dynamic> json) {
    // En Laravel "is_active" viene como 1 o 0. Convertimos a bool:
    bool activo;
    final dynamic rawIsActive = json['is_active'];
    if (rawIsActive is bool) {
      activo = rawIsActive;
    } else if (rawIsActive is int) {
      activo = rawIsActive == 1;
    } else if (rawIsActive is String) {
      // A veces puede venir "1" o "0" como String
      activo = rawIsActive == '1' || rawIsActive.toLowerCase() == 'true';
    } else {
      activo = false;
    }

    return UsuarioResp(
      token: json['token'] as String,
      idUsuario: (json['id'] is int)
          ? json['id'] as int
          : int.parse(json['id'].toString()),
      name: json['name'] as String,
      lastName: json['last_name'] as String,
      email: json['email'] as String,
      roles: (json['roles'] as List<dynamic>)
          .map((e) => e.toString())
          .toList(),
      isActive: activo,
      motivoInactivo: json['motivo_inactivo'] != null
          ? json['motivo_inactivo'] as String
          : null,
    );
  }

  /// Convierte esta instancia a JSON (no suele hacerse en el flujo de login,
  /// pero puedes usarlo si quieres reenviar o inspeccionar el JSON).
  /// Convierte esta instancia a JSON (útil para pruebas si lo deseas).
  Map<String, dynamic> toJson() {
    return {
      'token': token,
      'id': idUsuario,
      'name': name,
      'last_name': lastName,
      'email': email,
      'roles': roles,
      // Devolvemos 1 o 0 en lugar de true/false, si quieres enviarlo de vuelta:
      'is_active': isActive ? 1 : 0,
      'motivo_inactivo': motivoInactivo,
    };
  }

  @override
  String toString() {
    return 'UsuarioResp{token: $token, '
        'idUsuario: $idUsuario, '
        'name: $name, '
        'lastName: $lastName, '
        'email: $email, '
        'roles: $roles, '
        'isActive: $isActive, '
        'motivoInactivo: $motivoInactivo}';
  }
}