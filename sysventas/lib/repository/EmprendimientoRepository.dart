import 'dart:io';

import 'package:dio/dio.dart';
import 'package:pretty_dio_logger/pretty_dio_logger.dart';
import 'package:sysventas/apis/emprendimiento_api.dart';
import 'package:sysventas/modelo/EmprendimientoModelo.dart';
import 'package:path/path.dart';
import 'package:sysventas/util/TokenUtil.dart';
import 'package:sysventas/util/UrlApi.dart';

class EmprendimientoRepository {
  final Dio _dio;
  EmprendimientoRepository()
      : _dio = Dio(BaseOptions(
    baseUrl: UrlApi.urlApix,
    headers: {
      'Content-Type': 'multipart/form-data',
      'Authorization': TokenUtil.TOKEN,
    },
  )) {
    _dio.interceptors.add(PrettyDioLogger());
  }

  Future<List<EmprendimientoResp>> getEntidad() async {
    final resp = await _dio.get<List<dynamic>>('emprendimientos');
    return resp.data!
        .map((json) => EmprendimientoResp.fromJson(json as Map<String, dynamic>))
        .toList();
  }

  Future<EmprendimientoResp> createWithImages(
      EmprendimientoDto dto,
      List<File> nuevasImagenes,
      ) async {
    final form = FormData();
    // los campos del DTO
    dto.toJson().forEach((k, v) => form.fields.add(MapEntry(k, v.toString())));
    // las fotos
    for (var f in nuevasImagenes) {
      form.files.add(
        MapEntry(
          'imagenes[]',
          await MultipartFile.fromFile(f.path, filename: basename(f.path)),
        ),
      );
    }
    final resp = await _dio.post<Map<String, dynamic>>(
      'emprendimientos',
      data: form,
    );
    return EmprendimientoResp.fromJson(resp.data!);
  }

  Future<EmprendimientoResp> updateWithImages(
      int id,
      EmprendimientoDto dto,
      List<File> nuevasImagenes,
      List<String> imagenesAEliminar,
      ) async {
    final form = FormData();
    // le decimos a Laravel que esto es un PUT
    form.fields.add(const MapEntry('_method', 'PUT'));
    // añades tus campos normales
    dto.toJson().forEach((k, v) => form.fields.add(MapEntry(k, v.toString())));
    // nuevas imágenes
    for (var f in nuevasImagenes) {
      form.files.add(MapEntry(
        'imagenes[]',
        await MultipartFile.fromFile(f.path, filename: basename(f.path)),
      ));
    }
    // cuáles borrar
    for (var url in imagenesAEliminar) {
      form.fields.add(MapEntry('borrar_imagenes[]', url));
    }

    final resp = await _dio.post<Map<String, dynamic>>(
      'emprendimientos/$id',
      data: form,
    );

    // Laravel te devolverá algo como { message: "...", emprendimiento: { ... } }
    final Map<String, dynamic> body = resp.data!;
    return EmprendimientoResp.fromJson(body['emprendimiento']);
  }

  Future<void> deleteEntidad(int id) async {
    await _dio.delete('emprendimientos/$id');
  }
}