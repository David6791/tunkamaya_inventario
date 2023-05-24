<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Municipio;
use App\Models\Provincia;
use App\Models\Departamento;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class MunicipiosController extends Component
{
    use WithPagination;
    use WithFileUploads;
    protected $paginationTheme = 'bootstrap';

    public $search = '', $modalTitle;

    public $selected_id, $codigo, $name, $status, $observation, $departamento_id, $provincia_id, $provincias = [];

    private $pagination = 10;

    public function render()
    {
        if (strlen($this->search) > 0) {
            $data = Municipio::join('provincias as p', 'p.id', 'municipios.provincia_id')->select('municipios.*', 'p.name as prov_name')->where('municipios.name', 'like', '%' . $this->search . '%')->orderBy('name', 'asc')->paginate($this->pagination);
        } else {
            $data = Municipio::join('provincias as p', 'p.id', 'municipios.provincia_id')->select('municipios.*', 'p.name as prov_name')->orderBy('name', 'asc')->paginate($this->pagination);
        }
        return view('livewire.ubicacion.municipios.component ', [
            'data' => $data,
            'departamentos' => Departamento::orderBy('id', 'asc')->get()
        ])->layout('layouts.app');
    }
    public function mount()
    {
        $this->modalTitle = 'REGISTRAR NUEVO MUNICIPIO';
    }




    public function resetUI()
    {
        $this->resetValidation();
        $this->codigo  = '';
        $this->name = '';
        $this->status = '';
        $this->observation = '';
        $this->modalTitle = 'REGISTRAR NUEVO MUNICIPIO';
        $this->selected_id = '';
        $this->departamento_id = '';
        $this->provincia_id = '';
        $this->provincias = [];
    }
    public function select_depart($id)
    {
        $this->provincias = Provincia::where('departamento_id', '=', $id)->get();
    }
    public function Save()
    {
        $rules = [
            'codigo' => 'required',
            'name' => 'required',
            'status' => 'required|not_in:Elegir',
            'departamento_id' => 'required|not_in:Elegir',
            'provincia_id' => 'required|not_in:Elegir'
        ];
        $messages = [
            'codigo.required' => 'Debe ingresar el Codigo de Provincia',
            'name.required' => 'Debe ingresar el nombre de la Provincia.',
            'status.required' => 'Debe selecciona un Estado.',
            'status.not_in' => 'Seleccione un Estado diferente.',
            'departamento_id.required' => 'Debe seleccionar un Departamento',
            'departamento_id.not_in' => 'Seleccione un Departamento diferente.',
            'provincia_id.required' => 'Debe seleccionar una Provincia',
            'provincia_id.not_in' => 'Seleccione una Provincia diferente.',
        ];
        $this->validate($rules, $messages);
        try {
            $muni = Municipio::create([
                'codigo' => $this->codigo,
                'name' => $this->name,
                'status' => $this->status,
                'observation' => $this->observation,
                'provincia_id' => $this->provincia_id,
                'user_id' => auth()->user()->id,
            ]);
            $this->emit('registrado', 'El Municipio ' . $this->name . ' se registro Correctamente.');
            $this->resetUI();
        } catch (Exception $e) {
            dd($e);
        }
    }
    public function Edit(Municipio $municipio)
    {
        $this->selected_id = $municipio->id;
        $this->provincias = Provincia::where('id', '=', $municipio->provincia_id)->get();
        $this->codigo = $municipio->codigo;
        $this->name = $municipio->name;
        $this->status = $municipio->status;
        $this->observation = $municipio->observation;
        $this->provincia_id = $municipio->provincia_id;
        $this->departamento_id = $this->provincias[0]->departamento_id;
        $this->emit('edit', 'open');
    }
    public function Update()
    {
        $rules = [
            'codigo' => "required|unique:municipios,codigo,{$this->selected_id}",
            'name' => 'required',
            'status' => 'required|not_in:Elegir',
            'departamento_id' => 'required|not_in:Elegir',
            'provincia_id' => 'required|not_in:Elegir'
        ];
        $messages = [
            'codigo.required' => 'Debe ingresar el Codigo de Provincia',
            'name.required' => 'Debe ingresar el nombre de la Provincia.',
            'status.required' => 'Debe selecciona un Estado.',
            'status.not_in' => 'Seleccione un Estado diferente.',
            'departamento_id.required' => 'Debe seleccionar un Departamento',
            'departamento_id.not_in' => 'Seleccione un Departamento diferente.',
            'provincia_id.required' => 'Debe seleccionar una Provincia',
            'provincia_id.not_in' => 'Seleccione una Provincia diferente.',
        ];
        $this->validate($rules, $messages);

        try {
            $muni = Municipio::find($this->selected_id);
            $muni->update([
                'codigo' => $this->codigo,
                'name' => $this->name,
                'status' => $this->status,
                'observation' => $this->observation,
                'provincia_id' => $this->provincia_id,
                'user_id' => auth()->user()->id,
            ]);
            $this->emit('updated', 'Los Datos del Municipio ' . $this->name . ' fueron actualizados correctamente.');
            $this->resetUI();
        } catch (Exception $e) {
            dd($e);
        }
    }
    protected $listeners = [
        'Delete' => 'Delete',
        'resetUI' => 'resetUI'
    ];
    public function Delete(Municipio $municipio)
    {
        if ($municipio->localidad->count() === 0) {
            $municipio->delete();
            $this->resetUI();
            $this->emit('deleted', 'El Registro del Municipio fue eliminada Correctamente.');
        } else {
            $this->emit('errorDelete', 'No se puede Eliminar el registro del Municipio por que Tiene Localidades Asignados.');
        }
    }
}
