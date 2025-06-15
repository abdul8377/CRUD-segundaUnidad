<div>
    <h2>Lista de Categorías</h2>

    <!-- Si hay categorías, mostrarlas en una tabla -->
    @if($categorias->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Tipo</th>
                    <th>Descripción</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categorias as $categoria)
                    <tr>
                        <td>{{ $categoria->nombre }}</td>
                        <td>{{ $categoria->tipo }}</td>
                        <td>{{ $categoria->descripcion }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No hay categorías disponibles.</p>
    @endif
</div>
