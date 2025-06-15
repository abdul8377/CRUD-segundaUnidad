import 'dart:convert';
import 'package:dio/dio.dart' hide Headers;
import 'package:retrofit/retrofit.dart';
import 'package:retrofit/http.dart' as rest;
import 'package:pretty_dio_logger/pretty_dio_logger.dart';
import 'package:sysventas/modelo/ZonasTuristicasModelo.dart';
import 'package:sysventas/util/UrlApi.dart';

part 'ZonaTuristica_api.g.dart';

@RestApi(baseUrl: UrlApi.urlApix)
abstract class ZonaturisticaApi {
  factory ZonaturisticaApi(Dio dio, {String baseUrl}) = _ZonaturisticaApi;

  static ZonaturisticaApi create() {
    final dio = Dio();
    dio.options.headers["Content-Type"] = "application/json";
    dio.interceptors.add(PrettyDioLogger());
    return ZonaturisticaApi(dio);
  }

  @GET("zonas-turisticas")
  Future<List<ZonaTuristicaResp>> listar();

  @GET("zonas-turisticas/{id}")
  Future<ZonaTuristicaResp> obtener(@Path("id") int id);


  @MultiPart()
  @POST("zonas-turisticas")
  Future<ZonaTuristicaResp> crearMultipart(
      @Part() Map<String, dynamic> fields,
      @Part(name: "imagenes[]") List<MultipartFile>? imagenes,
      );
  @DELETE("zonas-turisticas/{id}")
  Future<void> eliminar(@Path("id") int id);
}