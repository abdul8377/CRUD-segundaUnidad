import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:sysventas/bloc/ZonaTuristica/emprendimiento_bloc.dart';
import 'package:sysventas/bloc/emprendimiento_bloc.dart';
import 'package:sysventas/modelo/EmprendimientoModelo.dart';
import 'package:sysventas/modelo/ZonasTuristicasModelo.dart';
import 'package:sysventas/repository/EmprendimientoRepository.dart';
import 'package:sysventas/repository/TipoNegocioRepository.dart';
import 'package:sysventas/repository/ZonaTuristicaRepository.dart';
import 'package:sysventas/ui/Emprendimiento/emprendimiento_edit.dart';
import 'package:sysventas/ui/Emprendimiento/emprendimiento_form.dart';

import 'package:cached_network_image/cached_network_image.dart';
import 'package:carousel_slider/carousel_slider.dart';
import 'package:sysventas/ui/ZonasTuristicas/zonasTuristicas_edit.dart';
import 'package:sysventas/ui/ZonasTuristicas/zonasTuristicas_form.dart';


class ZonasTuristicasMain extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return MultiBlocProvider(
      providers: [
        BlocProvider(
          create: (_) => ZonaTuristicaBloc(
            ZonaTuristicaRepository(),
          )..add(ListarZonaTuristicaEvent()),
        ),
      ],
      child: MaterialApp(
        debugShowCheckedModeBanner: false,
        home: ZonasTuristicasUI(),
      ),
    );
  }
}

class ZonasTuristicasUI extends StatefulWidget {
  @override
  _ZonasTuristicasUIState createState() => _ZonasTuristicasUIState();
}

class _ZonasTuristicasUIState extends State<ZonasTuristicasUI> {
  final TextEditingController _searchController = TextEditingController();
  Map<int, String> tipoZonaNombres = {};

  Future onGoBack(dynamic value) async {
    setState(() {});
    context.read<ZonaTuristicaBloc>().add(ListarZonaTuristicaEvent());
  }

