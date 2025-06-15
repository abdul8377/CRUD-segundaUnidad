


import 'dart:convert';

import 'package:sysventas/modelo/EmprendimientoModelo.dart';

import 'package:dio/dio.dart' hide Headers;
import 'package:retrofit/retrofit.dart';
import 'package:retrofit/http.dart' as rest;
import 'package:pretty_dio_logger/pretty_dio_logger.dart';
import 'package:sysventas/modelo/emprendimiento_wrapper.dart';
import 'package:sysventas/util/UrlApi.dart';

part 'emprendimiento_api.g.dart';

@RestApi(baseUrl: UrlApi.urlApix)
abstract class EmprendimientoApi {
  factory EmprendimientoApi(Dio dio, {String baseUrl}) = _EmprendimientoApi;

  static EmprendimientoApi create() {
    final dio = Dio();
    dio.options.headers["Content-Type"] = "application/json";
    dio.interceptors.add(PrettyDioLogger());
    return EmprendimientoApi(dio);
  }

  @GET("emprendimientos")
  Future<List<EmprendimientoResp>> listar();

  @GET("emprendimientos/{id}")
  Future<EmprendimientoResp> obtener(@Path("id") int id);


  @MultiPart()
  @POST("emprendimientos")
  Future<EmprendimientoResp> crearMultipart(
      @Part() Map<String, dynamic> fields,
      @Part(name: "imagenes[]") List<MultipartFile>? imagenes,
      );
  @DELETE("emprendimientos/{id}")
  Future<void> eliminar(@Path("id") int id);
}