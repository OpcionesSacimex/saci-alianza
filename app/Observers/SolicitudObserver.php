<?php

namespace App\Observers;

use App\Models\Solicitude;
use App\Models\Cliente;

class SolicitudObserver
{
    /**
     * Handle the Solicitude "created" event.
     *
     * @param  \App\Models\Solicitude  $solicitude
     * @return void
     */
    public function created(Solicitude $solicitude)
    {
        $cliente = Cliente::find($solicitude->idcliente);
        $solicitude->convenio = $cliente->convenio;
        //$solicitude->fechainicio = date('Y-m-d');
        $solicitude->save();
    }

    /**
     * Handle the Solicitude "updated" event.
     *
     * @param  \App\Models\Solicitude  $solicitude
     * @return void
     */
    public function updated(Solicitude $solicitude)
    {
        $cliente = Cliente::find($solicitude->idcliente);
        $solicitude->convenio = $cliente->convenio;
        //$solicitude->fechainicio = date('Y-m-d');
        $solicitude->save();
    }

    /**
     * Handle the Solicitude "deleted" event.
     *
     * @param  \App\Models\Solicitude  $solicitude
     * @return void
     */
    public function deleted(Solicitude $solicitude)
    {
        //
    }

    /**
     * Handle the Solicitude "restored" event.
     *
     * @param  \App\Models\Solicitude  $solicitude
     * @return void
     */
    public function restored(Solicitude $solicitude)
    {
        //
    }

    /**
     * Handle the Solicitude "force deleted" event.
     *
     * @param  \App\Models\Solicitude  $solicitude
     * @return void
     */
    public function forceDeleted(Solicitude $solicitude)
    {
        //
    }
}
