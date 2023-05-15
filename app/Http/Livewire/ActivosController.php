<?php

namespace App\Http\Livewire;

use Livewire\Component;

use Livewire\WithPagination;
use Livewire\WithFileUploads;

use App\Models\Activo;

class ActivosController extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $selected_id, $codigo, $status, $fecha_registro, $description, $costo, $uniq_id;

    protected $paginationTheme = 'bootstrap';

    public $search;

    private $pagination = 10;

    public $modalTitle = '';

    public function mount()
    {
        $this->modalTitle = 'DETALLES DE ACTIVO';
    }


    public function render()
    {
        if (strlen($this->search) > 0) {
            $data = Activo::where('codigo', 'like', '%' . $this->search . '%')
                ->select('*')->orderBy('codigo', 'asc')->paginate($this->pagination);
        } else {
            $data = Activo::select('*')->orderBy('id', 'asc')->paginate($this->pagination);
        }
        return view('livewire.activos.component', [
            'data' => $data
        ])->layout('layouts.app');
    }

    public function Show(Activo $activo)
    {
        $this->codigo = $activo->codigo;
        $this->costo = number_format($activo->costo);
        $this->status = $activo->status;
        $this->fecha_registro = $activo->fecha_registro;
        $this->description = $activo->description;
        $this->emit('modalShowActivo', 'open');
    }
    public function addNweActivo()
    {
        $this->modalTitle = 'REGISTRAR ACTIVO NUEVO';
        $last_activo = Activo::latest()->first();
        $this->codigo = $last_activo->codigo;
        $numbers = explode("-", $this->codigo);

        if ($numbers[2] > 0 && $numbers[2] < 99) {
            $numbers[2] = $numbers[2] + 1;
        } else {
            $numbers[2] = 1;
            $numbers[1] = $numbers[1] + 1;
        }
        $this->codigo = implode("-", $numbers);
        $this->emit('modalAddctivo', 'open');
    }
    public function resetUI()
    {
        $this->resetValidation();
        $this->codigo  = '';
        $this->costo = '';
        $this->status = '';
        $this->fecha_registro = '';
        $this->description = '';
        $this->modalTitle = 'DETALLES DE ACTIVO';
    }
    public function Save()
    {
        $rules = [
            'codigo' => 'required',
            'costo' => 'required|numeric',
            'fecha_registro' => 'required|date',
            'description' => 'required',
        ];
        $messages = [
            'codigo.required' => 'Debe ingresar el CODIGO DEL ACTIVO',
            'costo.required' => 'Debe ingresar el COSTO DE ADQUISICION DEL ACTIVO.',
            'costo.numeric' => 'Este campo debe ser de tipo Numero.',
            'fecha_registro.required' => 'Debe Ingresar la Fecha de ADQUISICION DEL ACTIVO.',
            'fecha_registro.date' => 'Este Campo debe ser de tipo FECHA.',
            'description.required' => 'Debe Ingresar la Descripcion completa del Activo.',
        ];
        $this->validate($rules, $messages);
        try {
            $last_activo = Activo::latest()->first();
            $codigo_ant = $last_activo->codigo;
            $numbers = explode("-", $codigo_ant);
            if ($numbers[2] > 0 && $numbers[2] < 99) {
                $numbers[2] = $numbers[2] + 1;
            } else {
                $numbers[2] = 1;
                $numbers[1] = $numbers[1] + 1;
            }
            $codigo_ant = implode("-", $numbers);
            if ($codigo_ant === $this->codigo) {
                $user = Activo::create([
                    'codigo' => $this->codigo,
                    'costo' => $this->costo,
                    'fecha_registro' => $this->fecha_registro,
                    'description' => $this->description,
                    'uniq_id' => uniqid(),
                    'user_id' => auth()->user()->id,
                    'status' => 0
                ]);
                $this->emit('activo_register', 'Activo Registrado Correctamente.');
                $this->resetUI();
            } else {
                $this->codigo = $last_activo->codigo;
                $numbers = explode("-", $this->codigo);

                if ($numbers[2] > 0 && $numbers[2] < 99) {
                    $numbers[2] = $numbers[2] + 1;
                } else {
                    $numbers[2] = 1;
                    $numbers[1] = $numbers[1] + 1;
                }
            }
        } catch (Exception $e) {
            dd($e);
        }
    }
    protected $listeners = [
        'DeleteActivo' => 'DeleteActivo',
        'resetUI' => 'resetUI'
    ];
    public function DeleteActivo(Activo $activo)
    {
        if ($activo->status === 1) {
            $this->emit('errorDelete', 'No se puede Eliminar el Activo por que ya fue INVENTARIADO.');
        } else {
            $activo->delete();
            $this->resetUI();
            $this->emit('successDelete', 'Activo Eliminado Correctamente.');
        }
    }
    public function Edit(Activo $activo)
    {
        $this->selected_id = $activo->id;
        $this->codigo = $activo->codigo;
        $this->costo = $activo->costo;
        $this->status = $activo->status;
        $this->description = $activo->description;
        $this->fecha_registro = $activo->fecha_registro;
        $this->uniq_id = $activo->uniq_id;
        $this->emit('modalAddctivo', 'open');
    }
    public function Update()
    {
        $rules = [
            'codigo' => "required|unique:activos,codigo,{$this->selected_id}",
            'costo' => 'required|numeric',
            'fecha_registro' => 'required|date',
            'description' => 'required',
        ];
        $messages = [
            'codigo.unique' => 'EL CODIGO DEL ACTIVO YA FUE REGISTRADO',
            'codigo.required' => 'Debe ingresar el CODIGO DEL ACTIVO',
            'costo.required' => 'Debe ingresar el COSTO DE ADQUISICION DEL ACTIVO.',
            'costo.numeric' => 'Este campo debe ser de tipo Numero.',
            'fecha_registro.required' => 'Debe Ingresar la Fecha de ADQUISICION DEL ACTIVO.',
            'fecha_registro.date' => 'Este Campo debe ser de tipo FECHA.',
            'description.required' => 'Debe Ingresar la Descripcion completa del Activo.',
        ];
        $this->validate($rules, $messages);
        try {
            $activo = Activo::find($this->selected_id);
            $activo->update([
                'codigo' => $this->codigo,
                'costo' => $this->costo,
                'fecha_registro' => $this->fecha_registro,
                'description' => $this->description,
                'uniq_id' => $this->uniq_id,
                'user_id' => auth()->user()->id,
                'status' => 0
            ]);
            $this->emit('activo_register', 'Los Datos del Activo fueron actualizados correctamente.');
            $this->resetUI();
        } catch (Exception $e) {
            dd($e);
        }
    }
}
