part of 'emprendimiento_bloc.dart';

@immutable
sealed class ZonaTuristicaState {}

class ZonaTuristicaInitialState extends ZonaTuristicaState {}

class ZonaTuristicaLoadingState extends ZonaTuristicaState {}

class ZonaTuristicaLoadedState extends ZonaTuristicaState {
  final List<ZonaTuristicaResp> zonaTuristicaList;
  ZonaTuristicaLoadedState(this.zonaTuristicaList);
}

class ZonaTuristicaLoadedFormState extends ZonaTuristicaState {}

/// Cuando aplicas un filtro
class ZonaTuristicaLoadedFilterState extends ZonaTuristicaState {
  final List<ZonaTuristicaResp> zonaTuristicaList;
  final List<ZonaTuristicaResp> zonaTuristicaFiltroList;
  ZonaTuristicaLoadedFilterState(this.zonaTuristicaList, this.zonaTuristicaFiltroList);
}

class ZonaTuristicaCreateSuccess extends ZonaTuristicaState {}

class ZonaTuristicaUpdateSuccess extends ZonaTuristicaState {}

class ZonaTuristicaDeleteSuccess extends ZonaTuristicaState {}

class ZonaTuristicaError extends ZonaTuristicaState {
  final String message;
  ZonaTuristicaError(this.message);
}