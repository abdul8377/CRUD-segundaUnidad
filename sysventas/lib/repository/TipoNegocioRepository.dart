import 'package:dio/dio.dart';
import 'package:sysventas/apis/tiponegocio_api.dart';
import 'package:sysventas/modelo/TipoNegocioModelo.dart';
import 'package:sysventas/util/TokenUtil.dart';

class TipoNegocioRepository {
  TipoNegocioApi? tipoNegocio;

  TipoNegocioRepository() {
    final Dio dio = Dio();
    dio.options.headers["Content-Type"] = "application/json";
    tipoNegocio = TipoNegocioApi(dio);
  }

  Future<List<TipoDeNegocioResp>> getAll() async {
    return await tipoNegocio!.listar().then((
        value) => value);
  }


  Future<TipoDeNegocioResp?> getById(int id) async {
    return await tipoNegocio?.obtener(id);
  }

  Future<TipoDeNegocioResp?> create(TipoDeNegocioDto dto) async {
    return await tipoNegocio?.crear(dto.toJson());
  }

  Future<TipoDeNegocioResp?> update(int id, TipoDeNegocioDto dto) async {
    return await tipoNegocio?.actualizar(id, dto.toJson());
  }

  Future<void> delete(int id) async {
    return await tipoNegocio?.eliminar(id);
  }
}