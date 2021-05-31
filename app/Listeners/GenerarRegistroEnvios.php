<?php

namespace App\Listeners;

use App\Events\Envios;
use App\Models\RecordMoneyTransfer;
use Illuminate\Support\Facades\DB;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class GenerarRegistroEnvios
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Envios  $event
     * @return void
     */
    public function handle(Envios $event)
    {
        //dd($event);
        $save_record_transfers=RecordMoneyTransfer::create([
            'email_envia'=>$event->datos_envios[0],
            'email_recibe'=>$event->datos_envios[1],
            'monto'=>$event->datos_envios[2],
            'envia_id'=>$event->datos_envios[3],
            ]);
        return $save_record_transfers;
    }
}
