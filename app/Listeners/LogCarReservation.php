<?php

namespace App\Listeners;

use App\Events\CarReservation;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class LogCarReservation
{
    use InteractsWithQueue;
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
     * @param  \App\Events\CarReservation  $event
     * @return void
     */
    public function handle(CarReservation $event)
    {
        Log::info("Carro reservado - Usuário ID: {$event->user_id}, Carro ID: {$event->vehicle_id}");
    }
}
