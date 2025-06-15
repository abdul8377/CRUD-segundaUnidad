import 'dart:ffi';

import 'package:sysventas/apis/categoria_api.dart';
import 'package:sysventas/apis/marca_api.dart';
import 'package:sysventas/apis/producto_api.dart';
import 'package:sysventas/apis/unidadmedida_api.dart';
import 'package:sysventas/comp/DropDownFormField.dart';
import 'package:sysventas/modelo/CategoriaModelo.dart';
import 'package:sysventas/modelo/MarcaModelo.dart';
import 'package:sysventas/modelo/ProductoModelo.dart';
import 'package:sysventas/modelo/TipoNegocioModelo.dart';
import 'package:sysventas/modelo/UnidadMedidaModelo.dart';
import 'package:sysventas/repository/TipoNegocioRepository.dart';
import 'package:sysventas/theme/AppTheme.dart';
import 'package:sysventas/util/TokenUtil.dart';
import 'package:checkbox_grouped/checkbox_grouped.dart';
import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:geolocator/geolocator.dart';
import 'package:intl/intl.dart';
import 'package:provider/provider.dart';
import 'package:shared_preferences/shared_preferences.dart';


class TipoNegocioFormEdit extends StatefulWidget {
  final TipoDeNegocioResp model;

  TipoNegocioFormEdit({required this.model});

  @override
  _TipoNegocioFormEditState createState() => _TipoNegocioFormEditState();
}

class _TipoNegocioFormEditState extends State<TipoNegocioFormEdit> {
  final _formKey = GlobalKey<FormState>();
  late TextEditingController _nombreController;
  late TextEditingController _descripcionController;
  bool _isSaving = false;

  @override
  void initState() {
    super.initState();
    _nombreController =
        TextEditingController(text: widget.model.nombre);
    _descripcionController =
        TextEditingController(text: widget.model.descripcion ?? '');
  }

  @override
  void dispose() {
    _nombreController.dispose();
    _descripcionController.dispose();
    super.dispose();
  }

  Future<void> _saveChanges() async {
    if (!_formKey.currentState!.validate()) return;

    setState(() {
      _isSaving = true;
    });

    final updatedDto = TipoDeNegocioDto(
      nombre: _nombreController.text.trim(),
      descripcion: _descripcionController.text.trim().isEmpty
          ? null
          : _descripcionController.text.trim(),
    );

    try {
      await TipoNegocioRepository().update(
        widget.model.idTipoNegocio,
        updatedDto,
      );
      // Al sobrescribir, devolvemos true para indicar éxito
      Navigator.of(context).pop(true);
    } catch (e) {
      setState(() {
        _isSaving = false;
      });
      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(content: Text('Error al actualizar: $e')),
      );
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text('Editar Tipo de Negocio'),
        centerTitle: true,
      ),
      body: SingleChildScrollView(
        padding: const EdgeInsets.all(16.0),
        child: AbsorbPointer(
          absorbing: _isSaving,
          child: Form(
            key: _formKey,
            child: Column(
              children: [
                // Campo Nombre
                TextFormField(
                  controller: _nombreController,
                  decoration: InputDecoration(
                    labelText: 'Nombre',
                    border: OutlineInputBorder(),
                  ),
                  validator: (value) {
                    if (value == null || value.trim().isEmpty) {
                      return 'El nombre es obligatorio';
                    }
                    return null;
                  },
                ),
                const SizedBox(height: 16),
                // Campo Descripción
                TextFormField(
                  controller: _descripcionController,
                  decoration: InputDecoration(
                    labelText: 'Descripción',
                    border: OutlineInputBorder(),
                  ),
                  maxLines: 3,
                ),
                const SizedBox(height: 24),
                // Botones Cancelar / Guardar
                Row(
                  mainAxisAlignment: MainAxisAlignment.spaceEvenly,
                  children: [
                    OutlinedButton(
                      onPressed: _isSaving
                          ? null
                          : () {
                        Navigator.of(context).pop(false);
                      },
                      child: Text('Cancelar'),
                    ),
                    ElevatedButton(
                      onPressed:
                      _isSaving ? null : () => _saveChanges(),
                      child: _isSaving
                          ? SizedBox(
                        width: 20,
                        height: 20,
                        child: CircularProgressIndicator(
                          strokeWidth: 2,
                          color: Colors.white,
                        ),
                      )
                          : Text('Guardar'),
                    ),
                  ],
                ),
              ],
            ),
          ),
        ),
      ),
    );
  }
}