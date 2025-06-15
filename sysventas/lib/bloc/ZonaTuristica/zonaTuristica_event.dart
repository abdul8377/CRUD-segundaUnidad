part of 'zonaTuristica_bloc.dart';

@immutable
sealed class EmprendimientoEvent {}

@immutable
sealed class ZonaTuristicaEvent {}

class ListarZonaTuristicaEvent extends ZonaTuristicaEvent {}

class DeleteZonaTuristicaEvent extends ZonaTuristicaEvent {
  final int id;
  DeleteZonaTuristicaEvent(this.id);
}

class CreateZonaTuristicaEvent extends ZonaTuristicaEvent {
  final ZonaTuristicaDto zonaTuristica;
  final List<File> nuevasImagenes; // Si tu modelo tiene imágenes
  CreateZonaTuristicaEvent(this.zonaTuristica, this.nuevasImagenes);
}

class UpdateZonaTuristicaEvent extends ZonaTuristicaEvent {
  final ZonaTuristicaDto zonaTuristica;
  final int idZonaTuristica;
  final List<File> nuevasImagenes;
  final List<String> imagenesAEliminar;  // URLs o ids de imágenes a eliminar
  UpdateZonaTuristicaEvent({
    required this.idZonaTuristica,
    required this.zonaTuristica,
    required this.nuevasImagenes,
    required this.imagenesAEliminar,
  });
}

// Para cargar datos para el formulario (ej: tipos de zona turística)
class CreateZonaTuristicaFormEvent extends ZonaTuristicaEvent {}

class FilterZonaTuristicaEvent extends ZonaTuristicaEvent {
  final String datoBuscado;
  FilterZonaTuristicaEvent(this.datoBuscado);
}