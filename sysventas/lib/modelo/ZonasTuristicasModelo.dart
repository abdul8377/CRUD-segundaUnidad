class ZonaTuristicaResp {
  final int idZonasTuristicas;
  final String nombre;
  final String descripcion;
  final String ubicacion;
  final String estado;
  final List<String> imagenesUrl;
  final String? imagenUrl;

  ZonaTuristicaResp({
    required this.idZonasTuristicas,
    required this.nombre,
    required this.descripcion,
    required this.ubicacion,
    required this.estado,
    required this.imagenesUrl,
    this.imagenUrl,
  });

  factory ZonaTuristicaResp.fromJson(Map<String, dynamic> json) {
    List<String>? imagesUrlList = [];
    if (json['images'] != null && json['images'] is List) {
      imagesUrlList = (json['images'] as List)
          .map((img) => img['url'] != null
          ? (img['url'].toString().startsWith('http')
          ? img['url']
          : '${json['imagen_url']}'
      )
          : ''
      )
          .where((url) => url.isNotEmpty).cast<String>()
          .toList();
    }
    return ZonaTuristicaResp(
      idZonasTuristicas: json['zonas_turisticas_id'],
      nombre: json['nombre'] ?? '',
      descripcion: json['descripcion'] ?? '',
      ubicacion: json['ubicacion'] ?? '',
      estado: json['estado'] ?? '',
      imagenesUrl: imagesUrlList,
      imagenUrl: json['imagen_url'],
    );
  }

}

class ZonaTuristicaDto {
  final int? idZonasTuristicas;
  final String nombre;
  final String descripcion;
  final String ubicacion;
  final String estado;
  final List<String> imagenUrl;

  ZonaTuristicaDto({
    this.idZonasTuristicas,
    required this.nombre,
    required this.descripcion,
    required this.ubicacion,
    required this.estado,
    required this.imagenUrl,
  });

  factory ZonaTuristicaDto.fromJson(Map<String, dynamic> json){
    return ZonaTuristicaDto(
      idZonasTuristicas: json["zonas_turisticas_id"]  as int?,
      nombre: json["nombre"],
      descripcion: json["descripcion"],
      ubicacion: json["ubicacion"],
      estado: json["estado"],
      imagenUrl: (json['imagen_url'] as List<dynamic>?)
          ?.map((e) => e as String)
          .toList()
          ?? <String>[],
    );
  }

  Map<String, dynamic> toJson() {
    final data = <String, dynamic>{
      "zonas_turisticas_id": idZonasTuristicas,
      "nombre": nombre,
      "descripcion": descripcion,
      "ubicacion": ubicacion,
      "estado": estado,
      "imagen_url": imagenUrl,
    };
    if (idZonasTuristicas != null) {
      data['emprendimientos_id'] = idZonasTuristicas;
    }
    return data;
  }
}
