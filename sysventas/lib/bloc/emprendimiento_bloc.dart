
import 'dart:io';

import 'package:bloc/bloc.dart';
import 'package:meta/meta.dart';
import 'package:sysventas/modelo/CategoriaModelo.dart';
import 'package:sysventas/modelo/EmprendimientoModelo.dart';
import 'package:sysventas/modelo/MarcaModelo.dart';
import 'package:sysventas/modelo/ProductoModelo.dart';
import 'package:sysventas/modelo/TipoNegocioModelo.dart';
import 'package:sysventas/modelo/UnidadMedidaModelo.dart';
import 'package:sysventas/repository/CategoriaRepository.dart';
import 'package:sysventas/repository/EmprendimientoRepository.dart';
import 'package:sysventas/repository/MarcaRepository.dart';
import 'package:sysventas/repository/ProductoRepository.dart';
import 'package:sysventas/repository/TipoNegocioRepository.dart';
import 'package:sysventas/repository/UnidadMedidaRepository.dart';

part 'emprendimiento_event.dart';
part 'emprendimiento_state.dart';



class EmprendimientoBloc
    extends Bloc<EmprendimientoEvent, EmprendimientoState> {
  final EmprendimientoRepository _emprendimientoRepository;
  final TipoNegocioRepository _tipoNegocioRepository;

  EmprendimientoBloc(
      this._emprendimientoRepository,
      this._tipoNegocioRepository,
      ) : super(EmprendimientoInitialState()) {
    on<ListarEmprendimientoEvent>(_onListar);
    on<CreateEmprendimientoEvent>(_onCreate);
    on<UpdateEmprendimientoEvent>(_onUpdate);
    on<DeleteEmprendimientoEvent>(_onDelete);
    on<FilterEmprendimientoEvent>(_onFilter);
    on<CreateEmprendimientoFormEvent>(_onLoadForm);
  }

  Future<void> _onListar(
      ListarEmprendimientoEvent event,
      Emitter<EmprendimientoState> emit,
      ) async {
    emit(EmprendimientoLoadingState());
    try {
      final list = await _emprendimientoRepository.getEntidad();
      emit(EmprendimientoLoadedState(list));
    } catch (e) {
      emit(EmprendimientoError(e.toString()));
    }
  }

  Future<void> _onCreate(
      CreateEmprendimientoEvent event,
      Emitter<EmprendimientoState> emit,
      ) async {
    emit(EmprendimientoLoadingState());
    try {
      // Llamamos al repository para crear un emprendimiento con imágenes
      await _emprendimientoRepository.createWithImages(
        event.emprendimiento,
        event.nuevasImagenes,
      );
      final list = await _emprendimientoRepository.getEntidad();
      emit(EmprendimientoLoadedState(list));
    } catch (e) {
      emit(EmprendimientoError(e.toString()));
    }
  }

  // dentro de tu handler de update en el BLoC:
  Future<void> _onUpdate(
      UpdateEmprendimientoEvent event,
      Emitter<EmprendimientoState> emit,
      ) async {
    emit(EmprendimientoLoadingState());
    try {
      // Esto te devuelve directamente el modelo ya parseado:
      await _emprendimientoRepository.updateWithImages(
        event.idEmprendimiento,
        event.emprendimiento,
        event.nuevasImagenes,
        event.imagenesAEliminar,
      );

      emit(EmprendimientoUpdateSuccess());       // <= aquí

      // Luego refrescas la lista (o puedes propagar el 'actualizado'):
      final list = await _emprendimientoRepository.getEntidad();
      emit(EmprendimientoLoadedState(list));
    } catch (e) {
      emit(EmprendimientoError(e.toString()));
    }
  }

  Future<void> _onDelete(
      DeleteEmprendimientoEvent event,
      Emitter<EmprendimientoState> emit,
      ) async {
    emit(EmprendimientoLoadingState());
    try {
      await _emprendimientoRepository.deleteEntidad(event.emprendimiento.idEmprendimiento);
      final list = await _emprendimientoRepository.getEntidad();
      emit(EmprendimientoLoadedState(list));
    } catch (e) {
      emit(EmprendimientoError(e.toString()));
    }
  }

  Future<void> _onFilter(
      FilterEmprendimientoEvent event,
      Emitter<EmprendimientoState> emit,
      ) async {
    emit(EmprendimientoLoadingState());
    try {
      final all = await _emprendimientoRepository.getEntidad();
      final filtered = all.where((e) =>
          e.nombre.toLowerCase().contains(event.datoBuscado.toLowerCase())
      ).toList();
      emit(EmprendimientoLoadedFilterState(all, filtered));
    } catch (e) {
      emit(EmprendimientoError(e.toString()));
    }
  }

  Future<void> _onLoadForm(
      CreateEmprendimientoFormEvent event,
      Emitter<EmprendimientoState> emit,
      ) async {
    emit(EmprendimientoLoadingState());
    try {
      final tipos = await _tipoNegocioRepository.getAll(); // List<TipoDeNegocioResp>
      emit(EmprendimientoLoadedFormState(tipos));
    } catch (e) {
      emit(EmprendimientoError(e.toString()));
    }
  }
}