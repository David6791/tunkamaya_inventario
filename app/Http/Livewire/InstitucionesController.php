<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Intervention\Image\Facades\Image;
use App\Models\Institucion;
use App\Models\Departamento;
use App\Models\Provincia;
use App\Models\Municipio;
use App\Models\Localidad;

class InstitucionesController extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $modalTitle;
    protected $pagination = 10;
    protected $paginationTheme = 'bootstrap';
    public $search, $departamentos = [], $provincias = [], $municipios = [], $localidades = [], $selected_id, $departamento_id, $provincia_id, $municipio_id, $localidad_id, $image, $codigo_id, $nombre, $contacto, $responsable, $direccion, $email, $telefono, $status;
    public function mount()
    {
        $this->modalTitle = 'REGISTRAR NUEVA INSTITUCION';
    }
    public function render()
    {
        if (strlen($this->search) > 0) {
            $data = Institucion::where('nombre', 'like', '%' . $this->search . '%')
                ->select('*')->orderBy('nombre', 'asc')->paginate($this->pagination);
        } else {
            $data = Institucion::select('*')->orderBy('id', 'asc')->paginate($this->pagination);
        }
        $this->departamentos = Departamento::orderBy('id', 'asc')->get();
        return view('livewire.instituciones.component', [
            'data' => $data,
            'departamentos' => $this->departamentos
        ])->layout('layouts.app');
    }
    public function select_depart($id)
    {
        $this->provincias = Provincia::where('departamento_id', '=', $id)->get();
        $this->municipios = [];
        $this->localidades = [];
        $this->provincia_id = 'Elegir';
        $this->municipio_id = 'Elegir';
        $this->localidad_id = 'Elegir';
    }
    public function select_prov($id)
    {
        $this->municipios = Municipio::where('provincia_id', '=', $id)->get();
        $this->localidades = [];
        $this->municipio_id = 'Elegir';
        $this->localidad_id = 'Elegir';
    }
    public function select_muni($id)
    {
        $this->localidades = Localidad::where('municipio_id', '=', $id)->get();
        $this->localidad_id = 'Elegir';
    }

    public function resetUI()
    {
        $this->resetValidation();
        $this->codigo_id  = '';
        $this->nombre = '';
        $this->responsable = '';
        $this->contacto = '';
        $this->direccion = '';
        $this->telefono = '';
        $this->email = '';
        $this->image = '';
        $this->status = '';
        $this->modalTitle = 'REGISTRO NUEVA INSTITUCION';
        $this->selected_id = '';
        $this->departamento_id = '';
        $this->provincia_id = '';
        $this->municipio_id = '';
        $this->localidad_id = '';
        $this->provincias = [];
        $this->municipios = [];
        $this->localidades = [];
    }
    public function Save()
    {
        //dd($this->nombre);
        $rules = [
            'codigo_id' => "required|unique:institucion",
            'nombre' => 'required|unique:institucion',
            'responsable' => 'required',
            'contacto' => 'required',
            'direccion' => 'required',
            'email' => 'required',
            'telefono' => 'required',
            'image' => 'required',
            'status' => 'required|not_in:Elegir',
            'departamento_id' => 'required|not_in:Elegir',
            'provincia_id' => 'required|not_in:Elegir',
            'municipio_id' => 'required|not_in:Elegir',
            'localidad_id' => 'required|not_in:Elegir'
        ];
        $messages = [
            'codigo_id.required' => 'Debe ingresar el Codigo de Institucion',
            'codigo_id.unique' => 'Este Codigo ya fue Registrado',
            'nombre.required' => 'Debe ingresar el nombre de la Institucion.',
            'nombre.unique' => 'El nombre de esta Institucion ya fue Registrado',
            'responsable.required' => 'Debe ingresar el nombre de un Responsable.',
            'contacto.required' => 'Debe ingresar el nombre de un Contacto.',
            'direccion.required' => 'Debe ingresar una direccion.',
            'email.required' => 'Debe ingresar una direccion de correo Electronico.',
            'telefono.required' => 'Debe ingresar un telefono de Contacto.',
            'image.required' => 'Debe ingresar una imagen como Logo.',
            'status.required' => 'Debe selecciona un Estado.',
            'status.not_in' => 'Seleccione un Estado diferente.',
            'departamento_id.required' => 'Debe seleccionar un Departamento',
            'departamento_id.not_in' => 'Seleccione un Departamento diferente.',
            'provincia_id.required' => 'Debe seleccionar una Provincia',
            'provincia_id.not_in' => 'Seleccione una Provincia diferente.',
            'municipio_id.required' => 'Debe seleccionar un Municipio',
            'municipio_id.not_in' => 'Seleccione una Municipio diferente.',
            'localidad_id.required' => 'Debe seleccionar una Localidad',
            'localidad_id.not_in' => 'Seleccione una Localidad diferente.',
        ];
        $this->validate($rules, $messages);

        try {
            $intitucion = Institucion::create([
                'codigo_id' => $this->codigo_id,
                'nombre' => $this->nombre,
                'responsable' => $this->responsable,
                'contacto' => $this->contacto,
                'direccion' => $this->direccion,
                'email' => $this->email,
                'telefono' => $this->telefono,
                'status' => $this->status,
                'localidad_id' => $this->localidad_id,
                'ejemplo_codificacion ' => [],
                'detalle_codificacion ' => [],
                'user_id' => auth()->user()->id,
            ]);
            if ($this->image) {
                $customFileName = uniqid() . '_.' . $this->image->extension();
                $ruta = 'C:\laragon\www\Apuestas\public\storage\instituciones/' . $customFileName;
                //dd($ruta);
                $imageTemp = $intitucion->image;

                Image::make($this->image)->widen(720, function ($constraint) {
                    $constraint->upsize();
                })->save($ruta);

                $intitucion->image = $customFileName;
                $intitucion->save();
                if ($imageTemp != null) {
                    if (file_exists('storage/instituciones/' . $imageTemp)) {
                        unlink('storage/instituciones/' . $imageTemp);
                    }
                }
            }
            $this->emit('registrado', 'La nueva INSTITUCION: ' . $this->nombre . ' se registro Correctamente.');
            $this->resetUI();
        } catch (Exception $e) {
            dd($e);
        }
    }
    public function detalles_institucion(Institucion $institucion)
    {
        $id = $institucion->id;
        return redirect()->route('detalle_institucion', ['p' => $id]);
    }
}
