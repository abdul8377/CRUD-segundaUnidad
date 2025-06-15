
import 'package:sysventas/modelo/TipoNegocioModelo.dart';
import 'package:dio/dio.dart';
import 'package:sysventas/util/UrlApi.dart';
import 'package:pretty_dio_logger/pretty_dio_logger.dart';
import 'package:retrofit/http.dart';
import 'package:retrofit/retrofit.dart';



part 'tiponegocio_api.g.dart';

@RestApi(baseUrl: UrlApi.urlApix)
abstract class TipoNegocioApi {
  factory TipoNegocioApi(Dio dio, {String baseUrl}) = _TipoNegocioApi;

  static TipoNegocioApi create() {
    final dio = Dio();
    dio.options.headers["Content-Type"] = "application/json";
    dio.interceptors.add(PrettyDioLogger());
    return TipoNegocioApi(dio);
  }

  @GET("tipos-de-negocio")
  Future<List<TipoDeNegocioResp>> listar();

  @GET("tipos-de-negocio/{id}")
  Future<TipoDeNegocioResp> obtener(@Path("id") int id);


  @POST("tipos-de-negocio")
  Future<TipoDeNegocioResp> crear(@Body() Map<String, dynamic> data);

  @PUT("tipos-de-negocio/{id}")
  Future<TipoDeNegocioResp> actualizar(
      @Path("id") int id,
      @Body() Map<String, dynamic> data,
      );

  @DELETE("tipos-de-negocio/{id}")
  Future<void> eliminar(@Path("id") int id);
}