<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Spatie\Permission\Models\Role;

class RolesController extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $search, $selected_id, $name, $guard_name;

    private $pagination = 10;

    public $modalTitle;
    protected $paginationTheme = 'bootstrap';


    public function  mount()
    {
        $this->modalTitle = 'REGISTRAR NUEVO ROL DE USUARIO';
    }

    public function render()
    {
        if (strlen($this->search) > 0) {
            $data = Role::where('id', 'like', '%' . $this->search . '%')->orderBy('id', 'asc')->paginate($this->pagination);
        } else {
            $data = Role::orderBy('id', 'asc')->paginate($this->pagination);
        }
        return view('livewire.users.roles.component', [
            'data' => $data
        ])->layout('layouts.app');
    }
    public function Save()
    {
        $rules = [
            'name' => 'required|min:5|unique:roles,name'
        ];
        $messages = [
            'name.required' => 'El nombre del Rol es Requerido',
            'name.unique' => 'El rol ya esta Registrado',
            'name.min' => 'El nombre del Rol debe tener al menos 5 caracteres'
        ];
        $this->validate($rules, $messages);
        Role::create([
            'name' => $this->name,
            'guard_name' => $this->guard_name,
        ]);
        $this->emit('role-added', 'El rol ' . $this->name . ' fue Registrado Exitosamente.');
        $this->resetUI();
    }
    public function Edit(Role $role)
    {
        $this->selected_id = $role->id;
        $this->name = $role->name;
        $this->guard_name = $role->guard_name;
        $this->emit('role-edit', 'open');
    }
    public function resetUI()
    {
        $this->resetValidation();
        $this->name = '';
        $this->guard_name = '';
    }
    public function Update()
    {
        $rules = [
            'name' => "required|min:5|unique:roles,name,{$this->selected_id}"
        ];
        $messages = [
            'name.required' => 'El nombre del Rol es Requerido',
            'name.unique' => 'El rol ya esta Registrado',
            'name.min' => 'El nombre del Rol debe tener al menos 5 caracteres'
        ];
        $this->validate($rules, $messages);
        $role = Role::find($this->selected_id);
        $role->name = $this->name;
        $role->guard_name = $this->guard_name;
        $role->save();
        $this->emit('role-updated', 'El rol' . $this->name . 'se actualizo correctamente');
        $this->resetUI();
    }
    protected $listeners = ['DeleteRole' => 'DeleteRole'];
    public function DeleteRole(Role $role)
    {
        $permissionCount = Role::find($role->id)->permissions->count();
        if ($permissionCount > 0) {
            $this->emit('role-error', 'No se pude eliminar el rol ' . $role->name . ' por que tiene permisos');
            return;
        }
        Role::find($role->id)->delete();
        $this->emit('role-deleted', 'Se Elimino el Rrol' . $role->name . ' correctamente');
    }
}
