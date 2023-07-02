<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use DB;

class AsignarController extends Component
{
    use WithPagination;
    public $role, $permisosSelected = [], $old_permissions = [], $pageTitle, $componentName;
    private $pagination = 10;
    protected $paginationTheme = 'bootstrap';
    public function mount()
    {
        $this->role = 'Elegir';
    }

    public function render()
    {
        $permisos = Permission::select('name', 'id', DB::raw("0 as checked"))
            ->orderBy('name', 'asc')->paginate($this->pagination);
        if ($this->role != 'Elegir') {
            $list = Permission::join('role_has_permissions as rp', 'rp.permission_id', 'permissions.id')
                ->where('role_id', $this->role)->pluck('permissions.id')->toArray();
            $this->old_permissions = $list;
        }
        if ($this->role != 'Elegir') {
            foreach ($permisos as $permiso) {
                $role = Role::find($this->role);
                $tienePermiso = $role->hasPermissionTo($permiso->name);
                if ($tienePermiso) {
                    $permiso->checked = 1;
                }
            }
        }
        return view('livewire.users.asignaciones.component', [
            'roles' => Role::orderBy('id', 'asc')->get(),
            'permisos' => $permisos
        ])->layout('layouts.app');
    }
    public $listeners = ['revokeall' => 'removeAll'];
    public function removeAll()
    {
        if ($this->role == "Elegir") {
            $this->emit('Sync-error', 'Selecciona un rol valido');
            return;
        }
        $role = Role::find($this->role);
        $role->syncPermissions([0]);
        $this->emit('removeall', "Se revocaron todos los permisos al ROL $role->name");
    }
    public function SyncAll()
    {
        if ($this->role == "Elegir") {
            $this->emit('Sync-error', 'Selecciona un rol valido');
            return;
        }
        $role = Role::find($this->role);
        $permisos = Permission::pluck('id')->toArray();
        $role->syncPermissions($permisos);
        $this->emit('syncall', "Se sincronizaron todos los permisos al ROl $role->name");
    }
    public function SyncPermiso($state, $permisoName)
    {
        if ($this->role != "Elegir") {
            $roleName = Role::find($this->role);
            if ($state) {
                $roleName->givePermissionTo($permisoName);
                $this->emit('permi', 'Permiso asignado Correctamente');
            } else {
                $roleName->revokePermissionTo($permisoName);
                $this->emit('permi', 'Permiso Eliminado Correctamente');
            }
        }
        $this->emit('permi', 'Elige un rol Valido');
    }
}
