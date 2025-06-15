import 'dart:io';
import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:sysventas/bloc/emprendimiento_bloc.dart';
import 'package:image_picker/image_picker.dart';
import 'package:sysventas/modelo/EmprendimientoModelo.dart';
import 'package:sysventas/modelo/TipoNegocioModelo.dart';
// Importa aquí tu DTO, no el Modelo


class EmprendimientoForm extends StatefulWidget {
  const EmprendimientoForm({super.key});

  @override
  State<EmprendimientoForm> createState() => _CrearEmprendimientoScreenState();
}

class _CrearEmprendimientoScreenState extends State<EmprendimientoForm> {
  final _formKey = GlobalKey<FormState>();
  final TextEditingController _nombreController = TextEditingController();
  final TextEditingController _descripcionController = TextEditingController();
  final TextEditingController _direccionController = TextEditingController();
  final TextEditingController _telefonoController = TextEditingController();

  String _estadoSeleccionado = 'activo';
  int? _tipoSeleccionadoId;
  List<XFile> _imagenesSeleccionadas = [];

  final List<String> _estados = ['activo', 'pendiente', 'inactivo'];

  List<TipoDeNegocioResp> _tiposNegocio = [];

  @override
  void initState() {
    super.initState();
    // Solicita los tipos de negocio al iniciar
    context.read<EmprendimientoBloc>().add(CreateEmprendimientoFormEvent());
  }

  @override
  void dispose() {
    _nombreController.dispose();
    _descripcionController.dispose();
    _direccionController.dispose();
    _telefonoController.dispose();
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

  void _guardarEmprendimiento() {
    if (_formKey.currentState!.validate()) {
      if (_imagenesSeleccionadas.isEmpty) {
        ScaffoldMessenger.of(context).showSnackBar(
          const SnackBar(content: Text('Por favor agregue al menos una imagen')),
        );
        return;
      }
      if (_tipoSeleccionadoId == null) {
        ScaffoldMessenger.of(context).showSnackBar(
          const SnackBar(content: Text('Seleccione un tipo de negocio')),
        );
        return;
      }

      final dto = EmprendimientoDto(
        nombre: _nombreController.text.trim(),
        descripcion: _descripcionController.text.trim(),
        tipoNegocioId: _tipoSeleccionadoId!,
        direccion: _direccionController.text.trim(),
        telefono: _telefonoController.text.trim(),
        estado: _estadoSeleccionado,
        fechaRegistro: DateTime.now().toIso8601String(),
        imagenesUrl: [],
      );

      final imagenesFiles = _imagenesSeleccionadas.map((xfile) => File(xfile.path)).toList();

      context.read<EmprendimientoBloc>().add(
        CreateEmprendimientoEvent(dto, imagenesFiles),
      );
    }
  }

  @override
  Widget build(BuildContext context) {
    return BlocListener<EmprendimientoBloc, EmprendimientoState>(
      listener: (context, state) {
        if (state is EmprendimientoLoadedState) {
          ScaffoldMessenger.of(context).showSnackBar(
            const SnackBar(content: Text('Emprendimiento guardado con éxito')),
          );
          Navigator.of(context).pop();
        }
        if (state is EmprendimientoError) {
          ScaffoldMessenger.of(context).showSnackBar(
            SnackBar(content: Text('Error: ${state.message}')),
          );
        }
      },
      child: Scaffold(
        appBar: AppBar(
          title: const Text('Nuevo Emprendimiento'),
          automaticallyImplyLeading: false,  // Oculta la flecha por defecto
          leading: Container(), // Widget vacío (oculta el botón de retroceso)
          actions: [
            IconButton(
              icon: const Icon(Icons.save),
              onPressed: _guardarEmprendimiento,
            ),
          ],
        ),
        body: BlocBuilder<EmprendimientoBloc, EmprendimientoState>(
          builder: (context, state) {
            // Carga los tipos de negocio dinámicamente
            if (state is EmprendimientoLoadingState && _tiposNegocio.isEmpty) {
              return const Center(child: CircularProgressIndicator());
            }
            if (state is EmprendimientoLoadedFormState) {
              _tiposNegocio = state.tipoNegocio;
              // Selecciona el primer tipo como predeterminado si es la primera vez
              _tipoSeleccionadoId ??= _tiposNegocio.isNotEmpty ? _tiposNegocio.first.idTipoNegocio : null;
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
                    TextFormField(
                      controller: _nombreController,
                      decoration: const InputDecoration(
                        labelText: 'Nombre del emprendimiento',
                        border: OutlineInputBorder(),
                        prefixIcon: Icon(Icons.business),
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
                      controller: _direccionController,
                      decoration: const InputDecoration(
                        labelText: 'Dirección',
                        border: OutlineInputBorder(),
                        prefixIcon: Icon(Icons.location_on),
                      ),
                      validator: (value) {
                        if (value == null || value.isEmpty) {
                          return 'Por favor ingrese una dirección';
                        }
                        return null;
                      },
                    ),
                    const SizedBox(height: 16),
                    TextFormField(
                      controller: _telefonoController,
                      decoration: const InputDecoration(
                        labelText: 'Teléfono',
                        border: OutlineInputBorder(),
                        prefixIcon: Icon(Icons.phone),
                      ),
                      keyboardType: TextInputType.phone,
                      validator: (value) {
                        if (value == null || value.isEmpty) {
                          return 'Por favor ingrese un teléfono';
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
                    const SizedBox(height: 16),
                    DropdownButtonFormField<int>(
                      value: _tipoSeleccionadoId,
                      decoration: const InputDecoration(
                        labelText: 'Tipo de negocio',
                        border: OutlineInputBorder(),
                        prefixIcon: Icon(Icons.category),
                      ),
                      items: _tiposNegocio.map((tipo) {
                        return DropdownMenuItem<int>(
                          value: tipo.idTipoNegocio,
                          child: Text(tipo.nombre),
                        );
                      }).toList(),
                      onChanged: (int? newValue) {
                        setState(() {
                          _tipoSeleccionadoId = newValue;
                        });
                      },
                      validator: (v) => v == null ? 'Seleccione un tipo' : null,
                    ),
                    const SizedBox(height: 24),
                    SizedBox(
                      width: double.infinity,
                      child: ElevatedButton(
                        onPressed: _guardarEmprendimiento,
                        style: ElevatedButton.styleFrom(
                          padding: const EdgeInsets.symmetric(vertical: 16),
                          backgroundColor: Colors.deepPurple,
                          foregroundColor: Colors.white,
                        ),
                        child: const Text(
                          'Guardar Emprendimiento',
                          style: TextStyle(fontSize: 16),
                        ),
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

  Widget _buildImagenesSection() {
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        const Text(
          'Imágenes del emprendimiento',
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