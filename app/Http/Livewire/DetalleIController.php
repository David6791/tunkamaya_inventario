<?php

namespace App\Http\Livewire;

use App\Models\Institucion;
use App\Models\Grupo;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;


class DetalleIController extends Component
{
    public $p, $inputs = [], $contenido = '', $preview, $descripcion_codigo = [], $selected_id, $form = false, $modalTitle, $user_id;
    protected $paginationTheme = 'bootstrap';
    public function mount($p)
    {
        $this->p = $p;
    }

    public function render()
    {

        $users_no_asig = DB::select('SELECT users_no_asig(:id)', ['id' => $this->p]);
        $users_list_no_asig = json_decode($users_no_asig[0]->users_no_asig);

        $detalle = DB::select('SELECT obtener_detalles_institucion(:id)', ['id' => $this->p]);
        $json = json_decode($detalle[0]->obtener_detalles_institucion);

        $asignados = DB::select('SELECT obtener_asignados_institucion(:id)', ['id' => $this->p]);
        $json_asignados = json_decode($asignados[0]->obtener_asignados_institucion);

        if ($json_asignados === NULL) {
            $json_asignados = [];
        }
        return view('livewire.instituciones.detalles', [
            'data' => $json,
            'asignados' => $json_asignados,
            'users_no_asig' => $users_list_no_asig
        ])->layout('layouts.app');
    }
    public function addInput($dat)
    {
        $partes = explode("_", $dat);
        $this->selected_id = $partes[0];
        if ($partes[1] === 'in') {
            $cod = Institucion::where('id', $partes[0])->first();
            $this->inputs[] = $cod->codigo_id;
            $this->preview = $this->preview . $cod->codigo_id;
            array_push($this->descripcion_codigo, "cod_institucion");
        } elseif ($partes[1] === 'gc') {
            $cod = Grupo::where('institucion_id', $partes[0])->first();
            $this->inputs[] = $cod->codigo;
            $this->preview = $this->preview . $cod->codigo;
            array_push($this->descripcion_codigo, "cod_grupo");
        } elseif ($partes[1] === 'ta') {
            $cod = Grupo::join('tipos as t', 't.grupo_id', 'grupos.id')->where('grupos.institucion_id', $partes[0])->first();
            $this->inputs[] = $cod->codigo;
            $this->preview = $this->preview . $cod->codigo;
            array_push($this->descripcion_codigo, "cod_tipo");
        } elseif ($partes[1] === 'a') {
            $this->inputs[] = '';
            array_push($this->descripcion_codigo, "editable");
        }
    }
    public function deleteInputs()
    {
        $this->inputs = [];
        $this->preview = '';
        $this->descripcion_codigo = [];
    }
    public function actualizarCodigo($id)
    {
        $this->preview = $this->preview . $id;
    }
    public function saveCodigoTipe()
    {
        try {
            $institucion = Institucion::find($this->selected_id);
            $institucion->update([
                'detalle_codificacion' => $this->descripcion_codigo,
                'ejemplo_codificacion' => $this->inputs,
            ]);
            $this->emit('updated', 'Los Datos para la Codificacion fueron registrados Correctamente.');
            $this->resetUI();
        } catch (Exception $e) {
            dd($e);
        }
    }
    public function editFormatCod(Institucion $institucion)
    {
        $this->selected_id = $institucion->id;
        $this->form = true;
        $this->descripcion_codigo = json_decode($institucion->detalle_codificacion);
        $this->inputs = json_decode($institucion->ejemplo_codificacion);
        foreach ($this->inputs as $i) {
            $this->preview = $this->preview . $i;
        }
    }
    public function resetUI()
    {
        $this->resetValidation();
        $this->form  = false;
        $this->inputs = [];
        $this->preview = '';
        $this->descripcion_codigo = [];
    }
    public function updateCodigoTipe()
    {
        try {
            $institucion = Institucion::find($this->selected_id);
            $institucion->update([
                'detalle_codificacion' => $this->descripcion_codigo,
                'ejemplo_codificacion' => $this->inputs,
            ]);
            $this->emit('updated', 'Los Datos para la Codificacion fueron registrados Correctamente.');
            $this->resetUI();
        } catch (Exception $e) {
            dd($e);
        }
    }
    public function asigUsuarios(Institucion $institucion)
    {
        /*$this->users_no_asig = DB::table('users')
            ->whereNotIn('id', function ($query) {
                $query->select('usuario_asignado_id')
                    ->from('rinsus')
                    ->where('institucion_id', 2);
            })
            ->where('status', 'ACTIVO')
            ->get();*/
        //dd($this->users_no_asig);        
        $this->modalTitle = 'Registrar nueva Asignacion';
        $this->emit('asigUsuarios', 'open');
    }
    public function select_option($id)
    {
        $this->user_id = $id;
    }
    public function Save()
    {
        try {

            DB::table('rinsus')->insert([
                'user_id' => auth()->user()->id,
                'usuario_asignado_id' => $this->user_id,
                'institucion_id' => $this->p,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $this->emit('updated', 'Los Datos para la Codificacion fueron registrados Correctamente.');
            $this->resetUI();
        } catch (Exception $e) {
            dd($e);
        }
    }
    protected $listeners = [
        'Delete' => 'Delete',
        'resetUI' => 'resetUI'
    ];
    public function Delete($id)
    {
        dd('Revisar la parte de Bloques para poder eliminar');
        $c = DB::select('SELECT revisar_trabajo(:ida, :idi)', ['ida' => $id, 'idi' => $this->p]);
        dd($c);
    }
}
