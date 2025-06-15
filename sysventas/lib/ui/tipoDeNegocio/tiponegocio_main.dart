import 'dart:io';
import 'package:animated_floating_buttons/animated_floating_buttons.dart';
import 'package:sysventas/apis/categoria_api.dart';
import 'package:sysventas/apis/marca_api.dart';
import 'package:sysventas/apis/producto_api.dart';
import 'package:sysventas/apis/tiponegocio_api.dart';
import 'package:sysventas/apis/unidadmedida_api.dart';

import 'package:sysventas/comp/TabItem.dart';
import 'package:flutter/material.dart';
import 'package:fluttertoast/fluttertoast.dart';
import 'package:provider/provider.dart';
import 'package:intl/intl.dart';
import 'package:sysventas/modelo/ProductoModelo.dart';
import 'package:sysventas/modelo/TipoNegocioModelo.dart';
import 'package:sysventas/modelo/UnidadMedidaModelo.dart';
import 'package:sysventas/repository/TipoNegocioRepository.dart';
import 'package:sysventas/repository/UnidadMedidaRepository.dart';
import 'package:sysventas/theme/AppTheme.dart';
import 'package:sysventas/ui/producto/producto_edit.dart';
import 'package:sysventas/ui/producto/producto_form.dart';
import 'package:sysventas/util/TokenUtil.dart';
import '../help_screen.dart';
import 'package:excel/excel.dart';
import 'package:path_provider/path_provider.dart';
import 'package:flutter/services.dart';
import 'package:share_plus/share_plus.dart';

class MainTipoNegocio extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return Provider<TipoNegocioApi>(
      create: (_) => TipoNegocioApi.create(),
      child: MaterialApp(
        debugShowCheckedModeBanner: false,
        title: 'Tipos de Negocio',
        home: TipoNegocioUI(),
      ),
    );
  }
}

class TipoNegocioUI extends StatefulWidget {
  @override
  _TipoNegocioUIState createState() => _TipoNegocioUIState();
}

class _TipoNegocioUIState extends State<TipoNegocioUI> {
  late TipoNegocioRepository _repo;
  late Future<List<TipoDeNegocioResp>> _futureList;
  List<TipoDeNegocioResp> _allItems = [];
  List<TipoDeNegocioResp> _filteredItems = [];
  bool _isLoading = false;
  final TextEditingController _searchController = TextEditingController();

  @override
  void initState() {
    super.initState();
    _repo = TipoNegocioRepository();
    _loadData();
    _searchController.addListener(() {
      _filterList(_searchController.text);
    });
  }

  void _loadData() {
    setState(() {
      _isLoading = true;
      _futureList = _repo.getAll();
      _futureList.then((list) {
        _allItems = List.from(list);
        _filteredItems = List.from(_allItems);
        setState(() => _isLoading = false);
      }).catchError((_) {
        setState(() => _isLoading = false);
      });
    });
  }

  void _filterList(String query) {
    setState(() {
      _filteredItems = _allItems.where((item) {
        final lower = query.toLowerCase();
        return item.nombre.toLowerCase().contains(lower) ||
            (item.descripcion?.toLowerCase().contains(lower) ?? false);
      }).toList();
    });
  }

