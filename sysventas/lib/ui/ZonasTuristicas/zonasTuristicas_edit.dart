import 'dart:io';
import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:image_picker/image_picker.dart';
import 'package:cached_network_image/cached_network_image.dart';
import 'package:sysventas/bloc/ZonaTuristica/emprendimiento_bloc.dart';
import 'package:sysventas/modelo/ZonasTuristicasModelo.dart';


class ZonaTuristicaEdit extends StatefulWidget {
  final ZonaTuristicaResp zona;
  const ZonaTuristicaEdit({super.key, required this.zona});

  @override
  State<ZonaTuristicaEdit> createState() => _ZonaTuristicaEditState();
}

class _ZonaTuristicaEditState extends State<ZonaTuristicaEdit> {
  final _formKey = GlobalKey<FormState>();
  final ImagePicker _picker = ImagePicker();

  late String _nombre;
  late String _descripcion;
  late String _ubicacion;
  String _estado = 'activo';

  List<File> _nuevasImagenes = [];
  List<String> _imagenesExistentes = [];
  List<String> _imagenesAEliminar = [];

  @override
  void initState() {
    super.initState();
    _nombre = widget.zona.nombre;
    _descripcion = widget.zona.descripcion;
    _ubicacion = widget.zona.ubicacion;
    _estado = widget.zona.estado;
    _imagenesExistentes = List.from(widget.zona.imagenesUrl);
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
      final dto = ZonaTuristicaDto(
        idZonasTuristicas: widget.zona.idZonasTuristicas,
        nombre: _nombre,
        descripcion: _descripcion,
        ubicacion: _ubicacion,
        estado: _estado,
        imagenUrl: [],
      );
      context.read<ZonaTuristicaBloc>().add(
        UpdateZonaTuristicaEvent(
          idZonaTuristica: widget.zona.idZonasTuristicas,
          zonaTuristica: dto,
          nuevasImagenes: _nuevasImagenes,
          imagenesAEliminar: _imagenesAEliminar,
        ),
      );
    }
  }

  @override
  Widget build(BuildContext context) {
    return BlocListener<ZonaTuristicaBloc, ZonaTuristicaState>(
      listener: (context, state) {
        if (state is ZonaTuristicaUpdateSuccess) {
          ScaffoldMessenger.of(context).showSnackBar(
            const SnackBar(content: Text('Zona turística actualizada con éxito')),
          );
          Navigator.pop(context);
        }
        if (state is ZonaTuristicaError) {
          _showError(state.message);
        }
      },
      child: Scaffold(
        appBar: AppBar(
          title: const Text('Editar Zona Turística'),
          centerTitle: true,
          automaticallyImplyLeading: false,
          leading: IconButton(
            icon: const Icon(Icons.close),
            tooltip: 'Cancelar',
            onPressed: () => Navigator.of(context).pop(),
          ),
          actions: [
            IconButton(
              icon: const Icon(Icons.save),
              tooltip: 'Guardar',
              onPressed: _guardarCambios,
            ),
          ],
        ),
        body: SingleChildScrollView(
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
                  decoration: _inputDecoration('Nombre', Icons.place),
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
                // Campo Ubicación
                TextFormField(
                  initialValue: _ubicacion,
                  decoration: _inputDecoration('Ubicación', Icons.map),
                  onChanged: (v) => _ubicacion = v,
                  validator: (value) =>
                  value == null || value.isEmpty ? 'Ingrese ubicación' : null,
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
              ],
            ),
          ),
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
          'Imágenes de la zona turística',
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