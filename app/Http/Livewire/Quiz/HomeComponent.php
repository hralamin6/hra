<?php

namespace App\Http\Livewire\Quiz;

use Livewire\Component;

class HomeComponent extends Component
{
    public function render()
    {
        return view('livewire.quiz.home-component')->layout('layouts.quiz');
    }
}
