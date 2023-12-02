<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Receiver;
use App\Models\ReceiverUnit;

class Dropdown extends Component
{
    public $receiverUnits;
    public $receivers;
    public $receiverUnit = null;
    public $receiver = null;

    public function mount()
    {
        $this->receiverUnits = ReceiverUnit::all();
        $this->receivers = collect();
    }

    public function render()
    {
        return view('livewire.dropdown');
    }

    public function updatedReceiverUnit($value)
    {
        $this->receivers = Receiver::where('receiverUnit_id', $value)->get();
    }
}
