<?php

namespace App\Livewire;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layout.student_dashboard')]
class StudentDashboard extends Component
{
    public function render()
    {
        return view('livewire.student-dashboard');
    }
}
