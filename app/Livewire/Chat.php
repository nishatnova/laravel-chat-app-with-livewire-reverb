<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;

class Chat extends Component
{
    public $user;

    public function mount($userId){
        $this->user = $this->getUsers($userId);
    }
    public function render()
    {
        return view('livewire.chat');
    }

    public function getUsers($userId){
       return User::find($userId);
    }
}
