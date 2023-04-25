<?php

namespace App\Http\Livewire;

use App\Events\MessageRead;
use App\Events\MessageSent;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use function Symfony\Component\Translation\t;

class ChatlistComponent extends Component
{
    public $selectedConversation;
    public $receiver;
    public $paginateVar = 10;
    public $height;
    public $body;
    public $createdMessage;
    use LivewireAlert;

    public function  getListeners()
    {

        $auth_id = auth()->id();
        return [
            "echo-private:chat.{$auth_id},MessageSent" => 'broadcastedMessageReceived',
//            "echo-private:chat.{$auth_id},MessageSent" => '$refresh',
            "echo-private:chat.{$auth_id},MessageRead" => 'broadcastedMessageRead',
            'loadConversation', 'pushMessage', 'loadmore', 'updateHeight','broadcastMessageRead','resetComponent'
        ];
    }
    public function resetComponent()
    {

        $this->selectedConversation= null;
        $this->receiverInstance= null;

        # code...
    }
    public function broadcastedMessageRead($event)
    {

        if($this->selectedConversation){

            if((int) $this->selectedConversation->id === (int) $event['conversation_id']){

                $this->dispatchBrowserEvent('markMessageAsRead');
            }
        }
    }
    function broadcastedMessageReceived($event)
    {
        if ($this->selectedConversation) {
            $this->messages = $this->data;
            $this->scrollBottom(true);
            Message::where('conversation_id',$this->selectedConversation->id)
                ->where('receiver_id',auth()->user()->id)->update(['read'=> 1]);
            broadcast(new MessageRead($this->selectedConversation->id, $this->getChatUserInstance($this->selectedConversation, $name = 'id')))->toOthers();
            $this->emit('browserMessage', ['messageBody'=>$event['message'],'userName' => User::find($event['sender_id'])->name, 'link'=> route('dashboard')]);
            $this->alert('success', __('New message from '.User::find($event['sender_id'])->name).' '.$event['message']);

        }

    }
    public function getChatUserInstance(Conversation $conversation, $request)
    {
        $this->auth_id = auth()->id();
        if ($conversation->sender_id == $this->auth_id) {
            $this->receiverInstance = User::firstWhere('id', $conversation->receiver_id);
        } elseif ($conversation->receiver_id == $this->auth_id) {
            $this->receiverInstance = User::firstWhere('id', $conversation->sender_id);
        }
        if (isset($request)) {
            return $this->receiverInstance->$request;
        }
    }
    function loadMore()
    {
        $this->paginateVar = $this->paginateVar + 5;
        $this->messages_count = Message::where('conversation_id', $this->selectedConversation->id)->count();

        $this->messages = Message::where('conversation_id',  $this->selectedConversation->id)
            ->skip($this->messages_count -  $this->paginateVar)
            ->take($this->paginateVar)->get();

        $height = $this->height;
        $this->dispatchBrowserEvent('updatedHeight', ($height));
        # code...
    }
    public function loadConversation(Conversation $conversation, User $receiver)
    {
        $this->selectedConversation =  $conversation;
        $this->receiver =  $receiver->id;
        $this->messages = $this->data;
        $unread_message = Message::where('conversation_id',$this->selectedConversation->id)
            ->where('receiver_id',auth()->user()->id)->where('read', 0)->first();
            Message::where('conversation_id',$this->selectedConversation->id)
            ->where('receiver_id',auth()->user()->id)->update(['read'=> 1]);
        broadcast(new MessageRead($this->selectedConversation->id, $this->receiver));

        $this->scrollBottom(false);
    }
    public function mount()
    {
        if ($this->conversations->count()>0){
            $this->selectedConversation =  Conversation::where('sender_id', auth()->id())
                ->orWhere('receiver_id', auth()->id())->orderBy('last_time_message', 'DESC')->first();
            $this->receiver =  $this->getChatUserInstance($this->selectedConversation, $name = 'id');
            $this->messages = $this->data;
            Message::where('conversation_id',$this->selectedConversation->id)
                ->where('receiver_id',auth()->user()->id)->update(['read'=> 1]);
            $this->scrollBottom(false);
        }

    }
    public function scrollBottom($isTrue)
    {
        if ($this->selectedConversation && $this->messages->first()){
            $this->emit('scrollBottom', ['message_id'=>$this->messages->last()->id, 'new_message'=>$isTrue]);
        }
    }
    public function sendMessage()
    {
        if ($this->body == null) {
            $this->alert('error', __('Message can not be empty'));
        }else{
            $this->createdMessage = Message::create([
                'conversation_id' => $this->selectedConversation->id,
                'sender_id' => auth()->id(),
                'receiver_id' => $this->receiver,
                'body' => $this->body,
            ]);
            $body = $this->body;
            $this->selectedConversation->last_time_message = $this->createdMessage->created_at;
            $this->selectedConversation->save();
            $this->messages = $this->data;
            $this->scrollBottom(true);
            $this->reset('body');
            broadcast(new MessageSent(auth()->id(), $this->selectedConversation->id, $this->receiver, $body))->toOthers();
        }

    }
    public function getDataProperty()
    {
        $message_count = Message::where('conversation_id',  $this->selectedConversation->id)->count();
        return Message::where('conversation_id',  $this->selectedConversation->id)->skip($message_count-$this->paginateVar)->take($this->paginateVar)->get();
    }
    public function getConversationsProperty()
    {
        return Conversation::where('sender_id', auth()->id())
            ->orWhere('receiver_id', auth()->id())->orderBy('last_time_message', 'DESC')->get();
    }
    public function render()
    {
        $conversations = $this->conversations;
        return view('livewire.chatlist-component', compact('conversations'));
    }
}
