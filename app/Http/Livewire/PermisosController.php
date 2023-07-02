<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;

class PermisosController extends Component
{
    use WithPagination;
    public $permissionName, $search, $selected_id, $modalTitle, $name, $guard_name;
    private $pagination = 10;
    protected $paginationTheme = 'bootstrap';
    public function mount()
    {
        $this->modalTitle = 'Registro de Nuevos Permisos';
    }
    public function render()
    {
        if (strlen($this->search) > 0)
            $permisos = Permission::where('name', 'like', '%' . $this->search . '%')->paginate($this->pagination);
        else
            $permisos = Permission::orderby('name', 'asc')->paginate($this->pagination);
        return view('livewire.users.permisos.component', [
            'data' => $permisos,
        ])->layout('layouts.app');
    }
    public function Save()
    {
        $rules = [
            'name' => 'required|min:5|unique:permissions,name'
        ];
        $messages = [
            'name.required' => 'El nombre del Permisos es Requerido',
            'name.unique' => 'El rol ya esta Registrado',
            'name.min' => 'El nombre del Permisos debe tener al menos 5 caracteres'
        ];
        $this->validate($rules, $messages);
        Permission::create([
            'name' => $this->name,
        ]);
        $this->emit('success', 'El Permiso ' . $this->name . ' fue Registrado Exitosamente.');
        $this->resetUI();
    }
    public function resetUI()
    {
        $this->resetValidation();
        $this->name = '';
        $this->guard_name = '';
        $this->search = '';
        $this->selected_id = 0;
    }
    public function Edit(Permission $permiso)
    {
        $this->selected_id = $permiso->id;
        $this->name = $permiso->name;
        $this->guard_name = $permiso->guard_name;

        $this->emit('show-modal', 'show-modal');
    }
    public function Update()
    {
        $rules = [
            'name' => "required|min:5|unique:permissions,name,{$this->selected_id}"
        ];
        $messages = [
            'name.required' => 'El nombre del Permiso es Requerido',
            'name.unique' => 'Este permiso ya esta Registrado',
            'name.min' => 'El nombre del Permiso debe tener al menos 5 caracteres'
        ];
        $this->validate($rules, $messages);
        $permission = Permission::find($this->selected_id);
        $permission->name = $this->name;
        $permission->guard_name = $this->guard_name;
        $permission->save();
        $this->emit('success', 'El Permiso ' . $this->name . ' se Actualizo correctamente');
        $this->resetUI();
    }
    protected $listeners = ['DeletePermiso' => 'DeletePermiso'];
    public function DeletePermiso($id)
    {
        $rolesCount = Permission::find($id)->getRoleNames()->count();
        if ($rolesCount > 0) {
            $this->emit('error', 'No se pude eliminar el permiso por que tiene roles asociados');
            return;
        }
        Permission::find($id)->delete();
        $this->emit('success', 'Se Elimino el Permiso correctamente');
    }
}
