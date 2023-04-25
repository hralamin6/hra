<div class="m-2" x-data="{
sending:'',
receivingId: {{auth()->id()}},
receiverId: {{$receiver}},
typing:false,
activated:false,
whisperTypingStart(){
     sending = Echo.private(`chat.${this.receiverId}`);
          if (this.activated===false){
                this.activated= true
     sending.whisper('typing', {
      typing: true
})
}
},
whisperTypingEnd(){
     sending = Echo.private(`chat.${this.receiverId}`);
     if (this.activated===true){
                this.activated= false
     sending.whisper('typing', {
      typing: false
      })
      }
}
}"
     x-init="
     whisperTypingEnd();
Echo.private(`chat.${receivingId}`)
    .listenForWhisper('typing', (e) => {
        typing = e.typing;
            setTimeout(() => { typing = false; }, 20000)
    });
         $wire.on('scrollBottom', (e) => {
            element = document.getElementById(e.message_id)
            element.scrollIntoView({behavior: 'smooth'})
            if(e.new_message){
            element.classList.add('bg-green-500')
            element.classList.add('animate-pulse')
            setTimeout(() => {
            element.classList.remove('bg-green-500')
            element.classList.remove('animate-pulse')
            }, 3000)
            }
            });
     $wire.on('browserMessage', (e) => {
            Push.create(e.userName), {
            body: e.messageBody,
            icon: 'https://unmeshbd.com/media/Images/Unmesh/logo.png',
            timeout: 10000,
            requireInteraction: true,
            vibrate: [200, 100],
            link: e.link,
            onClick: function () {

            window.location.href = e.link;
            window.focus();
            this.close();
            }
            }
     });
            ">
    <div class="grid grid-cols-1 md:grid-cols-3">
        <div class="col-span-3 lg:col-span-1 rounded-xl border border-gray-300 bg-white dark:bg-darkSidebar {{$selectedConversation?'hidden lg:block':''}}">
            <div class="h-16 border-b border-gray-300 flex justify-between gap-2 items-center capitalize px-2">
                <p class="text-2xl text-gray-700 font-medium">@lang('chat list')</p>
            </div>
            <div class="flex flex-col row-span-4">
                <div class="flex-1 overflow-y-auto px-4 py-8">
                    <ul class="">
                        @forelse($conversations as $conversation)
                        <li class="px-2 bg-gray-200 hover:bg-gray-300 rounded-xl my-2">
                                <button wire:click.prevent="loadConversation({{$conversation}}, '{{$this->getChatUserInstance($conversation, $name = 'id')}}')" type="button" class="flex items-center">
                                    <img class="rounded-full p-2" src="https://ui-avatars.com/api/?name={{$this->getChatUserInstance($conversation, $name = 'name')}}" alt="">
                                    <div class="w-full">
                                        <div class="flex justify-between w-full">
                                            <h2 class="text-lg font-medium text-gray-900 truncate"> {{ $this->getChatUserInstance($conversation, $name = 'name') }}</h2>
                                            @if(count($conversation->messages->where('read',0)->where('receiver_id',Auth()->user()->id)))
                                                <span class="flex w-6 items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white bg-red-500 rounded-full dark:bg-red-400">
                                             {{count($conversation->messages->where('read',0)->where('receiver_id',Auth()->user()->id))}}
                                                </span>
                                            @endif
                                        </div>
                                        <div class="flex justify-between w-full">
                                            <p class="text-sm text-gray-500  truncate w-32">{{ $conversation->messages->last()?->body }}</p>
                                            <p class="text-sm text-gray-600 truncate justify-items-end">{{ $conversation->messages->last()?->created_at->shortAbsoluteDiffForHumans() }} ago</p>
                                        </div>
                                    </div>

                                </button>
                            </li>
                        @empty
                            <p>No conversation found</p>
                        @endforelse
                    </ul>
                </div>
            </div>

        </div>
        @if ($selectedConversation)
            <div class="col-span-3 lg:col-span-2" x-data="{openChat: $persist(true)}">
                <aside class="rounded-xl border border-gray-300 bg-white dark:bg-darkSidebar">
                    <div class="h-16 border-b border-gray-300 flex justify-between gap-2 items-center capitalize px-6">
                        <button wire:click.prevent="resetComponent" class="text-gray-500 dark:text-gray-300">
                            <x-h-o-arrow-long-left class="h-6 w-6"/>
                        </button>
                        <div class="flex gap-2 items-center justify-start">
                                <img class="rounded-full p-2 h-16" src="https://ui-avatars.com/api/?name={{$this->getChatUserInstance($selectedConversation, $name = 'name')}}" alt="">
                                <h2 class="text-lg font-medium text-gray-900 truncate"> {{ $this->getChatUserInstance($selectedConversation, $name = 'name') }}</h2>
                        </div>
                        <div class="flex justify-center gap-4 text-gray-500 dark:text-gray-300">
                            <button class="" @click="openChat = !openChat">
                                <x-h-o-minus x-show="openChat"  class="h-6 w-6"/>
                                <x-h-o-x-mark x-show="!openChat" class="h-6 w-6"/>
                            </button>


                        </div>
                    </div>
                    <div x-show="openChat" x-collapse>

                            <div id="chatbox_body" class="mb-1 scroll-bottom h-96 overflow-y-scroll scrollbar-thin" x-data="{
                            tap() {
                    const element = document.getElementById('chatbox_body');
                        element.addEventListener('scroll', () => {
                        const top = element.scrollTop
                        if (top==0) {
                        element.scrollTop = element.scrollTop+320
                        this.$wire.loadMore()
                        }
                        })
                        }}" x-init="$nextTick(() => { tap() });">
                                @foreach ($messages as $message)
                                <div class="py-1 px-4">
                                    <div  class="flex {{ auth()->id() == $message->sender_id ? 'flex-row-reverse' : '' }} justify-start gap-3 items-center">
                                        <div id="{{$message->id}}" class="{{ auth()->id() == $message->sender_id ? 'dark:bg-gray-600 bg-gray-500' : 'dark:bg-blue-400 bg-blue-500' }} rounded-lg px-3 py-2 text-white">
                                            {{ $message->body }}
                                        </div>
                                        <div class="{{ auth()->id() == $message->sender_id ? 'flex-row-reverse' : '' }}">
                                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $message->created_at->format('m: i a') }}</p>
                                            @if($message->sender_id == auth()->id()&& $message->read == 1)
                                                <p class="text-xs text-green-500 dark:text-green-300 float-right"><x-h-o-eye class="h-4"/></p>
                                            @elseif($message->sender_id == auth()->id()&& $message->read == 0)
                                                <p class="text-xs text-red-500 dark:text-red-300 float-right"><x-h-o-eye-slash class="h-4"/></p>
                                            @endif
                                        </div>
                                    </div>

                                </div>
                                @endforeach
                            </div>
                        @endif
                            @if ($selectedConversation)
                                <div class="border dark:border-gray-600 p-2">
                                    <div x-cloak x-show="typing" class="flex items-center">
                                        <div class="w-2 h-3 bg-gray-400 dark:bg-gray-600 rounded-full mr-2 animate-pulse"></div>
                                        <div class="w-2 h-3 bg-gray-400 dark:bg-gray-600 rounded-full mr-2 animate-pulse"></div>
                                        <div class="w-2 h-3 bg-gray-400 dark:bg-gray-600 rounded-full animate-pulse"></div>
                                    </div>
                                    <form wire:submit.prevent="sendMessage" class="flex gap-2 justify-center mx-4">
                                        <input
                                            x-on:click.outside="whisperTypingEnd()" x-on:click="whisperTypingStart()"
                                            wire:model.lazy="body" class="border border-gray-300 rounded-l-md h-9 dark:bg-gray-600 dark:border-gray-500" type="text" name="message" id="message">
                                        <button type="submit" class="border border-gray-300 capitalize px-3 py-1 bg-blue-500 rounded-r-md text-white dark:border-gray-500">
                                          <span>@lang('send')</span>  <span wire:loading wire:target="sendMessage">...</span>
                                        </button>
                                    </form>
                                    @endif
                        </div>
                    </div>
                </aside>
            </div>
    </div>
</div>
