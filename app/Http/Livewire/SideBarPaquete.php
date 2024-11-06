<?php

namespace App\Http\Livewire;

use Livewire\Component;

class SideBarPaquete extends Component
{
    public $ventaId;

    public function mount($ventaId)
    {
        $this->ventaId = $ventaId;
    }
    public function render()
    {
        return view('livewire.side-bar-paquete');
    }
    protected $listeners = ['setVentaId' => 'updateVentaId'];

    public function updateVentaId($ventaId)
    {
        $this->ventaId = $ventaId;
    }

}
