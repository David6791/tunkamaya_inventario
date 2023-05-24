<?php

namespace App\Http\Livewire;

use Livewire\Component;

use App\Models\Responsable;

use Livewire\WithPagination;
use Livewire\WithFileUploads;

class ResponsablesController extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $search, $selected_id, $ci, $nombres, $apellidos, $status, $cargo;

    private $pagination = 10;

    public $modalTitle;
    protected $paginationTheme = 'bootstrap';

    public function render()
    {

        if (strlen($this->search) > 0) {
            $data = Responsable::where('ci', 'like', '%' . $this->search . '%')->orderBy('id', 'asc')->paginate($this->pagination);
        } else {
            $data = Responsable::orderBy('ci', 'asc')->paginate($this->pagination);
        }

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
        ];
        $messages = [
            'ci.required' => 'Debe ingresar la Cedula de Identidad',
            'nombres.required' => 'Debe ingresar los Nombres',
            'apellidos.required' => 'Debe ingresar los Apellidos',
            'cargo.required' => 'Debe ingresar el Cargo',
            'status.required' => 'Debe selecciona un Estado.',
            'status.not_in' => 'Seleccione un Estado diferente.',
        ];
        $this->validate($rules, $messages);
        try {
            $resp = Responsable::create([
                'ci' => $this->ci,
                'nombres' => $this->nombres,
                'apellidos' => $this->apellidos,
                'cargo' => $this->cargo,
                'status' => $this->status,
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
    }
    public function Edit(Responsable $responsable)
    {
        $this->selected_id = $responsable->id;
        $this->ci = $responsable->ci;
        $this->nombres = $responsable->nombres;
        $this->apellidos = $responsable->apellidos;
        $this->status = $responsable->status;
        $this->cargo = $responsable->cargo;
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
        ];
        $messages = [
            'ci.required' => 'Debe ingresar la Cedula de Identidad',
            'ci.unique' => 'La Cedula de Identidad ingresada ya fue Registrada',
            'nombres.required' => 'Debe ingresar los Nombres',
            'apellidos.required' => 'Debe ingresar los Apellidos',
            'cargo.required' => 'Debe ingresar el Cargo',
            'status.required' => 'Debe selecciona un Estado.',
            'status.not_in' => 'Seleccione un Estado diferente.',
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
