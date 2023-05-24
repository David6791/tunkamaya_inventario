<?php

namespace App\Http\Livewire;

use Livewire\Component;

use App\Models\SubTipo;
use App\Models\Grupo;

class SubTiposController extends Component
{
    public $search, $selected_id;
    protected $paginationTheme = 'bootstrap';
    private $pagination = 10;
    public $modalTitle;
    public function mount()
    {
        $this->modalTitle = 'REGISTRO DE SUBTIPO DE ACTIVOS';
    }
    public function render()
    {
        if (strlen($this->search) > 0) {
            $data = SubTipo::join('tipos as t', 't.id', 'subtipos.tipo_id')->select('subtipos.*', 't.name as tipo_name')->where('subtipos.name', 'like', '%' . $this->search . '%')->orderBy('subtipos.name', 'asc')->paginate($this->pagination);
        } else {
            $data = SubTipo::join('tipos as t', 't.id', 'subtipos.tipo_id')->select('subtipos.*', 't.name as tipo_name')->orderBy('subtipos.id', 'asc')->paginate($this->pagination);
        }
        return view('livewire.clasificacion.subtipos.component', [
            'data' => $data,
            'grupos' => Grupo::orderBy('id', 'asc')->get()
        ])->layout('layouts.app');
    }
}
