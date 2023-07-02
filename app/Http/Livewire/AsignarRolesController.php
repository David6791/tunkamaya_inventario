<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use Spatie\Permission\Models\Role;

class AsignarRolesController extends Component
{
    use WithPagination;
    public $search, $modalTitle, $selected_id, $roles_se = [], $role_id;
    protected $pagination = 10;
    protected $paginationTheme = 'bootstrap';

    public function mount()
    {
        $this->modalTitle = 'Cambiar Rol a Usuario';
    }
    public function render()
    {
        if (strlen($this->search) > 0) {
            $data = User::join('model_has_roles as mr', 'mr.model_id', 'users.id')
                ->join('roles as r', 'r.id', 'mr.role_id')
                ->select('users.*', 'r.name as role_name')->where('cedula_identidad', 'like', '%' . $this->search . '%')->orderBy('id', 'asc')->paginate($this->pagination);
        } else {
            $data = User::join('model_has_roles as mr', 'mr.model_id', 'users.id')
                ->join('roles as r', 'r.id', 'mr.role_id')
                ->select('users.*', 'r.name as role_name')->orderBy('users.id', 'asc')->paginate($this->pagination);
        }
        return view('livewire.users.asignarroles.component', [
            'data' => $data,
        ])->layout('layouts.app');
    }
    public function Edit(User $user)
    {
        $this->roles_se = Role::orderBy('id', 'asc')->get();
        $this->selected_id = $user->id;
        $roles = $user->getRoleNames();
        $id_rol = Role::findByName($roles[0]);
        $this->role_id = $id_rol->id;
        $this->emit('show-modal', 'open');
    }
    public function resetUI()
    {
        $this->resetValidation();
        $this->selected_id = '';
        $this->role_id = '';
    }
    public function Update()
    {
        $user = User::find($this->selected_id);
        $user->syncRoles($this->role_id);
        $this->emit('success', 'Se asigno el nuevo Rol al Usuario: ' . $user->name . ' correctamente.');
        $this->resetUI();
    }
}
