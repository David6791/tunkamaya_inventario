<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Provincia;
use App\Models\Departamento;

use Livewire\WithPagination;
use Livewire\WithFileUploads;


class ProvinciasController extends Component
{
    use WithPagination;
    use WithFileUploads;
    protected $paginationTheme = 'bootstrap';

    public $search = '', $modalTitle;

    public $selected_id, $departamento_id, $name, $codigo, $status, $observation;

    private $pagination = 10;

    public function render()
    {
        if (strlen($this->search) > 0) {
            $data = Provincia::join('departamentos as d', 'd.id', 'provincias.departamento_id')->select('provincias.*', 'd.name as depart_name')->where('provincias.name', 'like', '%' . $this->search . '%')->orderBy('name', 'asc')->paginate($this->pagination);
        } else {
            $data = Provincia::join('departamentos as d', 'd.id', 'provincias.departamento_id')->select('provincias.*', 'd.name as depart_name')->orderBy('name', 'asc')->paginate($this->pagination);
        }
        return view('livewire.ubicacion.provincias.component ', [
            'data' => $data,
            'departamentos' => Departamento::orderBy('name', 'asc')->get()
        ])->layout('layouts.app');
    }
    public function mount()
    {
        $this->modalTitle = 'DETALLES DE PROVINCIA';
    }
    public function Save()
    {
        $rules = [
            'codigo' => 'required',
            'name' => 'required',
            'status' => 'required|not_in:Elegir',
            'departamento_id' => 'required|not_in:Elegir'
        ];
        $messages = [
            'codigo.required' => 'Debe ingresar el Codigo de Provincia',
            'name.required' => 'Debe ingresar el nombre de la Provincia.',
            'status.required' => 'Debe selecciona un Estado.',
            'status.not_in' => 'Seleccione un Estado diferente.',
            'departamento_id.required' => 'Debe seleccionar una Provincia',
            'departamento_id.not_in' => 'Seleccione una Provincia diferente.',
        ];
        $this->validate($rules, $messages);
        try {
            $prov = Provincia::create([
                'codigo' => $this->codigo,
                'name' => $this->name,
                'status' => $this->status,
                'observation' => $this->observation,
                'departamento_id' => $this->departamento_id,
                'user_id' => auth()->user()->id,
            ]);
            $this->emit('registrado', 'La Provincia ' . $this->name . ' se registro Correctamente.');
            $this->resetUI();
        } catch (Exception $e) {
            dd($e);
        }
    }

    public function Edit(Provincia $prov)
    {
        $this->modalTitle = 'Editar Provincia ' . $prov->name;
        $this->selected_id = $prov->id;
        $this->name = $prov->name;
        $this->codigo = $prov->codigo;
        $this->status = $prov->status;
        $this->departamento_id = $prov->departamento_id;
        $this->observation = $prov->observation;
        $this->emit('edit', 'open');
    }

    public function Update()
    {
        $rules = [
            'codigo' => "required|unique:departamentos,codigo,{$this->selected_id}",
            'name' => 'required',
            'status' => 'required|not_in:Elegir',
            'departamento_id' => 'required|not_in:Elegir'
        ];
        $messages = [
            'codigo.required' => 'Debe ingresar el Codigo de Provincia',
            'codigo.unique' => 'Este codigo de Provincia ya esta siendo Utilizado',
            'name.required' => 'Debe ingresar el nombre de la Provincia.',
            'status.required' => 'Debe selecciona un Estado.',
            'status.not_in' => 'Seleccione un Estado diferente.',
            'departamento_id.required' => 'Debe seleccionar una Provincia',
            'departamento_id.not_in' => 'Seleccione una Provincia diferente.',
        ];
        $this->validate($rules, $messages);
        try {
            $prov = Provincia::find($this->selected_id);
            $prov->update([
                'codigo' => $this->codigo,
                'name' => $this->name,
                'status' => $this->status,
                'observation' => $this->observation,
                'departamento_id' => $this->departamento_id,
                'user_id' => auth()->user()->id,
            ]);
            $this->emit('updated', 'Los Datos de la Provincia ' . $this->name . ' fueron actualizados correctamente.');
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
        $this->status = '';
        $this->observation = '';
        $this->modalTitle = '';
        $this->selected_id = '';
        $this->departamento_id = '';
    }
    protected $listeners = [
        'Delete' => 'Delete',
        'resetUI' => 'resetUI'
    ];
    public function Delete(Provincia $prov)
    {
        $num = $prov->municipio->count();
        if ($num === 0) {
            $prov->delete();
            $this->resetUI();
            $this->emit('deleted', 'El Registro de la Provincia fue eliminada Correctamente.');
        } else {
            $this->emit('errorDelete', 'No se puede Eliminar el registro de la Provincia por que Tiene Municipios Asignados.');
        }
    }
}
