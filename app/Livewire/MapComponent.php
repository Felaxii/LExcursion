<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Destination;

class MapComponent extends Component
{
    public $country;
    public $destinations = [];

    public function mount()
    {
        $this->country = '';
    }

    public function updatedCountry($value)
    {
        // When the country input changes, fetch matching destinations.
        $this->destinations = Destination::where('country', $value)
            ->with('flights')
            ->get()
            ->toArray();
    }

    public function render()
    {
        return view('livewire.map-component');
    }
}
