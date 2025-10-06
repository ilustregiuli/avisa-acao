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
        // LOG INICIAL: Confirma que o Job começou (sempre aparece, mesmo vazio)
        Log::info('🔵 MonitorAlertsJob INICIADO: Verificando alertas...');

        $alerts = Alert::all();  // Pega todos (pode ser vazio)
        // LOG PARA BANCO VAZIO: Trata o caso sem dados
        if ($alerts->isEmpty()) {
              Log::info('🟡 MonitorAlertsJob: NENHUMA ALERTA ENCONTRADA no banco. Nada a processar.');
              Log::info('🔵 MonitorAlertsJob FINALIZADO: Execução OK (sem dados).');
              return;  // Sai cedo, sem erro
          }

        // LOG ANTES DO LOOP: Confirma que há dados
        Log::info('🟢 MonitorAlertsJob: Encontrados ' . $alerts->count() . ' alertas para processar.');
  
        foreach ($alerts as $alert) {

            // A simulação de preço rand() é feita diretamente aqui.
            // $currentPrice = rand(10, 1000) / 10;
            $currentPrice = 50.00;

            $minPrice = $alert->min_price;
            $maxPrice = $alert->max_price;
            
            // LOGS DENTRO DO LOOP: Para cada alerta
            Log::info("📊 Processando alerta para {$alert->stock_symbol}: Mín R$ {$minPrice}, Máx R$ {$maxPrice}");
              
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

        // LOG FINAL: Sempre aparece se chegou aqui
        Log::info('🔵 MonitorAlertsJob FINALIZADO: Todos os alertas processados com sucesso.');

    }
}
