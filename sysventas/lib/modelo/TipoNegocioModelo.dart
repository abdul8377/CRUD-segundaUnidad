
class TipoDeNegocioResp {
  TipoDeNegocioResp({
    required this.idTipoNegocio,
    required this.nombre,
    required this.descripcion,
  });

  final int idTipoNegocio;

  final String nombre;

  final String? descripcion;

  factory TipoDeNegocioResp.fromJson(Map<String, dynamic> json) {
    return TipoDeNegocioResp(
      idTipoNegocio: (json['id'] is int)
          ? json['id'] as int
          : int.parse(json['id'].toString()),
      nombre: json['nombre'] as String,
      descripcion: json['descripcion'] != null ? json['descripcion'] as String : null,
    );
  }

  Map<String, dynamic> toJson() => {
    'id': idTipoNegocio,
    'nombre': nombre,
    'descripcion': descripcion,
  };

  @override
  String toString() {
    return 'TipoDeNegocioResp{idTipoNegocio: $idTipoNegocio, '
        'nombre: $nombre, descripcion: $descripcion}';
  }
}

class TipoDeNegocioDto {
  TipoDeNegocioDto({
    required this.nombre,
    required this.descripcion,
  });

  late final String nombre;


  late final String? descripcion;

  TipoDeNegocioDto.unlaunched();

 factory TipoDeNegocioDto.fromJson(Map<String, dynamic> json) {
    return TipoDeNegocioDto(
      nombre: json['nombre'] as String,
      descripcion: json['descripcion'] != null ? json['descripcion'] as String : null,
    );
  }
Map<String, dynamic> toJson() => {
    'nombre': nombre,
    'descripcion': descripcion,
  };
}

