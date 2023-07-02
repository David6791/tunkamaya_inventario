<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
//prueba
use Intervention\Image\Facades\Image;


use Livewire\WithPagination;
use Livewire\WithFileUploads;

class ProfileController extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $user_id = 0, $form = false;
    public $name, $surname, $phone, $address, $email, $image, $cedula_identidad, $selected_id;
    public $pass_val;

    //public vars for the change password
    public $password, $old_password, $re_password;

    //public vars for the show and hide passwords
    public $oldShowPassword, $showPassword, $showRePassword;
    protected $paginationTheme = 'bootstrap';
    public $modalTitle = '';

    public function mount()
    {
        $this->modalTitle = 'CAMBIAR CONTRASEÑA';
    }

    public function render()
    {
        $user = User::find(auth()->user()->id);
        return view('livewire.profile.component', ['user' => $user])->layout('layouts.app');
    }
    public function Edit(User $user)
    {
        $this->selected_id = $user->id;
        $this->user_id = $user->id;
        $this->name = $user->name;
        $this->surname = $user->surname;
        $this->phone = $user->phone;
        $this->address = $user->address;
        $this->email = $user->email;
        $this->form = true;
        $this->cedula_identidad = $user->cedula_identidad;
        $this->pass_val = $user->password;
        //return $this->user_id;
    }
    public function Store()
    {
        $rules = [
            'email' => "required|email|unique:users,email,{$this->selected_id}",
            'name' => 'required|min:3',
            'surname' => 'required|min:3',
            'cedula_identidad' => 'required|min:7',
            'phone' => 'required',
            'address' => 'required',
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
        ];
        $this->validate($rules, $messages);
        try {
            $user = User::find($this->selected_id);
            $user->update([
                'name' => $this->name,
                'surname' => $this->surname,
                'email' => $this->email,
                'phone' => $this->phone,
                'address' => $this->address,
                'cedula_identidad' => $this->cedula_identidad,

            ]);
            //para guardar imagenes sin rezise
            /*if($this->image){
                $customFileName = uniqid() . '_.' . $this->image->extension();
                $this->image->storeAs('public/usuarios',$customFileName);
                $imageTemp = $user->image;
                $user->image = $customFileName;
                $user->save();
                if($imageTemp != null){
                    if(file_exists('storage/usuarios/'.$imageTemp)){
                        unlink('storage/usuarios/'.$imageTemp);
                    }
                }
            }
            $user->save();*/
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
            return redirect()->route('profile');
        } catch (Exception $e) {
            dd($e);
        }
    }
    public function resetUI()
    {
        $this->resetValidation();
        $this->form = false;
        $this->photo  = '';
        $this->old_password = '';
        $this->password = '';
        $this->re_password = '';
    }

    protected $listeners = [
        'resetUI' => 'resetUI'
    ];

    public function Edit_password(User $user)
    {
        $this->selected_id = $user->id;

        $this->emit('show-modal', 'Show Modal');
    }

    public function SaveNewPassword()
    {
        $rules = [
            'old_password' => 'required|min:8',
            'password' => 'required|min:8',
            're_password' => 'required|min:8',
        ];
        $messages = [
            'old_password.required' => 'Debe ingresar su ANTIGUA contraseña',
            'old_password.min' => 'Su contraseña debe tener al menos 8 caracteres.',
            'password.required' => 'Debe ingresar su NUEVA contraseña',
            'password.min' => 'Su contraseña debe tener al menos 8 caracteres.',
            're_password.required' => 'Debe ingresar su NUEVA contraseña',
            're_password.min' => 'Su contraseña debe tener al menos 8 caracteres.',
        ];
        $this->validate($rules, $messages);

        if (User::check_old_password($this->selected_id, $this->old_password)) {
            if (strcmp($this->password, $this->re_password) === 0) {
                $user = User::find($this->selected_id);
                $user->update([
                    'password' => bcrypt($this->password)
                ]);
                $this->emit('profile_success', 'Contraseña ACTUALIZADA CORRECTAMENTE.');
                $this->resetUI();
            } else {
                $this->emit('profile_errors', 'Revise los Campos de su Nueva Contraseña.');
            }
        } else {
            $this->emit('profile_errors', 'Su contraseña ANTIGUA es Incorrecta.');
        }
    }
}
