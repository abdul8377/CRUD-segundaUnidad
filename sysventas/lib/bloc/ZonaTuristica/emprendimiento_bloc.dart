
import 'dart:io';

import 'package:bloc/bloc.dart';
import 'package:meta/meta.dart';
import 'package:sysventas/modelo/ZonasTuristicasModelo.dart';
import 'package:sysventas/repository/ZonaTuristicaRepository.dart';

part 'emprendimiento_event.dart';
part 'emprendimiento_state.dart';



class ZonaTuristicaBloc extends Bloc<ZonaTuristicaEvent, ZonaTuristicaState> {
  final ZonaTuristicaRepository _zonaTuristicaRepository;

  ZonaTuristicaBloc(
      this._zonaTuristicaRepository,
      ) : super(ZonaTuristicaInitialState()) {
    on<ListarZonaTuristicaEvent>(_onListar);
    on<CreateZonaTuristicaEvent>(_onCreate);
    on<UpdateZonaTuristicaEvent>(_onUpdate);
    on<DeleteZonaTuristicaEvent>(_onDelete);
    on<FilterZonaTuristicaEvent>(_onFilter);
    on<CreateZonaTuristicaFormEvent>(_onLoadForm);
  }

  Future<void> _onListar(
      ListarZonaTuristicaEvent event,
      Emitter<ZonaTuristicaState> emit,
      ) async {
    emit(ZonaTuristicaLoadingState());
    try {
      final list = await _zonaTuristicaRepository.getEntidad();
      emit(ZonaTuristicaLoadedState(list));
    } catch (e) {
      emit(ZonaTuristicaError(e.toString()));
    }
  }

  Future<void> _onCreate(
      CreateZonaTuristicaEvent event,
      Emitter<ZonaTuristicaState> emit,
      ) async {
    emit(ZonaTuristicaLoadingState());
    try {
      await _zonaTuristicaRepository.createWithImages(
        event.zonaTuristica,
        event.nuevasImagenes,
      );
      final list = await _zonaTuristicaRepository.getEntidad();
      emit(ZonaTuristicaLoadedState(list));
      emit(ZonaTuristicaCreateSuccess());
    } catch (e) {
      emit(ZonaTuristicaError(e.toString()));
    }
  }

  Future<void> _onUpdate(
      UpdateZonaTuristicaEvent event,
      Emitter<ZonaTuristicaState> emit,
      ) async {
    emit(ZonaTuristicaLoadingState());
    try {
      await _zonaTuristicaRepository.updateWithImages(
        event.idZonaTuristica,
        event.zonaTuristica,
        event.nuevasImagenes,
        event.imagenesAEliminar,
      );
      final list = await _zonaTuristicaRepository.getEntidad();
      emit(ZonaTuristicaLoadedState(list));
      emit(ZonaTuristicaUpdateSuccess());
    } catch (e) {
      emit(ZonaTuristicaError(e.toString()));
    }
  }

  Future<void> _onDelete(
      DeleteZonaTuristicaEvent event,
      Emitter<ZonaTuristicaState> emit,
      ) async {
    print(">>> Bloc recibió DeleteZonaTuristicaEvent con id: ${event.id}");
    emit(ZonaTuristicaLoadingState());
    try {
      await _zonaTuristicaRepository.deleteEntidad(event.id);
      final list = await _zonaTuristicaRepository.getEntidad();
      emit(ZonaTuristicaLoadedState(list));
      emit(ZonaTuristicaDeleteSuccess());
    } catch (e) {
      emit(ZonaTuristicaError(e.toString()));
    }
  }

  Future<void> _onFilter(
      FilterZonaTuristicaEvent event,
      Emitter<ZonaTuristicaState> emit,
      ) async {
    emit(ZonaTuristicaLoadingState());
    try {
      final all = await _zonaTuristicaRepository.getEntidad();
      final filtered = all.where((e) =>
          e.nombre.toLowerCase().contains(event.datoBuscado.toLowerCase())
      ).toList();
      emit(ZonaTuristicaLoadedFilterState(all, filtered));
    } catch (e) {
      emit(ZonaTuristicaError(e.toString()));
    }
  }

  Future<void> _onLoadForm(
      CreateZonaTuristicaFormEvent event,
      Emitter<ZonaTuristicaState> emit,
      ) async {
    emit(ZonaTuristicaLoadingState());
    try {
      emit(ZonaTuristicaLoadedFormState());
    } catch (e) {
      emit(ZonaTuristicaError(e.toString()));
    }
  }
}