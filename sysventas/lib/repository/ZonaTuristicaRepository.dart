import 'dart:io';

import 'package:dio/dio.dart';
import 'package:pretty_dio_logger/pretty_dio_logger.dart';
import 'package:path/path.dart';
import 'package:sysventas/modelo/ZonasTuristicasModelo.dart';
import 'package:sysventas/util/TokenUtil.dart';
import 'package:sysventas/util/UrlApi.dart';

class ZonaTuristicaRepository {
  final Dio _dio;

  ZonaTuristicaRepository()
      : _dio = Dio(BaseOptions(
    baseUrl: UrlApi.urlApix,
    headers: {
      'Content-Type': 'multipart/form-data',
      'Authorization': TokenUtil.TOKEN,
    },
  )) {
    _dio.interceptors.add(PrettyDioLogger());
  }

  // Obtener lista de zonas turísticas
  Future<List<ZonaTuristicaResp>> getEntidad() async {
    final resp = await _dio.get<List<dynamic>>('zonas-turisticas');
    return resp.data!
        .map((json) => ZonaTuristicaResp.fromJson(json as Map<String, dynamic>))
        .toList();
  }

  // Crear zona turística con imágenes
  Future<ZonaTuristicaResp> createWithImages(
      ZonaTuristicaDto dto,
      List<File> nuevasImagenes,
      ) async {
    final form = FormData();
    dto.toJson().forEach((k, v) {
      // Evita agregar campos que sean listas o archivos aquí
      if (v is String || v is int) {
        form.fields.add(MapEntry(k, v.toString()));
      }
    });

// Adjunta la imagen SÓLO si existe
    if (nuevasImagenes.isNotEmpty) {
      final f = nuevasImagenes.first;
      print("Imagen seleccionada: ${f.path}");
      form.files.add(
        MapEntry(
          'imagen',
          await MultipartFile.fromFile(f.path, filename: basename(f.path)),
        ),
      );
    }
    try {
      final resp = await _dio.post<Map<String, dynamic>>(
        'zonas-turisticas',
        data: form,
      );
      final data = resp.data;
      if (data == null) throw Exception('Respuesta vacía del backend');
      if (!data.containsKey('zona')) {
        throw Exception('Respuesta inválida del backend. Esperado "zona"');
      }
      return ZonaTuristicaResp.fromJson(data['zona']);
    } catch (e) {
      if (e is DioError) {
        print("VALIDATION ERROR: ${e.response?.data}");
        throw Exception('Error de validación: ${e.response?.data}');
      }
      rethrow;
    }
  }

  Future<ZonaTuristicaResp> updateWithImages(
      int id,
      ZonaTuristicaDto dto,
      List<File> nuevasImagenes,
      List<String> imagenesAEliminar,
      ) async {
    final form = FormData();
    form.fields.add(const MapEntry('_method', 'PUT'));
    dto.toJson().forEach((k, v) => form.fields.add(MapEntry(k, v.toString())));
    if (nuevasImagenes.isNotEmpty) {
      final f = nuevasImagenes.first;
      form.files.add(MapEntry(
        'imagen',
        await MultipartFile.fromFile(f.path, filename: basename(f.path)),
      ));
    }

    try {
      final resp = await _dio.post<Map<String, dynamic>>(
        'zonas-turisticas/$id',
        data: form,
      );
      final data = resp.data;
      if (data == null) throw Exception('Respuesta vacía del backend');
      if (!data.containsKey('zona')) {
        throw Exception('Respuesta inválida del backend. Esperado "zona"');
      }
      return ZonaTuristicaResp.fromJson(data['zona']);
    } catch (e) {
      if (e is DioError) {
        print("VALIDATION ERROR: ${e.response?.data}");
        // Opcionalmente, puedes mostrarlo también como Exception personalizada
        throw Exception('Error de validación: ${e.response?.data}');
      }
      rethrow;
    }
  }
  // Eliminar zona turística
  Future<void> deleteEntidad(int id) async {
    print(">>> Repository intenta borrar id $id");
    await _dio.delete('zonas-turisticas/$id');
    print(">>> Repository borró id $id");
  }
}
