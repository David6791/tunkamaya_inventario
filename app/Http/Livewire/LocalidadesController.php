<?php

namespace App\Http\Livewire;

use Livewire\Component;

use App\Models\Localidad;
use App\Models\Provincia;
use App\Models\Departamento;
use App\Models\Municipio;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class LocalidadesController extends Component
{
    use WithPagination;
    use WithFileUploads;
    protected $paginationTheme = 'bootstrap';

    public $search = '', $modalTitle;

    public $selected_id, $name, $codigo, $status, $observation, $departamento_id, $provincia_id, $municipio_id, $provincias = [], $municipios = [];

    private $pagination = 10;

    public function render()
    {
        if (strlen($this->search) > 0) {
            $data = Localidad::join('municipios as m', 'm.id', 'localidades.municipio_id')->select('localidades.*', 'm.name as local_name')->where('localidades.name', 'like', '%' . $this->search . '%')->orderBy('name', 'asc')->paginate($this->pagination);
        } else {
            $data = Localidad::join('municipios as m', 'm.id', 'localidades.municipio_id')->select('localidades.*', 'm.name as local_name')->orderBy('name', 'asc')->paginate($this->pagination);
        }
        return view('livewire.ubicacion.localidades.component ', [
            'data' => $data,
            'departamentos' => Departamento::orderBy('id', 'asc')->get()
        ])->layout('layouts.app');
    }
    public function mount()
    {
        $this->modalTitle = 'REGISTRAR NUEVA LOCALIDAD';
    }


    public function resetUI()
    {
        $this->resetValidation();
        $this->codigo  = '';
        $this->name = '';
        $this->status = '';
        $this->observation = '';
        $this->modalTitle = 'REGISTRAR NUEVA MUNICIPIO';
        $this->selected_id = '';
        $this->departamento_id = '';
        $this->provincia_id = '';
        $this->municipio_id = '';
        $this->provincias = [];
    }

    public function select_depart($id)
    {
        $this->provincias = Provincia::where('departamento_id', '=', $id)->get();
        $this->municipios = [];
        $this->provincia_id = '';
        $this->municipio_id = '';
    }
    public function select_prov($id)
    {
        $this->municipios = Municipio::where('provincia_id', '=', $id)->get();
        $this->municipio_id = '';
    }

    public function Save()
    {
        $rules = [
            'codigo' => 'required',
            'name' => 'required',
            'status' => 'required|not_in:Elegir',
            'departamento_id' => 'required|not_in:Elegir',
            'provincia_id' => 'required|not_in:Elegir',
            'municipio_id' => 'required|not_in:Elegir'
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
            'municipio_id.required' => 'Debe seleccionar un Municipio',
            'municipio_id.not_in' => 'Seleccione una Municipio diferente.',
        ];
        $this->validate($rules, $messages);

        try {
            $local = Localidad::create([
                'codigo' => $this->codigo,
                'name' => $this->name,
                'status' => $this->status,
                'observation' => $this->observation,
                'municipio_id' => $this->municipio_id,
                'user_id' => auth()->user()->id,
            ]);
            $this->emit('registrado', 'La Localidad: ' . $this->name . ' se registro Correctamente.');
            $this->resetUI();
        } catch (Exception $e) {
            dd($e);
        }
    }

    public function Edit(Localidad $local)
    {
        $this->selected_id = $local->id;
        $this->municipios = Municipio::where('id', '=', $local->municipio_id)->get();
        $this->codigo = $local->codigo;
        $this->name = $local->name;
        $this->status = $local->status;
        $this->observation = $local->observation;
        $this->provincias = Provincia::get();
        $this->municipio_id = $local->municipio_id;
        $this->provincia_id = $this->municipios[0]->provincia_id;
        $id_depart = Provincia::where('id', '=', $this->provincia_id)->get();
        $this->departamento_id = $id_depart[0]->departamento_id;
        $this->emit('edit', 'open');
    }
    public function Update()
    {
        $rules = [
            'codigo' => "required|unique:municipios,codigo,{$this->selected_id}",
            'name' => 'required',
            'status' => 'required|not_in:Elegir',
            'departamento_id' => 'required|not_in:Elegir',
            'provincia_id' => 'required|not_in:Elegir',
            'municipio_id' => 'required|not_in:Elegir'
        ];
        $messages = [
            'codigo.required' => 'Debe ingresar el Codigo de Provincia',
            'codigo.unique' => 'El Codigo ingresado ya esta siendo utilizado',
            'name.required' => 'Debe ingresar el nombre de la Provincia.',
            'status.required' => 'Debe selecciona un Estado.',
            'status.not_in' => 'Seleccione un Estado diferente.',
            'departamento_id.required' => 'Debe seleccionar un Departamento',
            'departamento_id.not_in' => 'Seleccione un Departamento diferente.',
            'provincia_id.required' => 'Debe seleccionar una Provincia',
            'provincia_id.not_in' => 'Seleccione una Provincia diferente.',
            'municipio_id.required' => 'Debe seleccionar un Municipio',
            'municipio_id.not_in' => 'Seleccione una Municipio diferente.',
        ];
        $this->validate($rules, $messages);

        try {
            $local = Localidad::find($this->selected_id);
            $local->update([
                'codigo' => $this->codigo,
                'name' => $this->name,
                'status' => $this->status,
                'observation' => $this->observation,
                'municipio_id' => $this->municipio_id,
                'user_id' => auth()->user()->id,
            ]);
            $this->emit('updated', 'Los Datos de la Localidad: ' . $this->name . ' fueron actualizados correctamente.');
            $this->resetUI();
        } catch (Exception $e) {
            dd($e);
        }
    }

    protected $listeners = [
        'Delete' => 'Delete',
        'resetUI' => 'resetUI'
    ];

    public function Delete(Localidad $local)
    {
        if ($local->bloque->count() === 0) {
            $local->delete();
            $this->resetUI();
            $this->emit('deleted', 'El Registro de la Localidad fue eliminada Correctamente.');
        } else {
            $this->emit('errorDelete', 'No se puede Eliminar el registro de la Localidad por que tiene Bloques Asignados.');
        }
    }
}
