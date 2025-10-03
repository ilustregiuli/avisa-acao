<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination; // Importe o trait para paginação
use App\Models\Alert;

class ListAlerts extends Component
{
    // Use o trait para habilitar a paginação no componente
    use WithPagination; 

    // Define o tema da paginação para usar o Tailwind CSS
    protected $paginationTheme = 'tailwind'; 

     // PROPRIEDADE PARA ESCUTAR O EVENTO
    protected $listeners = ['alert-saved' => '$refresh']; 
    // Quando o evento 'alert-saved' for recebido, execute o método mágico '$refresh'

    /**
     * Remove um alerta do banco de dados.
     * @param int $alertId
     */
    public function deleteAlert($alertId)
    {
        // 1. Encontra o alerta pelo ID
        $alert = Alert::find($alertId);

        // 2. Garante que o alerta existe e que pertence ao usuário logado
        if ($alert && $alert->user_id === auth()->id()) {
            $alert->delete();
            
            // Dispara uma mensagem de sucesso para a tela
            session()->flash('success', 'Alerta excluído com sucesso.');
        }
    }

    public function render()
    {
        // Busca APENAS os alertas do usuário logado, com 10 por página
        $alerts = auth()->user()
            ->alerts()
            ->latest() // Os mais recentes primeiro
            ->paginate(10); 

        return view('livewire.list-alerts', [
            'alerts' => $alerts,
        ]);
    }
}
