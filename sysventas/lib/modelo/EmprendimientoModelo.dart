class EmprendimientoResp {
  final int    idEmprendimiento;
  final String codigoUnico;
  final String nombre;
  final String descripcion;
  final int    tipoNegocioId;
  final String direccion;
  final String telefono;
  final String estado;
  final String fechaRegistro;
  final List<String> imagenesUrl;

  EmprendimientoResp({
    required this.idEmprendimiento,
    required this.codigoUnico,
    required this.nombre,
    required this.descripcion,
    required this.tipoNegocioId,
    required this.direccion,
    required this.telefono,
    required this.estado,
    required this.fechaRegistro,
    required this.imagenesUrl,
  });

  factory EmprendimientoResp.fromJson(Map<String, dynamic> json) {
    int _parseInt(dynamic v) {
      if (v is int) return v;
      return int.tryParse(v?.toString() ?? '') ?? 0;
    }

    return EmprendimientoResp(
      idEmprendimiento: _parseInt(json['emprendimientos_id']),
      codigoUnico:      json['codigo_unico']    as String? ?? '',
      nombre:           json['nombre']          as String? ?? '',
      descripcion:      json['descripcion']     as String? ?? '',
      tipoNegocioId:    _parseInt(json['tipo_negocio_id']),  // ← robusto ante string o int
      direccion:        json['direccion']       as String? ?? '',
      telefono:         json['telefono']        as String? ?? '',
      estado:           json['estado']          as String? ?? '',
      fechaRegistro:    json['fecha_registro']  as String? ?? '',
      imagenesUrl:      (json['imagenes_url'] as List<dynamic>?)
          ?.map((e) => e as String)
          .toList()
          ?? <String>[],
    );
  }

  Map<String, dynamic> toJson() => {
    'emprendimientos_id': idEmprendimiento,
    'codigo_unico'      : codigoUnico,
    'nombre'            : nombre,
    'descripcion'       : descripcion,
    'tipo_negocio_id'   : tipoNegocioId,
    'direccion'         : direccion,
    'telefono'          : telefono,
    'estado'            : estado,
    'fecha_registro'    : fechaRegistro,
    'imagenes_url'      : imagenesUrl,
  };
}

class EmprendimientoDto {
  final int? idEmprendimiento;
  final String nombre;
  final String descripcion;
  final int tipoNegocioId;
  final String direccion;
  final String telefono;
  final String estado;
  final String fechaRegistro;
  final List<String> imagenesUrl;

  EmprendimientoDto({
    this.idEmprendimiento,
    required this.nombre,
    required this.descripcion,
    required this.tipoNegocioId,
    required this.direccion,
    required this.telefono,
    required this.estado,
    required this.fechaRegistro,
    required this.imagenesUrl,
  });

  factory EmprendimientoDto.fromJson(Map<String, dynamic> json) {
    return EmprendimientoDto(
      idEmprendimiento: json['emprendimientos_id'] as int?,
      nombre: json['nombre'],
      descripcion: json['descripcion'],
      tipoNegocioId: json['tipo_negocio_id'],
      direccion: json['direccion'],
      telefono: json['telefono'],
      estado: json['estado'],
      fechaRegistro: json['fecha_registro'],
      imagenesUrl: (json['imagenes_url'] as List<dynamic>)
          .map((e) => e as String)
          .toList(),
    );
  }

  Map<String, dynamic> toJson() {
    final data = <String, dynamic>{
      'nombre': nombre,
      'descripcion': descripcion,
      'tipo_negocio_id': tipoNegocioId,
      'direccion': direccion,
      'telefono': telefono,
      'estado': estado,
      'fecha_registro': fechaRegistro,
      'imagenes_url': imagenesUrl,
    };
    if (idEmprendimiento != null) {
      data['emprendimientos_id'] = idEmprendimiento;
    }
    return data;
  }
}