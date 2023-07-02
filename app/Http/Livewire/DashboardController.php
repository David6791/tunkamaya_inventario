<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Session;
use App\Models\Institucion;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\View\View;

class DashboardController extends Component
{
    public $instituciones = [], $modalTitle, $selected_id, $nueva_institucion;
    public function mount()
    {
        $this->modalTitle = 'Seleccione una Institucion:';
    }
    public function render()
    {
        $primer_desig = DB::table('rinsus')->where('usuario_asignado_id', '=', auth()->user()->id)->first();
        if ($primer_desig === null) {
            return view('errors.no_asignaciones')->layout('layouts.app2');
        }
        if (session()->has('institucion')) {
            $this->instituciones = DB::table('rinsus')->join('institucion as i', 'i.id', 'rinsus.institucion_id')->select('i.*')->where('rinsus.usuario_asignado_id', '=', auth()->user()->id)->where('rinsus.institucion_id', '<>', session('institucion'))->get();
        } else {
            $nombre = Institucion::find($primer_desig->institucion_id);
            $this->instituciones = DB::table('rinsus')->join('institucion as i', 'i.id', 'rinsus.institucion_id')->select('i.*')->where('rinsus.usuario_asignado_id', '=', auth()->user()->id)->where('rinsus.institucion_id', '<>', $primer_desig->institucion_id)->get();
            Session::put('institucion', $primer_desig->institucion_id);
            Session::put('nombre_institucion', $nombre->nombre);
        }

        return view('livewire.dashboard.dash');
    }
    public function cambiar_institucion($id)
    {
        $this->emit('open', 'cambio_institucion');
    }
    protected $listeners = ['CmabioInstitucion' => 'CmabioInstitucion'];
    public function CmabioInstitucion($id)
    {
        $nombre = Institucion::find($this->nueva_institucion);
        Session()->put('institucion', $this->nueva_institucion);
        Session()->put('nombre_institucion', $nombre->nombre);
        return redirect()->route('dash');
    }
    public function resetUI()
    {
        $this->resetValidation();
        $this->nueva_institucion  = '';
    }
}
