<?php

namespace App\Jobs;

use App\Models\Alert; 
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class MonitorAlertsJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $alerts = Alert::all();
        foreach ($alerts as $alert) {

            // A simulação de preço rand() é feita diretamente aqui.
            // $currentPrice = rand(10, 1000) / 10;
            $currentPrice = 50.00;

            $minPrice = $alert->min_price;
            $maxPrice = $alert->max_price;
            
            // Disparar SE estiver DENTRO do range
            if ($currentPrice >= $minPrice && $currentPrice <= $maxPrice) {
                Log::alert(
                    "🔴 ALERTA DISPARADO: Símbolo: {$alert->stock_symbol}. ".
                    "Preço Atual: R$ {$currentPrice}. ".
                    "RANGE: R$ {$minPrice} a R$ {$maxPrice}."
                );
            } else {
                // Log de monitoramento (Prioridade normal)
                Log::info(
                        "🟢 Monitoramento OK: Símbolo: {$alert->stock_symbol}. ".
                        "Preço Atual: R$ {$currentPrice}. ".
                        "RANGE: R$ {$minPrice} a R$ {$maxPrice}."
                );
            }
        }
    }
}
