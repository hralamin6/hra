<?php

namespace App\Http\Livewire;

use App\Models\Product;
use App\Models\User;
use Livewire\Component;

class DashboardComponent extends Component
{
    public function render()
    {
        $users = User::all();
        $medicines = Product::where('status', 'active')->get();
        return view('livewire.dashboard-component', compact('users', 'medicines'));
    }
}
