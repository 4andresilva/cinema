<?php

namespace App\View\Components;

use Illuminate\View\Component;

class MapaAssentos extends Component
{
    public function __construct(
        public $quantidade_fileiras,
        public $quantidade_assentos_por_fileira,
        public $assentos
    ) {}

    public function render()
    {
        return view('components.mapa-assentos');
    }
}