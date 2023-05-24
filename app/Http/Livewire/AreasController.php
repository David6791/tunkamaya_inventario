<?php

namespace App\Http\Livewire;

use Livewire\Component;

use Livewire\WithPagination;
use Livewire\WithFileUploads;

use App\Models\Area;
use App\Models\Departamento;
use App\Models\Provincia;
use App\Models\Municipio;
use App\Models\Localidad;
use App\Models\Bloque;
use App\Models\Responsable;

class AreasController extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $search, $selected_id, $departamentos, $provincias = [], $municipios = [], $localidades = [], $bloques = [], $codigo, $name, $status, $departamento_id, $provincia_id, $municipio_id, $localidad_id, $bloque_id, $responsable_id;

    private $pagination = 10;

    public $modalTitle;

    public function mount()
    {
        $this->modalTitle = 'REGISTRO NUEVA AREA';
    }

    public function render()
    {
        $this->departamentos = Departamento::orderBy('id', 'asc')->get();
        if (strlen($this->search) > 0) {
            $data = Area::join('bloques as b', 'b.id', 'areas.bloque_id')
                ->join('responsables as r', 'r.id', 'areas.responsable_id')
                ->select('areas.*', 'b.name as bloque_name', 'r.nombres as responsable_name', 'r.apellidos')
                ->where('l.name', 'like', '%' . $this->search . '%')
                ->orderBy('id', 'asc')->paginate($this->pagination);
        } else {
            $data = Area::join('bloques as b', 'b.id', 'areas.bloque_id')
                ->join('responsables as r', 'r.id', 'areas.responsable_id')
                ->select('areas.*', 'b.name as bloque_name', 'r.nombres as responsable_name', 'r.apellidos')
                ->orderBy('id', 'asc')->paginate($this->pagination);
        }

        return view('livewire.infraestructura.areas.component', [
            'data' => $data,
            'departamentos' => $this->departamentos,
            'responsables' => Responsable::orderBy('id', 'asc')->get()
        ])->layout('layouts.app');
    }
    public function select_depart($id)
    {
        $this->provincias = Provincia::where('departamento_id', '=', $id)->get();
        $this->municipios = [];
        $this->localidades = [];
        $this->bloques = [];
        $this->provincia_id = 'Elegir';
        $this->municipio_id = 'Elegir';
        $this->localidad_id = 'Elegir';
        $this->bloque_id = 'Elegir';
    }
    public function select_prov($id)
    {
        $this->municipios = Municipio::where('provincia_id', '=', $id)->get();
        $this->localidades = [];
        $this->bloques = [];
        $this->municipio_id = 'Elegir';
        $this->localidad_id = 'Elegir';
        $this->bloque_id = 'Elegir';
    }
    public function select_muni($id)
    {
        $this->localidades = Localidad::where('municipio_id', '=', $id)->get();
        $this->bloques = [];
        $this->localidad_id = 'Elegir';
        $this->bloque_id = 'Elegir';
    }
    public function select_loca($id)
    {
        $this->bloques = Bloque::where('localidad_id', '=', $id)->get();
        $this->bloque_id = 'Elegir';
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
            'bloque_id' => 'required|not_in:Elegir',
            'responsable_id' => 'required|not_in:Elegir'
        ];
        $messages = [
            'codigo.required' => 'Debe ingresar el Codigo de Provincia.',
            'name.required' => 'Debe ingresar el nombre de la Provincia.',
            'status.required' => 'Debe selecciona un Estado.',
            'status.not_in' => 'Seleccione un Estado diferente.',
            'departamento_id.required' => 'Debe seleccionar un Departamento.',
            'departamento_id.not_in' => 'Seleccione un Departamento diferente.',
            'provincia_id.required' => 'Debe seleccionar una Provincia.',
            'provincia_id.not_in' => 'Seleccione una Provincia diferente.',
            'municipio_id.required' => 'Debe seleccionar un Municipio.',
            'municipio_id.not_in' => 'Seleccione una Municipio diferente.',
            'localidad_id.required' => 'Debe seleccionar una Localidad.',
            'localidad_id.not_in' => 'Seleccione una Localidad diferente.',
            'bloque_id.required' => 'Debe seleccionar un Bloque',
            'bloque_id.not_in' => 'Seleccione un Bloque diferente.',
            'reponsable_id.required' => 'Debe seleccionar un Responsable para el Area.',
            'reponsable_id.not_in' => 'Seleccione un REsponsable diferente.',
        ];
        $this->validate($rules, $messages);

        try {
            $area = Area::create([
                'codigo' => $this->codigo,
                'name' => $this->name,
                'status' => $this->status,
                'observation' => '',
                'bloque_id' => $this->localidad_id,
                'responsable_id' => $this->responsable_id,
                'user_id' => auth()->user()->id,
            ]);
            $this->emit('registrado', 'La nueva Area: ' . $this->name . ' se registro Correctamente.');
            $this->resetUI();
        } catch (Exception $e) {
            dd($e);
        }
    }

    public function Edit(Area $area)
    {
        $this->selected_id = $area->id;
        $this->codigo = $area->codigo;
        $this->name = $area->name;
        $this->status = $area->status;
        $this->responsable_id = $area->responsable_id;

        $this->bloque_id = $area->bloque_id;
        $bloque = Bloque::find($area->bloque_id);
        $this->bloques = Bloque::where('localidad_id', $bloque->localidad_id)->get();

        $this->localidad_id = $bloque->localidad_id;
        $localidad = Localidad::find($bloque->localidad_id);
        $this->localidades = Localidad::where('municipio_id', $localidad->municipio_id)->get();

        $this->municipio_id = $localidad->municipio_id;
        $municipio = Municipio::find($localidad->municipio_id);
        $this->municipios = Municipio::where('provincia_id', $municipio->provincia_id)->get();

        $this->provincia_id = $municipio->provincia_id;
        $provincia = Provincia::find($municipio->provincia_id);
        $this->provincias = Provincia::where('departamento_id', $provincia->departamento_id)->get();

        $this->departamento_id = $provincia->departamento_id;

        $this->emit('edit', 'open');
    }

    public function Update()
    {
        $rules = [
            'codigo' => "required|unique:areas,codigo,{$this->selected_id}",
            'name' => 'required',
            'status' => 'required|not_in:Elegir',
            'departamento_id' => 'required|not_in:Elegir',
            'provincia_id' => 'required|not_in:Elegir',
            'municipio_id' => 'required|not_in:Elegir',
            'localidad_id' => 'required|not_in:Elegir',
            'bloque_id' => 'required|not_in:Elegir',
            'responsable_id' => 'required|not_in:Elegir'
        ];
        $messages = [
            'codigo.required' => 'Debe ingresar el Codigo de Provincia.',
            'codigo.unique' => 'El Codigo ingresado ya esta siendo utlizado.',
            'name.required' => 'Debe ingresar el nombre de la Provincia.',
            'status.required' => 'Debe selecciona un Estado.',
            'status.not_in' => 'Seleccione un Estado diferente.',
            'departamento_id.required' => 'Debe seleccionar un Departamento.',
            'departamento_id.not_in' => 'Seleccione un Departamento diferente.',
            'provincia_id.required' => 'Debe seleccionar una Provincia.',
            'provincia_id.not_in' => 'Seleccione una Provincia diferente.',
            'municipio_id.required' => 'Debe seleccionar un Municipio.',
            'municipio_id.not_in' => 'Seleccione una Municipio diferente.',
            'localidad_id.required' => 'Debe seleccionar una Localidad.',
            'localidad_id.not_in' => 'Seleccione una Localidad diferente.',
            'bloque_id.required' => 'Debe seleccionar un Bloque',
            'bloque_id.not_in' => 'Seleccione un Bloque diferente.',
            'reponsable_id.required' => 'Debe seleccionar un Responsable para el Area.',
            'reponsable_id.not_in' => 'Seleccione un REsponsable diferente.',
        ];
        $this->validate($rules, $messages);

        try {
            $area = Area::find($this->selected_id);
            $area->update([
                'codigo' => $this->codigo,
                'name' => $this->name,
                'status' => $this->status,
                'observation' => '',
                'bloque_id' => $this->bloque_id,
                'responsable_id' => $this->responsable_id,
                'user_id' => auth()->user()->id,
            ]);
            $this->emit('updated', 'Los Datos del Area: ' . $this->name . ' fueron actualizados correctamente.');
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
        $this->modalTitle = 'REGISTRO NUEVA AREA';
        $this->selected_id = '';
        $this->departamento_id = '';
        $this->provincia_id = '';
        $this->municipio_id = '';
        $this->localidad_id = '';
        $this->responsable_id = '';
        $this->bloque_id = '';
        $this->provincias = [];
        $this->municipios = [];
        $this->localidades = [];
        $this->bloques = [];
    }
    protected $listeners = [
        'Delete' => 'Delete',
        'resetUI' => 'resetUI'
    ];
    public function Delete(Area $area)
    {
        dd("Aqui cuando tengamos el modulo de Activos funcionando");
    }
}
