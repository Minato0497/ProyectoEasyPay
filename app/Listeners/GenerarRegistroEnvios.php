<?php

namespace App\Listeners;

use App\Events\Envios;
use App\Models\Movement;
use App\Models\RecordMoneyTransfer;
use Carbon\Carbon;
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
        // dd($event);
        $save_record_transfers = Movement::create([
            'date_movement' => Carbon::now(),
            'codOperationType' => $event->datos_envios['codOperationType'],
            'codEmisor' => $event->datos_envios['codEmisor'],
            'codReceptor' => $event->datos_envios['codReceptor'],
            'amount' => $event->datos_envios['amount'],
            'success' => $event->datos_envios['success'] ?? 0
        ]);
        return $save_record_transfers;
    }
}
