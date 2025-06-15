import 'dart:io';
import 'package:cached_network_image/cached_network_image.dart';
import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:sysventas/bloc/emprendimiento_bloc.dart';
import 'package:image_picker/image_picker.dart';
import 'package:sysventas/modelo/EmprendimientoModelo.dart';
import 'package:sysventas/modelo/TipoNegocioModelo.dart';


class EmprendimientoEdit extends StatefulWidget {
  final EmprendimientoResp emprendimiento;
  const EmprendimientoEdit({super.key, required this.emprendimiento});

  @override
  State<EmprendimientoEdit> createState() => _EditarEmprendimientoScreenState();
}

class _EditarEmprendimientoScreenState extends State<EmprendimientoEdit> {
  final _formKey = GlobalKey<FormState>();
  final ImagePicker _picker = ImagePicker();

  // Campos editables
  late String _nombre;
  late String _descripcion;
  late String _direccion;
  late String _telefono;
  String _estado = 'activo';
  int? _selectedTipoId;

  // Imágenes
  List<File> _nuevasImagenes = [];
  List<String> _imagenesExistentes = [];
  List<String> _imagenesAEliminar = [];

  // Tipos de negocio
  List<TipoDeNegocioResp> _tiposNegocio = [];

  @override
  void initState() {
    super.initState();
    // Precarga campos con datos del emprendimiento
    _nombre = widget.emprendimiento.nombre;
    _descripcion = widget.emprendimiento.descripcion;
    _direccion = widget.emprendimiento.direccion;
    _telefono = widget.emprendimiento.telefono;
    _estado = widget.emprendimiento.estado;
    _selectedTipoId = widget.emprendimiento.tipoNegocioId;
    _imagenesExistentes = List.from(widget.emprendimiento.imagenesUrl);

    // Solicita los tipos de negocio
    context.read<EmprendimientoBloc>().add(CreateEmprendimientoFormEvent());
  }

  Future<void> _pickImages() async {
    final pickedFiles = await _picker.pickMultiImage(
      imageQuality: 80,
      maxWidth: 1200,
    );
    if (pickedFiles != null) {
      setState(() {
        if (_imagenesExistentes.length + _nuevasImagenes.length + pickedFiles.length > 5) {
          _showError('Máximo 5 imágenes permitidas');
          return;
        }
        _nuevasImagenes.addAll(pickedFiles.map((e) => File(e.path)));
      });
    }
  }

  void _eliminarImagen(int index, {required bool esNueva}) {
    setState(() {
      if (esNueva) {
        _nuevasImagenes.removeAt(index);
      } else {
        _imagenesAEliminar.add(_imagenesExistentes[index]);
        _imagenesExistentes.removeAt(index);
      }
    });
  }

  void _showError(String mensaje) {
    ScaffoldMessenger.of(context).showSnackBar(
      SnackBar(content: Text(mensaje), backgroundColor: Colors.red),
    );
  }

  void _guardarCambios() {
    if (_formKey.currentState!.validate()) {
      if (_imagenesExistentes.isEmpty && _nuevasImagenes.isEmpty) {
        _showError('Debe mantener al menos una imagen');
        return;
      }
      if (_selectedTipoId == null) {
        _showError('Seleccione un tipo de negocio');
        return;
      }

      final dto = EmprendimientoDto(
        idEmprendimiento: widget.emprendimiento.idEmprendimiento,
        nombre: _nombre,
        descripcion: _descripcion,
        tipoNegocioId: _selectedTipoId!,
        direccion: _direccion,
        telefono: _telefono,
        estado: _estado,
        fechaRegistro: DateTime.now().toIso8601String(),
        imagenesUrl: [],
      );
      context.read<EmprendimientoBloc>().add(
        UpdateEmprendimientoEvent(
          idEmprendimiento: widget.emprendimiento.idEmprendimiento,
          emprendimiento: dto,
          nuevasImagenes: _nuevasImagenes,
          imagenesAEliminar: _imagenesAEliminar,
        ),
      );
    }
  }

