<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Bloque;
use App\Models\Departamento;
use App\Models\Institucion;
use App\Models\Provincia;
use App\Models\Municipio;
use App\Models\Localidad;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class BloqueController extends Component
{
    use WithPagination;
    use WithFileUploads;
    protected $paginationTheme = 'bootstrap';
    public $instituciones = [], $selected_id, $search, $departamentos = [], $provincias = [], $municipios = [], $localidades = [], $name, $codigo, $status, $observation, $departamento_id, $provincia_id, $municipio_id, $localidad_id, $institucion_id;

    public $modalTitle;

    private $pagination = 10;

    public function mount()
    {
        $this->modalTitle = 'REGISTRO NUEVO BLOQUE';
    }

    public function render()
    {
        if (strlen($this->search) > 0) {
            $data = Bloque::join('localidades as l', 'l.id', 'bloques.localidad_id')->select('bloques.*', 'l.name as local_name')->where('l.name', 'like', '%' . $this->search . '%')->orderBy('codigo', 'asc')->paginate($this->pagination);
        } else {
            $data = Bloque::join('localidades as l', 'l.id', 'bloques.localidad_id')->select('bloques.*', 'l.name as local_name')->orderBy('name', 'asc')->paginate($this->pagination);
        }
        $this->departamentos = Departamento::orderBy('id', 'asc')->get();
        $this->instituciones = Institucion::orderBy('id', 'asc')->get();
        return view('livewire.ubicacion.bloques.component', [
            'data' => $data,
            'departamentos' => $this->departamentos,
            'instituciones' => $this->instituciones
        ])->layout('layouts.app');
    }

    public function select_depart($id)
    {
        $this->provincias = Provincia::where('departamento_id', '=', $id)->get();
        $this->municipios = [];
        $this->localidades = [];
        $this->provincia_id = 'Elegir';
        $this->municipio_id = 'Elegir';
        $this->localidad_id = 'Elegir';
    }
    public function select_prov($id)
    {
        $this->municipios = Municipio::where('provincia_id', '=', $id)->get();
        $this->localidades = [];
        $this->municipio_id = 'Elegir';
        $this->localidad_id = 'Elegir';
    }
    public function select_muni($id)
    {
        $this->localidades = Localidad::where('municipio_id', '=', $id)->get();
        $this->localidad_id = 'Elegir';
    }

    public function resetUI()
    {
        $this->resetValidation();
        $this->codigo  = '';
        $this->name = '';
        $this->status = '';
        $this->observation = '';
        $this->modalTitle = 'REGISTRO NUEVO BLOQUE';
        $this->selected_id = '';
        $this->departamento_id = '';
        $this->provincia_id = '';
        $this->municipio_id = '';
        $this->localidad_id = '';
        $this->provincias = [];
        $this->municipios = [];
        $this->localidades = [];
        $this->institucion_id = '';
    }
    public function Save()
    {
        $rules = [
            'codigo' => 'required',
            'name' => 'required',
            'status' => 'required|not_in:Elegir',
            'departamento_id' => 'required|not_in:Elegir',
            'provincia_id' => 'required|not_in:Elegir',
            'municipio_id' => 'required|not_in:Elegir',
            'localidad_id' => 'required|not_in:Elegir',
            'institucion_id' => 'required|not_in:Elegir'
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
            'localidad_id.required' => 'Debe seleccionar una Localidad',
            'localidad_id.not_in' => 'Seleccione una Localidad diferente.',
            'institucion_id.required' => 'Debe seleccionar una Institucion',
            'institucion_id.not_in' => 'Seleccione una Institucion diferente.',
        ];
        $this->validate($rules, $messages);

        try {
            $bloque = Bloque::create([
                'codigo' => $this->codigo,
                'name' => $this->name,
                'status' => $this->status,
                'observation' => $this->observation,
                'localidad_id' => $this->localidad_id,
                'institucion_id' => $this->institucion_id,
                'user_id' => auth()->user()->id,
            ]);
            $this->emit('registrado', 'El Nuevo Bloque: ' . $this->name . ' se registro Correctamente.');
            $this->resetUI();
        } catch (Exception $e) {
            dd($e);
        }
    }
    public function Edit(Bloque $bloque)
    {
        $this->selected_id = $bloque->id;
        $this->codigo = $bloque->codigo;
        $this->name = $bloque->name;
        $this->status = $bloque->status;
        $this->observation = $bloque->observation;
        $this->localidad_id = $bloque->localidad_id;
        $this->institucion_id = $bloque->institucion_id;

        $localidad = Localidad::find($bloque->localidad_id);
        $this->localidades = Localidad::where('municipio_id', '=', $localidad->municipio_id)->get();

        $muni_id = Municipio::where('id', $localidad->municipio_id)->get();
        $this->municipios = Municipio::where('provincia_id', $muni_id[0]->provincia_id)->get();
        $this->municipio_id = $muni_id[0]->id;

        $prov_id = Provincia::where('id', $muni_id[0]->provincia_id)->get();
        $this->provincia_id = $prov_id[0]->id;
        $this->provincias = Provincia::where('departamento_id', $prov_id[0]->departamento_id)->get();

        $id_depart = Provincia::where('id', $this->provincia_id)->get();
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
            'municipio_id' => 'required|not_in:Elegir',
            'localidad_id' => 'required|not_in:Elegir',
            'institucion_id' => 'required|not_in:Elegir'
        ];
        $messages = [
            'codigo.required' => 'Debe ingresar el Codigo de Provincia',
            'codigo.unique' => 'El Codigo que ingreso ya fue registrado',
            'name.required' => 'Debe ingresar el nombre de la Provincia.',
            'status.required' => 'Debe selecciona un Estado.',
            'status.not_in' => 'Seleccione un Estado diferente.',
            'departamento_id.required' => 'Debe seleccionar un Departamento',
            'departamento_id.not_in' => 'Seleccione un Departamento diferente.',
            'provincia_id.required' => 'Debe seleccionar una Provincia',
            'provincia_id.not_in' => 'Seleccione una Provincia diferente.',
            'municipio_id.required' => 'Debe seleccionar un Municipio',
            'municipio_id.not_in' => 'Seleccione una Municipio diferente.',
            'localidad_id.required' => 'Debe seleccionar una Localidad',
            'localidad_id.not_in' => 'Seleccione una Localidad diferente.',
            'institucion_id.required' => 'Debe seleccionar una Institucion',
            'institucion_id.not_in' => 'Seleccione una Institucion diferente.',
        ];
        $this->validate($rules, $messages);

        try {
            $bloque = Bloque::find($this->selected_id);
            $bloque->update([
                'codigo' => $this->codigo,
                'name' => $this->name,
                'status' => $this->status,
                'observation' => $this->observation,
                'localidad_id' => $this->localidad_id,
                'institucion_id' => $this->institucion_id,
                'user_id' => auth()->user()->id,
            ]);
            $this->emit('updated', 'Los Datos del Bloque: ' . $this->name . ' fueron actualizados correctamente.');
            $this->resetUI();
        } catch (Exception $e) {
            dd($e);
        }
    }
    protected $listeners = [
        'Delete' => 'Delete',
        'resetUI' => 'resetUI'
    ];
    public function Delete(Bloque $bloque)
    {
        dd('Eliminar despues de hacer la parte de areas');
    }
}
