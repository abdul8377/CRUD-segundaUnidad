import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:sysventas/bloc/emprendimiento_bloc.dart';
import 'package:sysventas/modelo/EmprendimientoModelo.dart';
import 'package:sysventas/repository/EmprendimientoRepository.dart';
import 'package:sysventas/repository/TipoNegocioRepository.dart';
import 'package:sysventas/ui/Emprendimiento/emprendimiento_edit.dart';
import 'package:sysventas/ui/Emprendimiento/emprendimiento_form.dart';

import 'package:cached_network_image/cached_network_image.dart';
import 'package:carousel_slider/carousel_slider.dart';

class EmprendimientoMain extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return MultiBlocProvider(
      providers: [
        BlocProvider(
          create: (_) => EmprendimientoBloc(
            EmprendimientoRepository(),
            TipoNegocioRepository(),
          )..add(ListarEmprendimientoEvent()),
        ),
        // Aquí podrías poner otros bloc si lo necesitas (como TipoNegocioBloc si lo usas aparte)
      ],
      child: MaterialApp(
        debugShowCheckedModeBanner: false,
        home: EmprendimientosUI(),
      ),
    );
  }
}

class EmprendimientosUI extends StatefulWidget {
  @override
  _EmprendimientosUIState createState() => _EmprendimientosUIState();
}

class _EmprendimientosUIState extends State<EmprendimientosUI> {
  // Mapa para mostrar el nombre del tipo de negocio
  Map<int, String> tipoNegocioNombres = {};

  @override
  void initState() {
    super.initState();
    // Al iniciar puedes cargar los tipos de negocio si es necesario
    _fetchTipoNegocio();
  }

  Future<void> _fetchTipoNegocio() async {
    final tipos = await TipoNegocioRepository().getAll();
    setState(() {
      tipoNegocioNombres = {
        for (var t in tipos) t.idTipoNegocio: t.nombre,
      };
    });
  }

  // Para refrescar luego de volver de agregar o editar
  Future onGoBack(dynamic value) async {
    setState(() {});
    // Opcional: podrías volver a pedir la lista si hace falta
    context.read<EmprendimientoBloc>().add(ListarEmprendimientoEvent());
  }

  @override
  Widget build(BuildContext context) {
    final TextEditingController _searchController = TextEditingController();
    return Scaffold(
      appBar: AppBar(
        title: const Text('Emprendimientos'),
        centerTitle: true,

      ),
      body: Column(
        children: [
          Padding(
            padding: const EdgeInsets.all(12.0),
            child: TextField(
              controller: _searchController,
              decoration: InputDecoration(
                hintText: 'Buscar emprendimiento...',
                prefixIcon: Icon(Icons.search),
                border: OutlineInputBorder(borderRadius: BorderRadius.circular(30)),
                filled: true,
                fillColor: Colors.grey[100],
              ),
              onChanged: (value) {
                context.read<EmprendimientoBloc>().add(FilterEmprendimientoEvent(value));
              },
            ),
          ),
          Expanded(
            child: BlocBuilder<EmprendimientoBloc, EmprendimientoState>(
              builder: (context, state) {
                if (state is EmprendimientoLoadingState) {
                  return const Center(child: CircularProgressIndicator());
                }
                if (state is EmprendimientoLoadedFilterState) {
                  final emprendimientos = state.EmprendimientoFiltroList;
                  if (emprendimientos.isEmpty) {
                    return const Center(child: Text('No se encontraron resultados'));
                  }
                  return ListView.builder(
                    padding: const EdgeInsets.all(8),
                    itemCount: emprendimientos.length,
                    itemBuilder: (context, index) {
                      final emprendimiento = emprendimientos[index];
                      return _buildEmprendimientoCard(context, emprendimiento);
                    },
                  );
                }
                if (state is EmprendimientoLoadedState) {
                  final emprendimientos = state.EmprendimientoList;
                  if (emprendimientos.isEmpty) {
                    return const Center(child: Text('No hay emprendimientos'));
                  }
                  return ListView.builder(
                    padding: const EdgeInsets.all(8),
                    itemCount: emprendimientos.length,
                    itemBuilder: (context, index) {
                      final emprendimiento = emprendimientos[index];
                      return _buildEmprendimientoCard(context, emprendimiento);
                    },
                  );
                }
                if (state is EmprendimientoError) {
                  return Center(child: Text(state.message));
                }
                return const Center(child: Text('Carga inicial...'));
              },
            ),
          ),
        ],
      ),
      floatingActionButton: FloatingActionButton(
        backgroundColor: Colors.deepPurple,
        child: const Icon(Icons.add, color: Colors.white),
        onPressed: () async {
          await Navigator.push(
            context,
            MaterialPageRoute(builder: (_) => EmprendimientoForm()),
          );
          context.read<EmprendimientoBloc>().add(ListarEmprendimientoEvent());
          _searchController.clear();
        },
      ),
    );
  }

