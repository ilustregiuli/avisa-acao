<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\MonitorAlertsJob;

/**
 * Comando de Console para verificar todos os alertas de ações.
 * Este comando é agendado no Kernel e despacha o Job que contém a lógica de monitoramento.
 */
class CheckAlerts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
   protected $signature = 'alerts:check';

    /**
     * A descrição do comando do console.
     * @var string
     */
    protected $description = 'Verifica todos os alertas de preco de acoes e despacha o Job de monitoramento.';

    /**
     * Executa o comando do console.
     */
    public function handle()
    {
        // 1. Despacha o MonitorAlertsJob para a fila.
        // O Job contém a lógica de buscar os alertas, simular o preço e logar o disparo.
        MonitorAlertsJob::dispatch();

        $this->info('MonitorAlertsJob despachado com sucesso para a fila.');
    }
}
