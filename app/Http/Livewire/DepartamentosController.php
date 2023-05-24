<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Departamento;
use app\Models\Provincia;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class DepartamentosController extends Component
{
    use WithPagination;
    use WithFileUploads;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $search, $modalTitle, $codigo, $name, $observation, $status;

    public $selected_id;

    private $pagination = 10;

    public function render()
    {
        if (strlen($this->search) > 0) {
            $data = Departamento::where('name', 'like', '%' . $this->search . '%')
                ->select('*')->orderBy('name', 'asc')->paginate($this->pagination);
        } else {
            $data = Departamento::select('*')->orderBy('id', 'asc')->paginate($this->pagination);
        }
        return view('livewire.ubicacion.departamentos.component ', [
            'data' => $data,
        ])->layout('layouts.app');
    }
    public function mount()
    {
        $this->modalTitle = 'REGISTRO NUEVO DEPARTAMENTO';
    }
    public function Save()
    {
        $rules = [
            'codigo' => 'required',
            'name' => 'required',
            'status' => 'required|not_in:Elegir',
        ];
        $messages = [
            'codigo.required' => 'Debe ingresar el Codigo de Departamento',
            'name.required' => 'Debe ingresar el nombre del Departamento.',
            'status.required' => 'Debe selecciona un Estado.',
            'status.not_in' => 'Seleccione un Estado diferente.',
        ];
        $this->validate($rules, $messages);

        try {
            $depart = Departamento::create([
                'codigo' => $this->codigo,
                'name' => $this->name,
                'status' => $this->status,
                'observation' => $this->observation,
                'user_id' => auth()->user()->id,
            ]);
            $this->emit('registrado', 'El Departamento ' . $this->name . ' se registro Correctamente.');
            $this->resetUI();
        } catch (Exception $e) {
            dd($e);
        }
    }

    public function Edit(Departamento $departamento)
    {
        $this->selected_id = $departamento->id;
        $this->name = $departamento->name;
        $this->codigo = $departamento->codigo;
        $this->observation = $departamento->observation;
        $this->status = $departamento->status;
        $this->emit('edit', 'open');
    }

    public function Update()
    {
        $rules = [
            'codigo' => "required|unique:departamentos,codigo,{$this->selected_id}",
            'name' => 'required',
            'status' => 'required|not_in:Elegir',
        ];
        $messages = [
            'codigo.required' => 'Debe ingresar el Codigo de Departamento',
            'codigo.unique' => 'Este Codigo de Departamento ya se encuentra registrado.',
            'name.required' => 'Debe ingresar el nombre del Departamento.',
            'status.required' => 'Debe selecciona un Estado.',
            'status.not_in' => 'Seleccione un Estado diferente.',
        ];
        $this->validate($rules, $messages);
        try {
            $depart = Departamento::find($this->selected_id);
            $depart->update([
                'codigo' => $this->codigo,
                'name' => $this->name,
                'status' => $this->status,
                'observation' => $this->observation,
                'user_id' => auth()->user()->id,
            ]);
            $this->emit('updated', 'Los Datos del Departamento ' . $this->name . ' fueron actualizados correctamente.');
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
    }
    protected $listeners = [
        'Delete' => 'Delete',
        'resetUI' => 'resetUI'
    ];
    public function Delete(Departamento $departamento)
    {
        $num = $departamento->provincia->count();
        if ($num === 0) {
            $departamento->delete();
            $this->resetUI();
            $this->emit('deleted', 'El Departamento fue eliminado Correctamente.');
        } else {
            $this->emit('errorDelete', 'No se puede Eliminar el Departamento por que Tiene Provincias Asignadas.');
        }
    }
}
