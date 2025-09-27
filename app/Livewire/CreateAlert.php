<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Alert;


class CreateAlert extends Component
{
    public $stock_symbol;
    public $min_price;
    public $max_price;

    protected $rules = [
        'stock_symbol' => 'required|string|min:2|max:10',
        'min_price' => 'required|numeric|min:0.01',
        'max_price' => 'required|numeric|gt:min_price',
    ];

    public function save()
    {
        $this->validate();

        auth()->user()->alerts()->create([
            'stock_symbol' => $this->stock_symbol,
            'min_price' => $this->min_price,
            'max_price' => $this->max_price,
        ]);

        $this->reset();

        session()->flash('success', 'Alerta criado com sucesso!');
    }

    public function render()
    {
        return view('livewire.create-alert');
    }
}
