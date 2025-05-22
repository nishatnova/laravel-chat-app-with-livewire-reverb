<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class Chat extends Component
{
    public $user;
    public $message;
    public $senderId;                 
    public $receiverId;                 

    public function mount($userId){
        $this->user = $this->getUsers($userId);
        $this->senderId = Auth::user()->id;
        $this->receiverId = $userId;
    }
    public function render()
    {
        return view('livewire.chat');
    }

    public function getUsers($userId){
       return User::find($userId);
    }

    public function sendMessage(){
        $this->saveMessage();
    }
    
    public function saveMessage(){
        dd([
        'sender_id' => $this->senderId,
        'receiver_id' =>$this->receiverId,
        'message' =>$this->message,
        // 'file_name',
        // 'file_original_name',
        // 'folder_path',
        'is_read' => false
        ]);
    }
}
