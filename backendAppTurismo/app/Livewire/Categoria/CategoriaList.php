<?php

namespace App\Livewire\Categoria;

use App\Models\Categoria;
use Livewire\Component;

class CategoriaList extends Component
{


    public $categorias; // Variable para almacenar las categorías

    public function mount()
    {
        // Obtener todas las categorías al montar el componente (debe ser una colección, no un array)
        $this->categorias = Categoria::all();
    }

    public function render()
    {
        return view('livewire.categoria.categoria-list');
    }
}
