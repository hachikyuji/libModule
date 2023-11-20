<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layout.app')]
class Users extends Component
{
    public function render()
    {
        return view('livewire.users');
    }
}
