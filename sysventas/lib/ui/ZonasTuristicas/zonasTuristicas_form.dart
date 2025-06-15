import 'dart:io';
import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:image_picker/image_picker.dart';
import 'package:cached_network_image/cached_network_image.dart';
import 'package:sysventas/bloc/ZonaTuristica/zonaTuristica_bloc.dart';
import 'package:sysventas/modelo/ZonasTuristicasModelo.dart';



class ZonaTuristicaForm extends StatefulWidget {
  const ZonaTuristicaForm({super.key});

  @override
  State<ZonaTuristicaForm> createState() => _ZonaTuristicaFormState();
}

class _ZonaTuristicaFormState extends State<ZonaTuristicaForm> {
  final _formKey = GlobalKey<FormState>();
  final TextEditingController _nombreController = TextEditingController();
  final TextEditingController _descripcionController = TextEditingController();
  final TextEditingController _ubicacionController = TextEditingController();

  String _estadoSeleccionado = 'activo';
  List<XFile> _imagenesSeleccionadas = [];

  final List<String> _estados = ['activo', 'pendiente', 'inactivo'];

  @override
  void dispose() {
    _nombreController.dispose();
    _descripcionController.dispose();
    _ubicacionController.dispose();
    super.dispose();
  }

  Future<void> _seleccionarImagenes() async {
    try {
      final List<XFile>? imagenes = await ImagePicker().pickMultiImage(
        imageQuality: 80,
        maxWidth: 1200,
      );
      if (imagenes != null && imagenes.isNotEmpty) {
        setState(() {
          if (_imagenesSeleccionadas.length + imagenes.length > 5) {
            ScaffoldMessenger.of(context).showSnackBar(
              const SnackBar(content: Text('Máximo 5 imágenes permitidas')),
            );
            return;
          }
          _imagenesSeleccionadas.addAll(imagenes);
        });
      }
    } catch (e) {
      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(content: Text('Error al seleccionar imágenes: $e')),
      );
    }
  }

  Future<void> _tomarFoto() async {
    try {
      final XFile? foto = await ImagePicker().pickImage(
        source: ImageSource.camera,
        imageQuality: 80,
        maxWidth: 1200,
      );
      if (foto != null) {
        setState(() {
          if (_imagenesSeleccionadas.length + 1 > 5) {
            ScaffoldMessenger.of(context).showSnackBar(
              const SnackBar(content: Text('Máximo 5 imágenes permitidas')),
            );
            return;
          }
          _imagenesSeleccionadas.add(foto);
        });
      }
    } catch (e) {
      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(content: Text('Error al tomar foto: $e')),
      );
    }
  }

  void _eliminarImagen(int index) {
    setState(() {
      _imagenesSeleccionadas.removeAt(index);
    });
  }

  void _guardarZonaTuristica() {
    if (_formKey.currentState!.validate()) {
      if (_imagenesSeleccionadas.isEmpty) {
        ScaffoldMessenger.of(context).showSnackBar(
          const SnackBar(content: Text('Por favor agregue al menos una imagen')),
        );
        return;
      }

      final dto = ZonaTuristicaDto(
        nombre: _nombreController.text.trim(),
        descripcion: _descripcionController.text.trim(),
        ubicacion: _ubicacionController.text.trim(),
        estado: _estadoSeleccionado,
        imagenUrl: [],
      );

      final imagenesFiles = _imagenesSeleccionadas.map((xfile) => File(xfile.path)).toList();

      context.read<ZonaTuristicaBloc>().add(
        CreateZonaTuristicaEvent(dto, imagenesFiles),
      );
    }
  }

  @override
  Widget build(BuildContext context) {
    return BlocListener<ZonaTuristicaBloc, ZonaTuristicaState>(
      listener: (context, state) {
        if (state is ZonaTuristicaLoadedState) {
          ScaffoldMessenger.of(context).showSnackBar(
            const SnackBar(content: Text('Zona turística guardada con éxito')),
          );
          Navigator.of(context).pop();
        }
        if (state is ZonaTuristicaError) {
          ScaffoldMessenger.of(context).showSnackBar(
            SnackBar(content: Text('Error: ${state.message}')),
          );
        }
      },
      child: Scaffold(
        appBar: AppBar(
          title: const Text('Nueva Zona Turística'),
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
              onPressed: _guardarZonaTuristica,
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
                TextFormField(
                  controller: _nombreController,
                  decoration: const InputDecoration(
                    labelText: 'Nombre de la zona turística',
                    border: OutlineInputBorder(),
                    prefixIcon: Icon(Icons.place),
                  ),
                  validator: (value) {
                    if (value == null || value.isEmpty) {
                      return 'Por favor ingrese un nombre';
                    }
                    return null;
                  },
                ),
                const SizedBox(height: 16),
                TextFormField(
                  controller: _descripcionController,
                  decoration: const InputDecoration(
                    labelText: 'Descripción',
                    border: OutlineInputBorder(),
                    prefixIcon: Icon(Icons.description),
                  ),
                  maxLines: 3,
                  validator: (value) {
                    if (value == null || value.isEmpty) {
                      return 'Por favor ingrese una descripción';
                    }
                    if (value.length < 20) {
                      return 'La descripción debe tener al menos 20 caracteres';
                    }
                    return null;
                  },
                ),
                const SizedBox(height: 16),
                TextFormField(
                  controller: _ubicacionController,
                  decoration: const InputDecoration(
                    labelText: 'Ubicación',
                    border: OutlineInputBorder(),
                    prefixIcon: Icon(Icons.location_on),
                  ),
                  validator: (value) {
                    if (value == null || value.isEmpty) {
                      return 'Por favor ingrese la ubicación';
                    }
                    return null;
                  },
                ),
                const SizedBox(height: 16),
                DropdownButtonFormField<String>(
                  value: _estadoSeleccionado,
                  decoration: const InputDecoration(
                    labelText: 'Estado',
                    border: OutlineInputBorder(),
                    prefixIcon: Icon(Icons.info),
                  ),
                  items: _estados.map((String estado) {
                    return DropdownMenuItem<String>(
                      value: estado,
                      child: Text(
                        estado[0].toUpperCase() + estado.substring(1),
                        style: TextStyle(
                          color: _getEstadoColor(estado),
                        ),
                      ),
                    );
                  }).toList(),
                  onChanged: (String? newValue) {
                    setState(() {
                      _estadoSeleccionado = newValue!;
                    });
                  },
                ),
                const SizedBox(height: 24),
                SizedBox(
                  width: double.infinity,
                  child: ElevatedButton(
                    onPressed: _guardarZonaTuristica,
                    style: ElevatedButton.styleFrom(
                      padding: const EdgeInsets.symmetric(vertical: 16),
                      backgroundColor: Colors.deepPurple,
                      foregroundColor: Colors.white,
                    ),
                    child: const Text(
                      'Guardar Zona Turística',
                      style: TextStyle(fontSize: 16),
                    ),
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

  Widget _buildImagenesSection() {
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        const Text(
          'Imágenes de la zona turística',
          style: TextStyle(fontSize: 16, fontWeight: FontWeight.bold),
        ),
        const SizedBox(height: 8),
        Text(
          'Agregue al menos una imagen (Máx. 5)',
          style: TextStyle(color: Colors.grey[600]),
        ),
        const SizedBox(height: 12),
        if (_imagenesSeleccionadas.isNotEmpty)
          SizedBox(
            height: 120,
            child: ListView.builder(
              scrollDirection: Axis.horizontal,
              itemCount: _imagenesSeleccionadas.length,
              itemBuilder: (context, index) {
                return Padding(
                  padding: const EdgeInsets.only(right: 8),
                  child: Stack(
                    children: [
                      ClipRRect(
                        borderRadius: BorderRadius.circular(8),
                        child: Image.file(
                          File(_imagenesSeleccionadas[index].path),
                          width: 120,
                          height: 120,
                          fit: BoxFit.cover,
                        ),
                      ),
                      Positioned(
                        top: 4,
                        right: 4,
                        child: GestureDetector(
                          onTap: () => _eliminarImagen(index),
                          child: Container(
                            decoration: const BoxDecoration(
                              color: Colors.red,
                              shape: BoxShape.circle,
                            ),
                            padding: const EdgeInsets.all(4),
                            child: const Icon(
                              Icons.close,
                              size: 16,
                              color: Colors.white,
                            ),
                          ),
                        ),
                      ),
                    ],
                  ),
                );
              },
            ),
          ),
        const SizedBox(height: 12),
        Row(
          children: [
            Expanded(
              child: OutlinedButton.icon(
                onPressed: _seleccionarImagenes,
                icon: const Icon(Icons.photo_library),
                label: const Text('Galería'),
                style: OutlinedButton.styleFrom(
                  padding: const EdgeInsets.symmetric(vertical: 12),
                ),
              ),
            ),
            const SizedBox(width: 12),
            Expanded(
              child: OutlinedButton.icon(
                onPressed: _tomarFoto,
                icon: const Icon(Icons.camera_alt),
                label: const Text('Cámara'),
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
    switch (estado.toLowerCase()) {
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