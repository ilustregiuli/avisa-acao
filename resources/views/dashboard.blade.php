<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard de Alertas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                
                {{-- O seu componente Livewire deve ser incluído aqui --}}
                <livewire:create-alert />

                {{-- NOVO: Separador e Listagem --}}
                <x-section-border /> 

                <div class="p-6 sm:px-20 bg-white">
                    <livewire:list-alerts />
                
            </div>
        </div>
    </div>
</x-app-layout>