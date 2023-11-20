<?php

namespace App\Livewire;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layout.admin_dashboard')]
class AdminDashboard extends Component
{
    public function render()
    {
        return view('livewire.admin-dashboard');
    }
}