  Future<void> _showForm({TipoDeNegocioResp? existing}) async {
    final nombreCtrl = TextEditingController(text: existing?.nombre ?? '');
    final descCtrl =
    TextEditingController(text: existing?.descripcion ?? '');

    await showDialog(
      context: context,
      builder: (ctx) => AlertDialog(
        title: Text(existing == null
            ? 'Crear Tipo de Negocio'
            : 'Editar Tipo de Negocio'),
        content: SingleChildScrollView(
          child: Column(
            children: [
              TextField(
                controller: nombreCtrl,
                decoration: InputDecoration(
                  labelText: 'Nombre',
                  border: OutlineInputBorder(),
                ),
              ),
              const SizedBox(height: 12),
              TextField(
                controller: descCtrl,
                decoration: InputDecoration(
                  labelText: 'Descripción',
                  border: OutlineInputBorder(),
                ),
              ),
            ],
          ),
        ),
        actions: [
          TextButton(
            onPressed: () => Navigator.of(ctx).pop(),
            child: Text('Cancelar'),
          ),
          ElevatedButton(
            onPressed: () async {
              final nombre = nombreCtrl.text.trim();
              final descripcion = descCtrl.text.trim();
              if (nombre.isEmpty) return;
              Navigator.of(ctx).pop();
              setState(() => _isLoading = true);

              try {
                if (existing == null) {
                  await _repo.create(
                    TipoDeNegocioDto(
                      nombre: nombre,
                      descripcion:
                      descripcion.isEmpty ? null : descripcion,
                    ),
                  );
                } else {
                  await _repo.update(
                    existing.idTipoNegocio,
                    TipoDeNegocioDto(
                      nombre: nombre,
                      descripcion:
                      descripcion.isEmpty ? null : descripcion,
                    ),
                  );
                }
                _loadData();
              } catch (e) {
                setState(() => _isLoading = false);
                ScaffoldMessenger.of(context).showSnackBar(
                  SnackBar(content: Text('Error: $e')),
                );
              }
            },
            child: Text('Guardar'),
          ),
        ],
      ),
    );
  }

  void _confirmDelete(int id) {
    showDialog(
      context: context,
      builder: (ctx) => AlertDialog(
        title: Text('Confirmación'),
        content: Text('¿Seguro que deseas eliminar este registro?'),
        actions: [
          TextButton(
            onPressed: () => Navigator.of(ctx).pop(),
            child: Text('Cancelar'),
          ),
          ElevatedButton(
            onPressed: () async {
              Navigator.of(ctx).pop();
              setState(() => _isLoading = true);
              try {
                await _repo.delete(id);
                _loadData();
              } catch (e) {
                setState(() => _isLoading = false);
                ScaffoldMessenger.of(context).showSnackBar(
                  SnackBar(content: Text('Error al eliminar: $e')),
                );
              }
            },
            child: Text('Eliminar'),
          ),
        ],
      ),
    );
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text('Tipos de Negocio'),
        centerTitle: true,
        actions: [
          IconButton(
            icon: Icon(Icons.add),
            onPressed: () => _showForm(),
          ),
        ],
      ),
      body: Column(
        children: [
          Padding(
            padding:
            const EdgeInsets.symmetric(horizontal: 12.0, vertical: 8.0),
            child: TextField(
              controller: _searchController,
              decoration: InputDecoration(
                hintText: 'Buscar por nombre o descripción...',
                prefixIcon: Icon(Icons.search),
                suffixIcon: _searchController.text.isEmpty
                    ? null
                    : IconButton(
                  icon: Icon(Icons.clear),
                  onPressed: () {
                    _searchController.clear();
                    _filterList('');
                  },
                ),
                border: OutlineInputBorder(
                  borderRadius: BorderRadius.circular(8),
                ),
              ),
            ),
          ),
          Expanded(
            child: _isLoading
                ? Center(child: CircularProgressIndicator())
                : _filteredItems.isEmpty
                ? Center(child: Text('No hay registros.'))
                : ListView.builder(
              itemCount: _filteredItems.length,
              itemBuilder: (ctx, idx) {
                final item = _filteredItems[idx];
                return Card(
                  margin: const EdgeInsets.symmetric(
                      horizontal: 12, vertical: 6),
                  child: ListTile(
                    title: Text(item.nombre),
                    subtitle: Text(item.descripcion ?? ''),
                    trailing: Row(
                      mainAxisSize: MainAxisSize.min,
                      children: [
                        IconButton(
                          icon: Icon(Icons.edit),
                          onPressed: () =>
                              _showForm(existing: item),
                        ),
                        IconButton(
                          icon: Icon(Icons.delete),
                          onPressed: () =>
                              _confirmDelete(item.idTipoNegocio),
                        ),
                      ],
                    ),
                  ),
                );
              },
            ),
          ),
        ],
      ),
    );
  }

  @override
  void dispose() {
    _searchController.dispose();
    super.dispose();
  }
}