<div>
<x-section-border />

<div class="mt-10 sm:mt-0">
    <x-form-section submit="save">
        <x-slot name="title">
            <div class="px-5">
                {{ __('Configurar um novo Alerta de Preço') }}
            </div>    
        </x-slot>

        <x-slot name="description">
            <div class="px-5">
                {{ __('Defina o símbolo da ação (Ex: PETR4.SA) e a faixa de preço (mínimo e máximo) para ser notificado. O sistema irá monitorar o preço 24/7.') }}
            
                {{-- Mensagem de sucesso (AGORA FUNCIONANDO CORRETAMENTE COM O DISPATCH) --}}
                @if (session()->has('success'))
                    <div x-data="{ show: true }" x-show="show" x-transition.leave.duration.1500ms 
                        class="mt-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                        {{ session('success') }}
                    </div>
                @endif
            </div>
        </x-slot>

        <x-slot name="form">
            <div class="col-span-6 sm:col-span-4">
                <x-label for="stock_symbol" value="{{ __('Símbolo da Ação') }}" />
                <x-input id="stock_symbol" wire:model.defer="stock_symbol" type="text" class="mt-1 block w-full" placeholder="Ex: GOOG, VALE3.SA" />
                <x-input-error for="stock_symbol" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-3">
                <x-label for="min_price" value="{{ __('Preço Mínimo (R$)') }}" />
                <x-input id="min_price" wire:model.defer="min_price" type="number" step="0.01" class="mt-1 block w-full" placeholder="0.01" />
                <x-input-error for="min_price" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-3">
                <x-label for="max_price" value="{{ __('Preço Máximo (R$)') }}" />
                <x-input id="max_price" wire:model.defer="max_price" type="number" step="0.01" class="mt-1 block w-full" placeholder="999.99" />
                <x-input-error for="max_price" class="mt-2" />
            </div>
            {{-- O erro de gt:min_price para max_price será exibido aqui --}}
        </x-slot>

        <x-slot name="actions">
            <x-button class="ml-4">
                {{ __('Salvar Alerta') }}
            </x-button>
        </x-slot>
    </x-form-section>
</div>
</div>