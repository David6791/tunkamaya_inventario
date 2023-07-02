<?php

namespace App\Http\Livewire;

use App\Models\Institucion;
use Livewire\Component;

use App\Models\Responsable;

use Livewire\WithPagination;
use Livewire\WithFileUploads;

class ResponsablesController extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $search, $selected_id, $ci, $nombres, $apellidos, $status, $cargo, $instituciones = [], $institucion_id;

    private $pagination = 10;

    public $modalTitle;
    protected $paginationTheme = 'bootstrap';

    public function render()
    {

        if (strlen($this->search) > 0) {
            $data = Responsable::join('institucion as i', 'i.id', 'responsables.institucion_id')->select('responsables.*', 'i.nombre as institucion')->where('responsables.ci', 'like', '%' . $this->search . '%')->orderBy('id', 'asc')->paginate($this->pagination);
        } else {
            $data = Responsable::join('institucion as i', 'i.id', 'responsables.institucion_id')->select('responsables.*', 'i.nombre as institucion')->orderBy('responsables.ci', 'asc')->paginate($this->pagination);
        }
        $this->instituciones = Institucion::orderBy('id', 'asc')->get();

        return view('livewire.infraestructura.responsables.component', [
            'data' => $data
        ])->layout('layouts.app');
    }
    public function mount()
    {
        $this->modalTitle = 'Registrar Nuevo Resposable';
    }

    public function Save()
    {
        $rules = [
            'ci' => 'required',
            'nombres' => 'required',
            'apellidos' => 'required',
            'cargo' => 'required',
            'status' => 'required|not_in:Elegir',
            'institucion_id' => 'required|not_in:Elegir'
        ];
        $messages = [
            'ci.required' => 'Debe ingresar la Cedula de Identidad',
            'nombres.required' => 'Debe ingresar los Nombres',
            'apellidos.required' => 'Debe ingresar los Apellidos',
            'cargo.required' => 'Debe ingresar el Cargo',
            'status.required' => 'Debe selecciona un Estado.',
            'status.not_in' => 'Seleccione un Estado diferente.',
            'institucion_id.required' => 'Debe seleccionar la Institucion para este Responsable.',
            'institucion_id.not_in' => 'Seleccione una Institucion diferente.',
        ];
        $this->validate($rules, $messages);
        try {
            $resp = Responsable::create([
                'ci' => $this->ci,
                'nombres' => $this->nombres,
                'apellidos' => $this->apellidos,
                'cargo' => $this->cargo,
                'status' => $this->status,
                'institucion_id' => $this->institucion_id,
                'user_id' => auth()->user()->id,
            ]);
            $this->emit('registrado', 'El Responsable: ' . $this->nombres . ' se registro Correctamente.');
            $this->resetUI();
        } catch (Exception $e) {
        }
    }
    public function resetUI()
    {
        $this->resetValidation();
        $this->ci  = '';
        $this->nombres = '';
        $this->apellidos = '';
        $this->cargo = '';
        $this->status = '';
        $this->selected_id = '';
        $this->institucion_id = '';
    }
    public function Edit(Responsable $responsable)
    {
        $this->selected_id = $responsable->id;
        $this->ci = $responsable->ci;
        $this->nombres = $responsable->nombres;
        $this->apellidos = $responsable->apellidos;
        $this->status = $responsable->status;
        $this->cargo = $responsable->cargo;
        $this->institucion_id = $responsable->institucion_id;
        $this->emit('edit', 'open');
    }
    public function Update()
    {
        $rules = [
            'ci' => "required|unique:responsables,ci,{$this->selected_id}",
            'nombres' => 'required',
            'apellidos' => 'required',
            'cargo' => 'required',
            'status' => 'required|not_in:Elegir',
            'institucion_id' => 'required|not_in:Elegir',
        ];
        $messages = [
            'ci.required' => 'Debe ingresar la Cedula de Identidad',
            'ci.unique' => 'La Cedula de Identidad ingresada ya fue Registrada',
            'nombres.required' => 'Debe ingresar los Nombres',
            'apellidos.required' => 'Debe ingresar los Apellidos',
            'cargo.required' => 'Debe ingresar el Cargo',
            'status.required' => 'Debe selecciona un Estado.',
            'status.not_in' => 'Seleccione un Estado diferente.',
            'institucion_id.required' => 'Debe seleccionar la Institucion para este Responsable.',
            'institucion_id.not_in' => 'Seleccione una Institucion diferente.',
        ];
        $this->validate($rules, $messages);

        try {
            $local = Responsable::find($this->selected_id);
            $local->update([
                'ci' => $this->ci,
                'nombres' => $this->nombres,
                'apellidos' => $this->apellidos,
                'status' => $this->status,
                'cargo' => $this->cargo,
                'institucion_id' => $this->institucion_id,
                'user_id' => auth()->user()->id,
            ]);
            $this->emit('updated', 'Los Datos del Responsable: ' . $this->apellidos . ' ' . $this->apellidos . ' fueron actualizados correctamente.');
            $this->resetUI();
        } catch (Exception $e) {
            dd($e);
        }
    }
    protected $listeners = [
        'Delete' => 'Delete',
        'resetUI' => 'resetUI'
    ];
    public function Delete(Responsable $responsable)
    {
        if ($responsable->areas->count() === 0) {
            $responsable->delete();
            $this->resetUI();
            $this->emit('deleted', 'El Registro del Responsable fue eliminado Correctamente.');
        } else {
            $this->emit('errorDelete', 'No se puede Eliminar el registro de la Localidad por que tiene Bloques Asignados.');
        }
    }
}
