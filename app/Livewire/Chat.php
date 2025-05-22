<?php

namespace App\Livewire;

use App\Models\Message;
use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class Chat extends Component
{
    public $user;
    public $message;
    public $senderId;                 
    public $receiverId;                 
    public $messages;                 

    public function mount($userId){
        $this->user = $this->getUsers($userId);
        $this->senderId = Auth::user()->id;
        $this->receiverId = $userId;

        $this->messages = $this->getMessages();
    }
    public function render()
    {
        return view('livewire.chat');
    }

    public function getMessages(){
        Message::with('sender', 'receiver')
        ->where(function($query){
             $query->where('sender_id', $this->senderId)
            ->where('receiver_id', $this->receiverId);
        })

       ->orWhere(function($query){
        $query->where('sender_id', $this->receiverId)
        ->where('receiver_id', $this->senderId);
       })
        
        ->get();
    }

    public function getUsers($userId){
       return User::find($userId);
    }

    public function sendMessage(){
        $this->saveMessage();

        $this->message = null;
    }

    public function saveMessage(){
        return Message::create([
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
