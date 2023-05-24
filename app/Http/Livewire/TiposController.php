<?php

namespace App\Http\Livewire;

use Livewire\Component;

use App\Models\Tipo;
use App\Models\Grupo;

class TiposController extends Component
{
    public $search, $selected_id, $codigo, $name, $status, $grupo_id, $cant_carac, $caracetristicas = [], $i, $nombre_grupo, $new_car;

    private $pagination = 10;

    public $modalTitle;
    protected $paginationTheme = 'bootstrap';
    public function mount()
    {
        $this->modalTitle = 'REGISTRO DE TIPOS DE ACTIVOS';
    }
    public function render()
    {

        if (strlen($this->search) > 0) {
            $data = Tipo::join('grupos as g', 'g.id', 'tipos.grupo_id')->select('tipos.*', 'g.name as grupo_name')->where('tipos.name', 'like', '%' . $this->search . '%')->orderBy('name', 'asc')->paginate($this->pagination);
        } else {
            $data = Tipo::join('grupos as g', 'g.id', 'tipos.grupo_id')->select('tipos.*', 'g.name as grupo_name')->orderBy('tipos.id', 'asc')->paginate($this->pagination);
        }
        return view('livewire.clasificacion.tipos.component', [
            'data' => $data,
            'grupos' => Grupo::orderBy('id', 'asc')->get()
        ])->layout('layouts.app');
    }

    public function Save()
    {
        $rules = [
            'codigo' => 'required',
            'name' => 'required',
            'status' => 'required|not_in:Elegir',
            'grupo_id' => 'required|not_in:Elegir',
        ];
        $messages = [
            'codigo.required' => 'Debe ingresar un Codigo.',
            'name.required' => 'Debe ingresar el Nombre del Activo',
            'status.required' => 'Debe selecciona un Estado.',
            'status.not_in' => 'Seleccione un Estado diferente.',
            'grupo_id.required' => 'Debe selecciona un Grupo.',
            'grupo_id.not_in' => 'Seleccione un Grupo diferente.',
        ];
        $this->validate($rules, $messages);

        $this->caracetristicas = array();

        try {
            $tipo = Tipo::create([
                'codigo' => $this->codigo,
                'name' => $this->name,
                'status' => $this->status,
                'grupo_id' => $this->grupo_id,
                'caracteristicas' => json_encode($this->caracetristicas),
                'user_id' => auth()->user()->id,
            ]);
            $this->emit('registrado', 'El Tipo de Activo: ' . $this->name . '  se registro Correctamente.');
            $this->resetUI();
        } catch (Exception $e) {
            dd($e);
        }
    }
    public function Edit(Tipo $tipo)
    {
        $this->modalTitle = 'EDITAR ACTIVO: ' . $tipo->name;
        $this->selected_id = $tipo->id;
        $this->codigo = $tipo->codigo;
        $this->name = $tipo->name;
        $this->status = $tipo->status;
        $this->grupo_id = $tipo->grupo_id;
        $this->emit('edit', 'open');
    }
    public function Update()
    {
        $rules = [
            'codigo' => "required|unique:responsables,ci,{$this->selected_id}",
            'name' => 'required',
            'status' => 'required|not_in:Elegir',
        ];
        $messages = [
            'codigo.required' => 'Debe ingresar un Codigo.',
            'codigo.unique' => 'El Codigo ingresado ya esta en uso.',
            'name.required' => 'Debe ingresar el Nombre del Activo',
            'status.required' => 'Debe selecciona un Estado.',
            'status.not_in' => 'Seleccione un Estado diferente.',
        ];
        $this->validate($rules, $messages);
        try {
            $tipo = Tipo::find($this->selected_id);
            $tipo->update([
                'codigo' => $this->codigo,
                'name' => $this->name,
                'status' => $this->status,
                'grupo_id' => $this->grupo_id,
                'user_id' => auth()->user()->id,
            ]);
            $this->emit('updated', 'Los Datos del Tipo de Activo: ' . $this->name . ' fue actualizados correctamente.');
            $this->resetUI();
        } catch (Exception $e) {
            dd($e);
        }
    }
    public function resetUI()
    {
        $this->resetValidation();
        $this->codigo  = '';
        $this->name = '';
        $this->new_car = '';
        $this->grupo_id = '';
        $this->status = '';
        $this->selected_id = '';
        $this->modalTitle = 'REGISTRO DE TIPOS DE ACTIVOS';
        $this->emit('close_modal', '');
    }
    public function Show(Tipo $tipo)
    {
        $this->selected_id = $tipo->id;
        $this->nombre_grupo = Grupo::where('id', $tipo->grupo_id)->pluck('name')->first();
        $car = json_decode($tipo->caracteristicas);
        $this->modalTitle = 'Detalles del Tipo: ' . $tipo->name;
        $this->name = $tipo->name;
        $this->codigo = $tipo->codigo;
        $this->status = $tipo->status;
        $this->caracetristicas = $car;
        $this->emit('show', 'open');
    }
    protected $listeners = [
        'Delete' => 'Delete',
        'DeleteChar' => 'DeleteChar'
    ];
    public function DeleteChar(Tipo $tipo, $i)
    {
        $car = json_decode($tipo->caracteristicas);
        $b = array_splice($car, $i, 1);
        try {
            $tipo = Tipo::find($this->selected_id);
            $tipo->update([
                'caracteristicas' => json_encode($car),
            ]);
            $tipo->save();
            $this->caracetristicas = $car;
            $this->emit('updated_car', 'La Caracteristica: ' . $b[0] . ' fue eliminada correctamente.');
            $this->resetUI();
        } catch (Exception $e) {
            dd($e);
        }
    }
    public function addCar(Tipo $tipo)
    {
        $this->modalTitle = 'AGREGAR NUEVA CARACTERISTICA';
        $this->name = $tipo->name;
        $this->selected_id = $tipo->id;
        $this->emit('show_Car', 'open');
    }
    public function addNewCar()
    {
        $tipo = Tipo::find($this->selected_id);
        $carac = json_decode($tipo->caracteristicas);
        array_push($carac, $this->new_car);
        try {
            $tipo->update([
                'caracteristicas' => json_encode($carac),
            ]);
            $tipo->save();
            $this->emit('updated_car', 'La Caracteristica: ' . $this->new_car . ' fue agregada correctamente.');
            $this->resetUI();
        } catch (Exception $e) {
            dd($e);
        }
    }
}