  @override
  Widget build(BuildContext context) {
    return BlocListener<EmprendimientoBloc, EmprendimientoState>(
      listener: (context, state) {
        if (state is EmprendimientoUpdateSuccess) {
          ScaffoldMessenger.of(context).showSnackBar(
            const SnackBar(content: Text('Emprendimiento actualizado con éxito')),
          );
          Navigator.pop(context);
        }
        if (state is EmprendimientoError) {
          _showError(state.message);
        }
      },
      child: Scaffold(
        appBar: AppBar(
          title: const Text('Editar Emprendimiento'),
          automaticallyImplyLeading: false,  // Oculta la flecha por defecto
          leading: Container(), // Widget vacío (oculta el botón de retroceso)
          actions: [
            IconButton(
              icon: const Icon(Icons.save),
              onPressed: _guardarCambios,
            ),
          ],
        ),
        body: BlocBuilder<EmprendimientoBloc, EmprendimientoState>(
          builder: (context, state) {
            if (state is EmprendimientoLoadingState && _tiposNegocio.isEmpty) {
              return const Center(child: CircularProgressIndicator());
            }
            if (state is EmprendimientoLoadedFormState) {
              _tiposNegocio = state.tipoNegocio;
            }
            return SingleChildScrollView(
              padding: const EdgeInsets.all(16),
              child: Form(
                key: _formKey,
                child: Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    _buildImagenesSection(),
                    const SizedBox(height: 24),
                    // Campo Nombre
                    TextFormField(
                      initialValue: _nombre,
                      decoration: _inputDecoration('Nombre', Icons.business),
                      onChanged: (v) => _nombre = v,
                      validator: (value) =>
                      value == null || value.isEmpty ? 'Ingrese nombre' : null,
                    ),
                    const SizedBox(height: 16),
                    // Campo Descripción
                    TextFormField(
                      initialValue: _descripcion,
                      decoration: _inputDecoration('Descripción', Icons.description),
                      maxLines: 3,
                      onChanged: (v) => _descripcion = v,
                      validator: (value) {
                        if (value == null || value.isEmpty) {
                          return 'Ingrese una descripción';
                        }
                        if (value.length < 20) {
                          return 'La descripción debe tener al menos 20 caracteres';
                        }
                        return null;
                      },
                    ),
                    const SizedBox(height: 16),
                    // Campo Dirección
                    TextFormField(
                      initialValue: _direccion,
                      decoration: _inputDecoration('Dirección', Icons.location_on),
                      onChanged: (v) => _direccion = v,
                      validator: (value) =>
                      value == null || value.isEmpty ? 'Ingrese dirección' : null,
                    ),
                    const SizedBox(height: 16),
                    // Campo Teléfono
                    TextFormField(
                      initialValue: _telefono,
                      decoration: _inputDecoration('Teléfono', Icons.phone),
                      keyboardType: TextInputType.phone,
                      onChanged: (v) => _telefono = v,
                      validator: (value) =>
                      value == null || value.isEmpty ? 'Ingrese teléfono' : null,
                    ),
                    const SizedBox(height: 16),
                    // Selector de Estado
                    DropdownButtonFormField<String>(
                      value: _estado,
                      decoration: _inputDecoration('Estado', Icons.info),
                      items: ['activo', 'pendiente', 'inactivo'].map((estado) {
                        return DropdownMenuItem<String>(
                          value: estado,
                          child: Text(
                            estado[0].toUpperCase() + estado.substring(1),
                            style: TextStyle(color: _getEstadoColor(estado)),
                          ),
                        );
                      }).toList(),
                      onChanged: (value) => setState(() => _estado = value!),
                    ),
                    const SizedBox(height: 16),
                    // Selector de Tipo
                    DropdownButtonFormField<int>(
                      value: _selectedTipoId,
                      decoration: _inputDecoration('Tipo de negocio', Icons.category),
                      items: _tiposNegocio.map((tipo) {
                        return DropdownMenuItem<int>(
                          value: tipo.idTipoNegocio,
                          child: Text(tipo.nombre),
                        );
                      }).toList(),
                      onChanged: (int? value) {
                        setState(() => _selectedTipoId = value);
                      },
                      validator: (v) => v == null ? 'Seleccione un tipo' : null,
                    ),
                    const SizedBox(height: 24),
                    SizedBox(
                      width: double.infinity,
                      child: ElevatedButton(
                        onPressed: _guardarCambios,
                        style: ElevatedButton.styleFrom(
                          padding: const EdgeInsets.symmetric(vertical: 16),
                          backgroundColor: Colors.deepPurple,
                          foregroundColor: Colors.white,
                        ),
                        child: const Text('GUARDAR CAMBIOS', style: TextStyle(fontSize: 16)),
                      ),
                    ),
                    SizedBox(
                      width: double.infinity,
                      child: OutlinedButton.icon(
                        icon: const Icon(Icons.close),
                        label: const Text('Cancelar'),
                        onPressed: () => Navigator.of(context).pop(),
                      ),
                    ),
                    SizedBox(
                      width: double.infinity,
                      child: ElevatedButton(
                        onPressed: () => Navigator.of(context).pop(),
                        style: ElevatedButton.styleFrom(
                          padding: const EdgeInsets.symmetric(vertical: 16),
                          backgroundColor: Colors.red,
                          foregroundColor: Colors.white,
                        ),

                        child: const Text(
                          'Cancelar',
                          style: TextStyle(fontSize: 16),
                          
                        ),
                      ),
                    ),
                  ],
                ),
              ),
            );
          },
        ),
      ),
    );
  }

  InputDecoration _inputDecoration(String label, IconData icon) {
    return InputDecoration(
      labelText: label,
      border: const OutlineInputBorder(),
      prefixIcon: Icon(icon),
    );
  }

  Widget _buildImagenesSection() {
    final totalImagenes = _imagenesExistentes.length + _nuevasImagenes.length;
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        const Text(
          'Imágenes del emprendimiento',
          style: TextStyle(fontSize: 16, fontWeight: FontWeight.bold),
        ),
        const SizedBox(height: 8),
        Text(
          'Máximo 5 imágenes (${totalImagenes}/5)',
          style: TextStyle(color: Colors.grey[600]),
        ),
        const SizedBox(height: 12),
        if (totalImagenes > 0)
          SizedBox(
            height: 120,
            child: ListView(
              scrollDirection: Axis.horizontal,
              children: [
                ..._imagenesExistentes.asMap().entries.map((entry) {
                  final idx = entry.key;
                  final url = entry.value;
                  return Padding(
                    padding: const EdgeInsets.only(right: 8),
                    child: Stack(
                      children: [
                        ClipRRect(
                          borderRadius: BorderRadius.circular(8),
                          child: CachedNetworkImage(
                            imageUrl: url,
                            width: 120,
                            height: 120,
                            fit: BoxFit.cover,
                            placeholder: (context, url) => Container(
                              color: Colors.grey[200],
                              child: const Center(child: CircularProgressIndicator()),
                            ),
                            errorWidget: (context, url, error) => Container(
                              color: Colors.grey[200],
                              child: const Icon(Icons.error),
                            ),
                          ),
                        ),
                        Positioned(
                          top: 4,
                          right: 4,
                          child: GestureDetector(
                            onTap: () => _eliminarImagen(idx, esNueva: false),
                            child: Container(
                              decoration: const BoxDecoration(
                                color: Colors.red,
                                shape: BoxShape.circle,
                              ),
                              padding: const EdgeInsets.all(4),
                              child: const Icon(Icons.close, size: 16, color: Colors.white),
                            ),
                          ),
                        ),
                      ],
                    ),
                  );
                }),
                ..._nuevasImagenes.asMap().entries.map((entry) {
                  final idx = entry.key;
                  final file = entry.value;
                  return Padding(
                    padding: const EdgeInsets.only(right: 8),
                    child: Stack(
                      children: [
                        ClipRRect(
                          borderRadius: BorderRadius.circular(8),
                          child: Image.file(
                            file,
                            width: 120,
                            height: 120,
                            fit: BoxFit.cover,
                          ),
                        ),
                        Positioned(
                          top: 4,
                          right: 4,
                          child: GestureDetector(
                            onTap: () => _eliminarImagen(idx, esNueva: true),
                            child: Container(
                              decoration: const BoxDecoration(
                                color: Colors.red,
                                shape: BoxShape.circle,
                              ),
                              padding: const EdgeInsets.all(4),
                              child: const Icon(Icons.close, size: 16, color: Colors.white),
                            ),
                          ),
                        ),
                      ],
                    ),
                  );
                }),
              ],
            ),
          ),
        const SizedBox(height: 12),
        if (totalImagenes < 5)
          Row(
            children: [
              Expanded(
                child: OutlinedButton.icon(
                  onPressed: _pickImages,
                  icon: const Icon(Icons.photo_library),
                  label: const Text('Añadir de galería'),
                  style: OutlinedButton.styleFrom(
                    padding: const EdgeInsets.symmetric(vertical: 12),
                  ),
                ),
              ),
            ],
          ),
      ],
    );
  }

  Color _getEstadoColor(String estado) {
    switch (estado) {
      case 'activo':
        return Colors.green;
      case 'pendiente':
        return Colors.orange;
      case 'inactivo':
        return Colors.red;
      default:
        return Colors.grey;
    }
  }
}