<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Jobs\MonitorAlertsJob;
use App\Models\Alert;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;

class MonitorAlertsJobTest extends TestCase
{
    // Limpa o banco de dados de teste antes de cada método
    use RefreshDatabase; 

    /** @test */
    public function it_logs_alert_when_price_is_in_range()
    {
        // 1. ARRANGE (Configuração)
        $user = User::factory()->create();
        
        // Configura um alerta onde o range é de 49.00 a 51.00
        $user->alerts()->create([
            'stock_symbol' => 'IN_RANGE',
            'min_price' => 49.00,
            'max_price' => 51.00,
        ]);

        // 2. MOCK (Simulação)
        // Cenário 1: Esperamos que o preço caia no range e chame o Log::alert()
        Log::shouldReceive('alert')->once(); 
        
        // CORREÇÃO: Não esperamos que o Log::info() seja chamado neste cenário
        Log::shouldReceive('info')->times(0);

        // 3. ACT (Execução)
        MonitorAlertsJob::dispatch();

        // 4. ASSERT (Verificação)
        // As verificações são feitas pelo Mock (once() e times(0))
        $this->assertTrue(true); 
    }

    /** @test */
    public function it_does_not_log_alert_when_price_is_out_of_range()
    {
        // 1. ARRANGE (Configuração)
        $user = User::factory()->create();
        
        // Configura um alerta onde o range é de 49.00 a 51.00
        $user->alerts()->create([
            'stock_symbol' => 'OUT_RANGE',
            'min_price' => 49.00,
            'max_price' => 51.00,
        ]);

        // 2. MOCK (Simulação)
        // Cenário 2: Esperamos que o preço caia fora do range e não chame o Log::alert()
        Log::shouldReceive('alert')->never(); 
        
        // CORREÇÃO: Esperamos que o Log::info() seja chamado neste cenário (dentro do 'else')
        Log::shouldReceive('info')->once(); 
        
        // 3. ACT (Execução)
        MonitorAlertsJob::dispatch();

        // 4. ASSERT (Verificação)
        // As verificações são feitas pelo Mock (never() e once())
        $this->assertTrue(true); 
    }
}