  @override
  Widget build(BuildContext context) {
    return BlocListener<ZonaTuristicaBloc, ZonaTuristicaState>(
      listener: (context, state) {
        if (state is ZonaTuristicaDeleteSuccess) {
          ScaffoldMessenger.of(context).showSnackBar(
            const SnackBar(content: Text('Zona turística eliminada')),
          );
          // Si quieres refrescar la lista después de eliminar:
          context.read<ZonaTuristicaBloc>().add(ListarZonaTuristicaEvent());
        }
        if (state is ZonaTuristicaError) {
          ScaffoldMessenger.of(context).showSnackBar(
            SnackBar(content: Text(state.message)),
          );
        }
      },
      child: Scaffold(
        appBar: AppBar(
          title: const Text('Zonas Turísticas'),
          centerTitle: true,
        ),
        body: Column(
          children: [
            Padding(
              padding: const EdgeInsets.all(12.0),
              child: TextField(
                controller: _searchController,
                decoration: InputDecoration(
                  hintText: 'Buscar zona turística...',
                  prefixIcon: Icon(Icons.search),
                  border: OutlineInputBorder(borderRadius: BorderRadius.circular(30)),
                  filled: true,
                  fillColor: Colors.grey[100],
                ),
                onChanged: (value) {
                  context.read<ZonaTuristicaBloc>().add(FilterZonaTuristicaEvent(value));
                },
              ),
            ),
            Expanded(
              child: BlocBuilder<ZonaTuristicaBloc, ZonaTuristicaState>(
                builder: (context, state) {
                  if (state is ZonaTuristicaLoadingState) {
                    return const Center(child: CircularProgressIndicator());
                  }
                  if (state is ZonaTuristicaLoadedFilterState) {
                    final zonas = state.zonaTuristicaFiltroList;
                    if (zonas.isEmpty) {
                      return const Center(child: Text('No se encontraron resultados'));
                    }
                    return ListView.builder(
                      padding: const EdgeInsets.all(8),
                      itemCount: zonas.length,
                      itemBuilder: (context, index) {
                        return _buildZonaCard(context, zonas[index]);
                      },
                    );
                  }
                  if (state is ZonaTuristicaLoadedState) {
                    final zonas = state.zonaTuristicaList;
                    if (zonas.isEmpty) {
                      return const Center(child: Text('No hay zonas turísticas'));
                    }
                    return ListView.builder(
                      padding: const EdgeInsets.all(8),
                      itemCount: zonas.length,
                      itemBuilder: (context, index) {
                        return _buildZonaCard(context, zonas[index]);
                      },
                    );
                  }
                  // No manejes efectos secundarios aquí (solo retorna widgets)
                  if (state is ZonaTuristicaError) {
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
              MaterialPageRoute(builder: (_) => ZonaTuristicaForm()),
            );
            context.read<ZonaTuristicaBloc>().add(ListarZonaTuristicaEvent());
            _searchController.clear();
          },
        ),
      ),
    );
  }


  Widget _buildZonaCard(BuildContext context, ZonaTuristicaResp zona) {
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
              _buildImageCarousel(zona.imagenesUrl), // Usa tu campo real
              const SizedBox(height: 12),
              Row(
                mainAxisAlignment: MainAxisAlignment.spaceBetween,
                children: [
                  Expanded(
                    child: Text(
                      zona.nombre,
                      style: const TextStyle(fontSize: 20, fontWeight: FontWeight.bold),
                      overflow: TextOverflow.ellipsis,
                    ),
                  ),
                  Container(
                    padding: const EdgeInsets.symmetric(horizontal: 8, vertical: 4),
                    decoration: BoxDecoration(
                      color: _getEstadoColor(zona.estado).withOpacity(0.2),
                      borderRadius: BorderRadius.circular(12),
                      border: Border.all(
                        color: _getEstadoColor(zona.estado),
                        width: 1,
                      ),
                    ),
                    child: Text(
                      zona.estado.toUpperCase(),
                      style: TextStyle(
                        color: _getEstadoColor(zona.estado),
                        fontSize: 12,
                        fontWeight: FontWeight.bold,
                      ),
                    ),
                  ),
                ],
              ),
              const SizedBox(height: 8),
              // Si tienes tipo de zona:

              const SizedBox(height: 8),
              Text(
                zona.descripcion,
                style: TextStyle(
                  fontSize: 14,
                  color: Colors.grey[700],
                ),
              ),
              const SizedBox(height: 12),
              _buildInfoRow(Icons.location_on, zona.ubicacion), // Campo ubicación
              const SizedBox(height: 8),
              Align(
                alignment: Alignment.centerRight,
                child: Row(
                  mainAxisSize: MainAxisSize.min,
                  children: [
                    // Botón Editar
                    ElevatedButton.icon(
                      onPressed: () async {
                        await Navigator.push(
                          context,
                          MaterialPageRoute(
                            builder: (_) => ZonaTuristicaEdit(zona: zona),
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
                    const SizedBox(width: 12),
                    // Botón Eliminar
                    ElevatedButton.icon(
                      // ...
                      onPressed: () async {
                        print("PRESIONASTE ELIMINAR");
                        final confirmar = await showDialog(
                          context: context,
                          builder: (ctx) {
                            print("DIALOGO ABIERTO EN CONTEXT: $ctx");
                            return AlertDialog(
                              title: const Text('Prueba'),
                              actions: [
                                TextButton(
                                  onPressed: () {
                                    print("CIERRO CON FALSE");
                                    Navigator.pop(ctx, false);
                                  },
                                  child: const Text('Cancelar'),
                                ),
                                ElevatedButton(
                                  onPressed: () {
                                    print("CIERRO CON TRUE");
                                    Navigator.pop(ctx, true);
                                  },
                                  child: const Text('Eliminar'),
                                ),
                              ],
                            );
                          },
                        );
                        print("RESULTADO DEL DIALOGO: $confirmar"); // <-- AGREGA ESTE PRINT
                        if (confirmar == true) {
                          print("CONFIRMADO, DISPARANDO EVENTO");
                          context.read<ZonaTuristicaBloc>().add(DeleteZonaTuristicaEvent(zona.idZonasTuristicas));
                        }
                      },
                      icon: const Icon(Icons.delete, size: 18),
                      label: const Text('Eliminar'),
                      style: ElevatedButton.styleFrom(
                        backgroundColor: Colors.red,
                        foregroundColor: Colors.white,
                        shape: RoundedRectangleBorder(
                          borderRadius: BorderRadius.circular(20),
                        ),
                        padding: const EdgeInsets.symmetric(horizontal: 16, vertical: 8),
                      ),
                    ),
                  ],
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