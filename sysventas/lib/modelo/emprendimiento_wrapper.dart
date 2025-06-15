

import 'package:sysventas/modelo/EmprendimientoModelo.dart';

class EmprendimientoWrapper {
  final String message;
  final EmprendimientoResp emprendimiento;

  EmprendimientoWrapper({
    required this.message,
    required this.emprendimiento,
  });

  factory EmprendimientoWrapper.fromJson(Map<String,dynamic> json) {
    return EmprendimientoWrapper(
      message: json['message'] as String,
      emprendimiento: EmprendimientoResp.fromJson(
          json['emprendimiento'] as Map<String,dynamic>
      ),
    );
  }
}