<div>
    {{-- Mensagem de Sucesso (após exclusão) --}}
    @if (session()->has('success'))
        <div x-data="{ show: true }" x-show="show" x-transition.leave.duration.1500ms 
             class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
            {{ session('success') }}
        </div>
    @endif
    
    <h3 class="text-xl font-semibold text-gray-800 leading-tight mb-4">
        Meus Alertas Ativos
    </h3>

    @if ($alerts->count())
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ação</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Preço Mínimo</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Preço Máximo</th>
                        <th class="px-6 py-3"></th> {{-- Coluna para ações --}}
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($alerts as $alert)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $alert->stock_symbol }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">R$ {{ number_format($alert->min_price, 2, ',', '.') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">R$ {{ number_format($alert->max_price, 2, ',', '.') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                {{-- Botão de Excluir --}}
                                <button wire:click="deleteAlert({{ $alert->id }})" 
                                        wire:confirm="Tem certeza que deseja excluir este alerta?"
                                        class="text-red-600 hover:text-red-900 ml-2">
                                    Excluir
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        {{-- Paginação --}}
        <div class="mt-4">
            {{ $alerts->links() }}
        </div>
        
    @else
        <p class="text-gray-500">Você ainda não possui alertas cadastrados.</p>
    @endif
</div>
