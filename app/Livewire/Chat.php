<?php

namespace App\Livewire;

use App\Events\MessageSentEvent;
use App\Events\UserTyping;
use App\Models\Message;
use Livewire\Component;
use App\Models\User;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;

class Chat extends Component
{
    public $user;
    public $message;
    public $senderId;                 
    public $receiverId;                 
    public $messages;                 

    public function mount($userId){
        $this->dispatch('messages-updated');
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
        return Message::with('sender:id,name', 'receiver:id,name')
        ->where(function($query){
             $query->where('sender_id', $this->senderId)
            ->where('receiver_id', $this->receiverId);
        })

       ->orWhere(function($query){
        $query->where('sender_id', $this->receiverId)
        ->where('receiver_id', $this->senderId);
       })->get();
    }

    public function userTyping(){
        broadcast(new UserTyping($this->senderId, $this->receiverId))->toOthers();
    }

    public function getUsers($userId){
       return User::find($userId);
    }

    public function sendMessage(){
        $sentMessage = $this->saveMessage();

        $this->messages[] = $sentMessage;

        broadcast(new MessageSentEvent($sentMessage));
        $this->message = null;

        $this->dispatch('messages-updated');
    }

    
    #[On('echo-private:chat-channel.{senderId},MessageSentEvent')]
    public function listenMessage($event)
    {
        # Convert the event message array into an Eloquent model with relationships
        $newMessage = Message::find($event['message']['id'])->load('sender:id,name', 'receiver:id,name');

        $this->messages[] = $newMessage;
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
