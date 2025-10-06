<?php

    namespace App\Console;

     use Illuminate\Support\Facades\Log;
     use Illuminate\Console\Scheduling\Schedule;
     use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

     class Kernel extends ConsoleKernel
    {
         /**
          * Define the application's command schedule.
          */
         protected function schedule(Schedule $schedule): void
         {
             // TEMPORARIAMENTE para teste rápido.
             // O comando 'alerts:check' será executado a cada 1 minuto.
             echo 'DEBUG: schedule() método INICIADO - Kernel carregado!' . PHP_EOL;
             Log::info('DEBUG: schedule() método INICIADO - Kernel carregado!');
             
             Log::info('DEBUG: Schedule carregado: agendando alerts:check');
             echo 'DEBUG: Agendando alerts:check...' . PHP_EOL;
             
             $schedule->command('alerts:check')->everyMinute()->withoutOverlapping();
             
             Log::info('DEBUG: schedule() método FINALIZADO - Agendamento definido!');
             echo 'DEBUG: schedule() método FINALIZADO - Agendamento definido!' . PHP_EOL;
         }
         /**
          * Register the commands for the application.
          */
         protected function commands(): void
                  {
             $this->load(__DIR__.'/Commands');
             require base_path('routes/console.php');
         }
    }