part of 'emprendimiento_bloc.dart';

@immutable
sealed class EmprendimientoState {}

final class EmprendimientoInitialState extends EmprendimientoState {}

class EmprendimientoLoadingState extends EmprendimientoState {}

class EmprendimientoLoadedState extends EmprendimientoState {
  List<EmprendimientoResp> EmprendimientoList;
  EmprendimientoLoadedState(this.EmprendimientoList);
}

class EmprendimientoLoadedFormState extends EmprendimientoState {
  List<TipoDeNegocioResp> tipoNegocio;
  EmprendimientoLoadedFormState(this.tipoNegocio);
}

class EmprendimientoLoadedFilterState extends EmprendimientoState {
  List<EmprendimientoResp> EmprendimientoList;
  List<EmprendimientoResp> EmprendimientoFiltroList;
  EmprendimientoLoadedFilterState(this.EmprendimientoList, this.EmprendimientoFiltroList);
}
class EmprendimientoUpdateSuccess extends EmprendimientoState {
  EmprendimientoUpdateSuccess();
}

class EmprendimientoError extends EmprendimientoState {
  final String message;
  EmprendimientoError(this.message);
}