<?php

namespace App\Http\Livewire;

use Livewire\Component;

use App\Models\User;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Intervention\Image\Facades\Image;

use App\Mail\PasswordMailable;
use Illuminate\Support\Facades\Mail;

class UsersController extends Component
{
    use WithPagination;
    use WithFileUploads;

    protected $paginationTheme = 'bootstrap';

    public $search;
    //variables for the users
    public $selected_id, $name, $surname, $cedula_identidad, $profile, $email, $status, $password, $address, $phone, $image;

    private $pagination = 10;

    public $modalTitle = '';

    public function mount()
    {
        $this->modalTitle = 'REGISTRAR NUEVO USUARIO';
    }

    public function render()
    {
        if (strlen($this->search) > 0) {
            $data = User::where('name', 'like', '%' . $this->search . '%')
                ->select('*')->orderBy('name', 'asc')->paginate($this->pagination);
        } else {
            $data = User::select('*')->orderBy('id', 'asc')->paginate($this->pagination);
        }
        return view('livewire.users.component', [
            'data' => $data,
        ])->layout('layouts.app');
    }

    public function Edit(User $user)
    {
        $this->selected_id = $user->id;
        $this->name = $user->name;
        $this->status = $user->status;
        $this->profile = $user->profile;
        $this->surname = $user->surname;
        $this->phone = $user->phone;
        $this->address = $user->address;
        $this->email = $user->email;
        $this->cedula_identidad = $user->cedula_identidad;
        $this->modalTitle = 'EDITAR USUARIO';
        $this->emit('modalUser', 'open');
    }
    public function Update()
    {
        $rules = [
            'email' => "required|email|unique:users,email,{$this->selected_id}",
            'name' => 'required|min:3',
            'surname' => 'required|min:3',
            'cedula_identidad' => 'required|min:7',
            'phone' => 'required',
            'address' => 'required',
            'status' => 'required|not_in:Elegir',
            'profile' => 'required|not_in:Elegir',
        ];
        $messages = [
            'name.required' => 'Ingrese el Nombre',
            'name.min' => 'El Nombre de Usuario debe tener al menos 3 caracteres.',
            'surname.required' => 'Ingrese el Apellido',
            'surname.min' => 'El Apellido debe tener al menos 3 caracteres.',
            'email.required' => 'Ingrese el email',
            'email.unique' => 'El email ingresado ya esta en uso.',
            'cedula_identidad.required' => 'Ingrese el numero de C.I.',
            'phone.required' => 'Ingrese el Telefono',
            'address.required' => 'Ingrese la Direccion',
            'status.required' => 'Seleccione un estado.',
            'status.not_in' => 'Seleccione un estado diferente.',
            'profile.required' => 'Seleccione un perfil.',
            'profile.not_in' => 'Seleccione un perfil diferente.',
        ];
        $this->validate($rules, $messages);
        try {
            $user = User::find($this->selected_id);
            $user->update([
                'name' => $this->name,
                'surname' => $this->surname,
                'cedula_identidad' => $this->cedula_identidad,
                'email' => $this->email,
                'phone' => $this->phone,
                'profile' => $this->profile,
                'status' => $this->status,
            ]);
            if ($this->image) {
                $customFileName = uniqid() . '_.' . $this->image->extension();
                $ruta = 'C:\laragon\www\Apuestas\public\storage\usuarios/' . $customFileName;
                //dd($ruta);
                $imageTemp = $user->image;

                Image::make($this->image)->widen(720, function ($constraint) {
                    $constraint->upsize();
                })->save($ruta);

                $user->image = $customFileName;
                $user->save();
                if ($imageTemp != null) {
                    if (file_exists('storage/usuarios/' . $imageTemp)) {
                        unlink('storage/usuarios/' . $imageTemp);
                    }
                }
            }
            $this->emit('profile_update', 'Datos Actualizados Correctamente.');
            return redirect()->route('users');
        } catch (Exception $e) {
            dd($e);
        }
    }
    public function resetUI()
    {
        $this->resetValidation();
        $this->image  = '';
        $this->name = '';
        $this->surname = '';
        $this->cedula_identidad = '';
        $this->email = '';
        $this->address = '';
        $this->phone = '';
        $this->status = '';
        $this->profile = '';
        $this->modalTitle = 'REGISTRAR NUEVO USUARIO';
    }
    public function Save()
    {
        $rules = [
            'email' => "required|email|unique:users,email,{$this->selected_id}",
            'name' => 'required|min:3',
            'surname' => 'required|min:3',
            'cedula_identidad' => 'required|min:7',
            'phone' => 'required',
            'address' => 'required',
            'status' => 'required|not_in:Elegir',
            'profile' => 'required|not_in:Elegir',
        ];
        $messages = [
            'name.required' => 'Ingrese el Nombre',
            'name.min' => 'El Nombre de Usuario debe tener al menos 3 caracteres.',
            'surname.required' => 'Ingrese el Apellido',
            'surname.min' => 'El Apellido debe tener al menos 3 caracteres.',
            'email.required' => 'Ingrese el email',
            'email.unique' => 'El email ingresado ya esta en uso.',
            'cedula_identidad.required' => 'Ingrese el numero de C.I.',
            'phone.required' => 'Ingrese el Telefono',
            'address.required' => 'Ingrese la Direccion',
            'status.required' => 'Seleccione un estado.',
            'status.not_in' => 'Seleccione un estado diferente.',
            'profile.required' => 'Seleccione un perfil.',
            'profile.not_in' => 'Seleccione un perfil diferente.',
        ];
        $this->validate($rules, $messages);

        try {
            $user = User::create([
                'name' => $this->name,
                'surname' => $this->surname,
                'cedula_identidad' => $this->cedula_identidad,
                'email' => $this->email,
                'phone' => $this->phone,
                'profile' => $this->profile,
                'status' => $this->status,
                'address' => $this->address,
                'password' => bcrypt($this->cedula_identidad),
            ]);
            if ($this->image) {
                $customFileName = uniqid() . '_.' . $this->image->extension();
                $ruta = 'C:\laragon\www\Apuestas\public\storage\usuarios/' . $customFileName;
                //dd($ruta);
                $imageTemp = $user->image;

                Image::make($this->image)->widen(720, function ($constraint) {
                    $constraint->upsize();
                })->save($ruta);

                $user->image = $customFileName;
                $user->save();
                if ($imageTemp != null) {
                    if (file_exists('storage/usuarios/' . $imageTemp)) {
                        unlink('storage/usuarios/' . $imageTemp);
                    }
                }
            }
            $password = $this->cedula_identidad;
            $name = $this->name . $this->surname;
            $correos = $this->email;
            $correo = new PasswordMailable;
            $correo->with(['password' => $password, 'name' => $name, 'correos' => $correos]);
            Mail::to($this->email)->send($correo);
            $this->emit('profile_update', 'Datos Registrados Correctamente.');
            return redirect()->route('users');
        } catch (Exception $e) {
            dd($e);
        }
    }
    protected $listeners = [
        'DeleteUser' => 'DeleteUser',
        'resetUI' => 'resetUI'
    ];

    public function DeleteUser(User $user)
    {
        if ($user) {
            if ($user->status === 'ACTIVO') {
                $this->emit('deleteError', 'No se puede eliminar este Usuario.');
            } else {
                $user->delete();
                $this->resetUI();
                $this->emit('user-deleted', 'Usuario eliminado correctamente.');
            }
        }
    }
}
