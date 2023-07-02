<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Grupo;
use Spatie\Permission\Models\Role;

class GruposController extends Component
{

    protected $paginationTheme = 'bootstrap';

    public $search, $selected_id, $name, $status, $codigo;

    public $modalTitle;

    private $pagination = 10;
    public $us, $r;

    public function mount()
    {
        $this->modalTitle = 'REGISTRAR NUEVO GRUPO CONTABLE';
        $this->us = Auth::user();
        $this->r = $this->us->getRoleNames();
    }

    public function render()
    {
        if ($this->r[0] === 'Super Administrador') {
            if (strlen($this->search) > 0) {
                $data = Grupo::where('name', 'like', '%' . $this->search . '%')
                    ->join('institucion as i', 'i.id', 'grupos.institucion_id')
                    ->select('grupos.*', 'i.nombre as institucion')->orderBy('name', 'asc')->paginate($this->pagination);
            } else {
                $data = Grupo::join('institucion as i', 'i.id', 'grupos.institucion_id')->select('grupos.*', 'i.nombre as institucion')->orderBy('id', 'asc')->paginate($this->pagination);
            }
        } else {
            if (strlen($this->search) > 0) {
                $data = Grupo::where('name', 'like', '%' . $this->search . '%')
                    ->where('institucion_id', '=', session('institucion'))
                    ->select('*')->orderBy('name', 'asc')->paginate($this->pagination);
            } else {
                $data = Grupo::select('*')->where('institucion_id', '=', session('institucion'))->orderBy('id', 'asc')->paginate($this->pagination);
            }
        }
        return view('livewire.clasificacion.grupos.component', [
            'data' => $data
        ])->layout('layouts.app');
    }
    public function Save()
    {
        $rules = [
            'codigo' => 'required',
            'name' => 'required',
            'status' => 'required|not_in:Elegir',
        ];
        $messages = [
            'codigo.required' => 'Debe ingresar un Codigo.',
            'name.required' => 'Debe ingresar el Nombre del Activo',
            'status.required' => 'Debe selecciona un Estado.',
            'status.not_in' => 'Seleccione un Estado diferente.',
        ];
        $this->validate($rules, $messages);

        try {
            $grupo = Grupo::create([
                'codigo' => $this->codigo,
                'name' => $this->name,
                'status' => $this->status,
                'institucion_id' => session('institucion'),
                'user_id' => auth()->user()->id,
            ]);
            $this->emit('registrado', 'El Grupo Contable: ' . $this->name . '  se registro Correctamente.');
            $this->resetUI();
        } catch (Exception $e) {
            dd($e);
        }
    }
    public function Edit(Grupo $grupo)
    {
        $this->modalTitle = 'EDITAR ACTIVO: ' . $grupo->name;
        $this->selected_id = $grupo->id;
        $this->codigo = $grupo->codigo;
        $this->name = $grupo->name;
        $this->status = $grupo->status;
        $this->emit('edit', 'open');
    }
    public function Update()
    {
        $rules = [
            'codigo' => "required|unique:grupos,codigo,{$this->selected_id}",
            'name' => 'required',
            'status' => 'required|not_in:Elegir',
        ];
        $messages = [
            'codigo.required' => 'Debe ingresar un Codigo.',
            'codigo.unique' => 'El Codigo que ingreso ya esta siendo utilizado.',
            'name.required' => 'Debe ingresar el Nombre del Activo',
            'status.required' => 'Debe selecciona un Estado.',
            'status.not_in' => 'Seleccione un Estado diferente.',
        ];
        $this->validate($rules, $messages);

        try {
            $grupo = Grupo::find($this->selected_id);
            $grupo->update([
                'codigo' => $this->codigo,
                'name' => $this->name,
                'status' => $this->status,
                'user_id' => auth()->user()->id,
            ]);
            $this->emit('updated', 'Los Datos del Grupo Contable: ' . $this->name . ' fue actualizados correctamente.');
            $this->resetUI();
        } catch (Exception $e) {
            dd($e);
        }
    }
    protected $listeners = [
        'Delete' => 'Delete',
        'resetUI' => 'resetUI'
    ];
    public function Delete(Grupo $grupo)
    {
        if ($grupo->tipos->count() === 0) {
            $grupo->delete();
            $this->resetUI();
            $this->emit('deleted', 'El Registro del Grupo Contable fue eliminado Correctamente.');
        } else {
            $this->emit('errorDelete', 'No se puede Eliminar el registro del Grupo Contablepor que tiene Tipos Asignados.');
        }
    }
    public function resetUI()
    {
        $this->resetValidation();
        $this->codigo  = '';
        $this->name = '';
        $this->status = '';
        $this->selected_id = '';
        $this->modalTitle = 'REGISTRO DE TIPOS DE ACTIVOS';
    }
}
