<?php

namespace App\View\Components\Municipalidad;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Header extends Component
{
    /**
     * Create a new component instance.
     */
    public $municipalidad;

public function __construct($municipalidad)
{
    $this->municipalidad = $municipalidad;
}

public function render()
{
    return view('components.municipalidad.header');
}

}
