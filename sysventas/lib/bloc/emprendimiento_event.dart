part of 'emprendimiento_bloc.dart';

@immutable
sealed class EmprendimientoEvent {}

class ListarEmprendimientoEvent extends EmprendimientoEvent{
  ListarEmprendimientoEvent(){}
}

class DeleteEmprendimientoEvent extends EmprendimientoEvent{
  final EmprendimientoResp emprendimiento;
  DeleteEmprendimientoEvent(this.emprendimiento);
}

class CreateEmprendimientoEvent extends EmprendimientoEvent {
  final EmprendimientoDto emprendimiento;
  final List<File> nuevasImagenes; // Add images here
  CreateEmprendimientoEvent(this.emprendimiento, this.nuevasImagenes);
}

class UpdateEmprendimientoEvent extends EmprendimientoEvent {
  final EmprendimientoDto emprendimiento;
  final int idEmprendimiento;
  final List<File> nuevasImagenes;
  final List<String> imagenesAEliminar;  // URLs or ids of images to delete
  UpdateEmprendimientoEvent({
    required this.idEmprendimiento,
    required this.emprendimiento,
    required this.nuevasImagenes,
    required this.imagenesAEliminar,
  });
}

class CreateEmprendimientoFormEvent extends EmprendimientoEvent{}

class FilterEmprendimientoEvent extends EmprendimientoEvent{
  String datoBuscado;
  FilterEmprendimientoEvent(this.datoBuscado);
}