  Widget _buildEmprendimientoCard(BuildContext context, EmprendimientoResp emprendimiento) {
    return Card(
      elevation: 4,
      shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(12)),
      margin: const EdgeInsets.only(bottom: 16),
      child: InkWell(
        borderRadius: BorderRadius.circular(12),
        onTap: () {},
        child: Padding(
          padding: const EdgeInsets.all(12),
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              _buildImageCarousel(emprendimiento.imagenesUrl),
              const SizedBox(height: 12),
              Row(
                mainAxisAlignment: MainAxisAlignment.spaceBetween,
                children: [
                  Expanded(
                    child: Text(
                      emprendimiento.nombre,
                      style: const TextStyle(fontSize: 20, fontWeight: FontWeight.bold),
                      overflow: TextOverflow.ellipsis,
                    ),
                  ),
                  Container(
                    padding: const EdgeInsets.symmetric(horizontal: 8, vertical: 4),
                    decoration: BoxDecoration(
                      color: _getEstadoColor(emprendimiento.estado).withOpacity(0.2),
                      borderRadius: BorderRadius.circular(12),
                      border: Border.all(
                        color: _getEstadoColor(emprendimiento.estado),
                        width: 1,
                      ),
                    ),
                    child: Text(
                      emprendimiento.estado.toUpperCase(),
                      style: TextStyle(
                        color: _getEstadoColor(emprendimiento.estado),
                        fontSize: 12,
                        fontWeight: FontWeight.bold,
                      ),
                    ),
                  ),
                ],
              ),
              const SizedBox(height: 8),
              Chip(
                label: Text(
                  (tipoNegocioNombres[emprendimiento.tipoNegocioId] ?? 'Sin tipo').toUpperCase(),
                  style: const TextStyle(fontSize: 12),
                ),
                backgroundColor: Colors.blue[50],
                side: BorderSide.none,
              ),
              const SizedBox(height: 8),
              Text(
                emprendimiento.descripcion,
                style: TextStyle(
                  fontSize: 14,
                  color: Colors.grey[700],
                ),
              ),
              const SizedBox(height: 12),
              _buildInfoRow(Icons.location_on, emprendimiento.direccion),
              _buildInfoRow(Icons.phone, emprendimiento.telefono),
              const SizedBox(height: 8),
              Align(
                alignment: Alignment.centerRight,
                child: ElevatedButton.icon(
                  onPressed: () async {
                    await Navigator.push(
                      context,
                      MaterialPageRoute(
                        builder: (_) => EmprendimientoEdit(emprendimiento: emprendimiento),
                      ),
                    ).then(onGoBack);
                  },
                  icon: const Icon(Icons.edit, size: 18),
                  label: const Text('Editar'),
                  style: ElevatedButton.styleFrom(
                    backgroundColor: Colors.deepPurple,
                    foregroundColor: Colors.white,
                    shape: RoundedRectangleBorder(
                      borderRadius: BorderRadius.circular(20),
                    ),
                    padding: const EdgeInsets.symmetric(horizontal: 16, vertical: 8),
                  ),
                ),
              ),
            ],
          ),
        ),
      ),
    );
  }

  Widget _buildImageCarousel(List<String> imagenes) {
    if (imagenes.isEmpty) {
      return Container(
        height: 180,
        color: Colors.grey[300],
        child: const Center(child: Icon(Icons.image, size: 60, color: Colors.white)),
      );
    }
    return ClipRRect(
      borderRadius: BorderRadius.circular(8),
      child: CarouselSlider(
        options: CarouselOptions(
          height: 180,
          autoPlay: true,
          aspectRatio: 16 / 9,
          viewportFraction: 1,
          autoPlayInterval: const Duration(seconds: 3),
        ),
        items: imagenes.map((imageUrl) {
          return CachedNetworkImage(
            imageUrl: imageUrl,
            fit: BoxFit.cover,
            width: double.infinity,
            placeholder: (context, url) => Container(
              color: Colors.grey[200],
              child: const Center(child: CircularProgressIndicator()),
            ),
            errorWidget: (context, url, error) => Container(
              color: Colors.grey[200],
              child: const Icon(Icons.error),
            ),
          );
        }).toList(),
      ),
    );
  }

  Widget _buildInfoRow(IconData icon, String text) {
    return Padding(
      padding: const EdgeInsets.only(bottom: 6),
      child: Row(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Icon(icon, size: 16, color: Colors.deepPurple),
          const SizedBox(width: 8),
          Expanded(
            child: Text(
              text,
              style: const TextStyle(fontSize: 14),
            ),
          ),
        ],
      ),
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