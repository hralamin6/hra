@if($singlePost)
@section('title', $singlePost->title)
@php
    $normalizedText = html_entity_decode(strip_tags($singlePost->body));
    @endphp
@section('description', $normalizedText)
@if($singlePost->getFirstMediaUrl('default', 'thumb'))
    @section('image', $singlePost->getFirstMediaUrl('default', 'thumb'))
        @endif
@section('url', config('app.url').'/nf?search='.$singlePost->id)
@endif
<div x-cloak class="xl:mx-32 xl:my-16 m-2" x-data="{openTable: $persist(true), modal: false, editMode: false,
addModal() { this.modal = true; this.editMode = false; $nextTick(() => $refs.input.focus()); },
editModal(id) { $wire.loadData(id); this.modal = true; this.editMode = true; $nextTick(() => $refs.input.focus()); },
closeModal() { this.modal = false; this.editMode = false; $wire.resetData()},
}"
         x-init="
     $wire.on('dataAdded', (e) => {
            modal = false; editMode = false;
            element = document.getElementById(e.dataId)
            console.log(element)
            element.scrollIntoView({behavior: 'smooth'})
            element.classList.add('bg-green-50')
            element.classList.add('dark:bg-gray-500')
            element.classList.add('animate-pulse')
            setTimeout(() => {
            element.classList.remove('bg-green-50')
            element.classList.remove('dark:bg-gray-500')
            element.classList.remove('animate-pulse')
            }, 5000)
            })
        "
         @open-delete-modal.window="
     model = event.detail.model
     eventName = event.detail.eventName
Swal.fire({
                title: event.detail.title,
                text: event.detail.text,
                icon: event.detail.icon,
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',

            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.emit(eventName, model )
                }
            })
"
    >
    <div x-cloak x-show="modal">
        <div class="fixed inset-0 z-10 flex items-end bg-black bg-opacity-50 sm:items-center sm:justify-center"></div>
        <div  class="inset-0 py-4 rounded-2xl transition duration-150 ease-in-out z-50 absolute" id="modal">
            <div @click.outside="closeModal" class="container mx-auto w-11/12 md:w-2/3 max-w-lg ">
                <form @submit.prevent="editMode? $wire.editData(): $wire.addPost()" class="relative py-3 px-5 md:px-10 bg-white dark:bg-darkSidebar shadow-md rounded border border-gray-400 dark:border-gray-600 capitalize">
                    <h1 x-cloak x-show="!editMode" class="text-gray-800 dark:text-gray-200 font-lg font-semibold text-center mb-4">@lang('add new data')</h1>
                    <h1 x-cloak x-show="editMode" class="text-gray-800 dark:text-gray-200 font-lg font-semibold text-center mb-4">@lang('edit this data')</h1>

                    <div class="grid grid-cols-1 gap-6 mt-4" >
                        <div>
                            <input x-ref="input" id="input" wire:model.lazy="title" type="text" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-200 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 focus:ring-blue-300 focus:ring-opacity-40 dark:focus:border-blue-300 focus:outline-none focus:ring">
                            @error('title')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <span wire:ignore>
                                <trix-editor class="formatted-content" x-data x-on:trix-change="$dispatch('input', event.target.value)" wire:model.debounce.1000ms="post_body" wire:key="post_body"></trix-editor>
                            </span>                            @error('post_body')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                    </div>
                    <div class="flex gap-2 justify-between items-center" x-data="{ isUploading: false, progress: 0 }" x-on:livewire-upload-start="isUploading = true" x-on:livewire-upload-finish="isUploading = false" x-on:livewire-upload-error="isUploading = false" x-on:livewire-upload-progress="progress = $event.detail.progress">
                        <label for="post_image" class=" font-medium text-gray-600 transition-colors duration-200 dark:text-gray-300 ">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 sm:w-6 sm:h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 16.5V9.75m0 0l3 3m-3-3l-3 3M6.75 19.5a4.5 4.5 0 01-1.41-8.775 5.25 5.25 0 0110.233-2.33 3 3 0 013.758 3.848A3.752 3.752 0 0118 19.5H6.75z" />
                            </svg>
                        </label>
                        <input type="file" id="post_image" wire:model.lazy="post_image" hidden>
                        <div class="w-12 flex" x-show="isUploading"> <span x-text="progress"></span> <progress max="100" x-bind:value="progress"></progress></div>
                        @error('post_image')<span class="text-sm text-red-600 dark:text-red-400">{{ $message }}</span>@enderror

                        <div>
                            <input wire:model.lazy="post_image_link" type="url" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-200 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 focus:ring-blue-300 focus:ring-opacity-40 dark:focus:border-blue-300 focus:outline-none focus:ring">
                            @error('post_image_link')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                    </div>
                    <div class="flex items-center justify-between w-full mt-4">
                        <button type="button" @click="closeModal" class="bg-red-600 focus:ring-gray-400 transition duration-150 text-white ease-in-out hover:bg-red-300 rounded px-8 py-2 text-sm">Cancel</button>
                        <button type="submit" class="focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-700 transition duration-150 ease-in-out hover:bg-indigo-600 bg-indigo-700 rounded text-white px-8 py-2 text-sm">Submit</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <div class="flex gap-2 justify-between">
        <span class="text-gray-700 font-bold text-2xl">Feed</span>
        <button @click.prevent="addModal" class="px-2 py-1 font-medium tracking-wide text-white capitalize transition-colors duration-300 transform bg-blue-600 rounded-lg hover:bg-blue-500 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-80">
            Add Post
        </button>
    </div>
    <div class="grid grid-cols-12 gap-8">
        <div class="md:col-span-7 col-span-12">
            @foreach($posts as $post)
                <div id="post-{{ $post->id }}" class="bg-white border shadow-sm w-full  mt-2" >
                    <div class="flex sm:flex-row bg-white rounded-md">
                        <div class="w-full" x-data="{trancate:true, comment:false}">
                            <!-- Post Header -->
                            <div class="p-2 flex items-center justify-between border-b">
                                <div class="flex items-center">
                                    <img src="" onerror="this.onerror=null;this.src='https://ui-avatars.com/api/?name={{$post->user->name}}';" alt="User Avatar" class="w-10 h-10 rounded-full mr-2">
                                    <div class="font-semibold text-sm">{{$post->user->name}}</div>
                                </div>
                                <div class="text-gray-500 text-sm">{{$post->created_at->diffForHumans()}}</div>
                                @if(auth()->id()==1 || auth()->id()==$post->user_id)
                                <button class="btn text-purple-400 cursor-pointer capitalize" @click.prevent="editModal({{$post->id}})">edit</button>
                                <button class="btn text-red-500 cursor-pointer capitalize" wire:click.prevent="deletePost({{$post}})">X</button>
                                @endif
                            </div>
                            @php
                              $b =  substr($post->body, 0, 200)
                            @endphp
                            <div  class="my-2 px-4 capitalize text-gray-700 text-sm">
                                <p x-show="trancate"  class="mt-2">{{html_entity_decode(strip_tags($b))}} @if(strlen($post->body)>=200) <span @click="trancate=false" @click.stop class="cursor-pointer text-blue-400"> see more</span> @endif</p>
                                <p x-show="!trancate"  class="mt-2">{{html_entity_decode(strip_tags($post->body))}}<span x-show="trancate===false" @click="trancate=true" @click.stop class="cursor-pointer text-blue-400"> see less</span></p>
                            </div>

                            <div class="">
                                @if($post->getFirstMediaUrl('default', 'thumb'))
                                    <img class="object-cover" src="{{$post->getFirstMediaUrl('default', 'thumb')}}" onerror="this.onerror=null;this.src='https://via.placeholder.com/600x300';">
                                @endif
                            </div>

                            <!-- Post Body -->

                            <!-- Post Footer -->
                            <div class="flex items-center justify-between gap-4 px-4 py-2">
                                <button class="flex items-center text-gray-500 gap-2">
                                    <x-h-m-heart class="h-6 text-pink-500"/>
                                    <span class="text-xs">{{rand(0, 100)}}</span>
                                </button>
                                <button @click="comment=!comment" class="flex items-center text-gray-500 gap-2">
                                    <x-h-o-chat-bubble-bottom-center-text class="h-6 text-gray-500"/>
                                    <span class="text-xs">{{$post->comments->count()}}</span>
                                </button>
                                <button class="flex items-center text-gray-500 gap-2">
                                    <x-h-o-eye class="h-6 text-gray-500"/>
                                    <span class="text-xs">{{rand(0, 100)}}</span>
                                </button>
                                <a href="https://www.facebook.com/sharer.php?u={{config('app.url').'/nf?searh='.$post->id}}&t={{$post->title}}" target="_blank" class="flex items-center text-gray-500 gap-2">
                                    <x-h-o-share class="h-6 text-gray-500"/>
                                </a>
                            </div>
                            <hr class="text-gray-500">
                            @foreach($post->comments as $comment)
                                <div id="{{$comment->id}}" x-show="comment" x-collapse class="flex items-start bg-white rounded-lg shadow-sm px-4 my-2" wire:key="{{$comment->id}}" :id="{{$comment->id}}">
                                    <img class="h-10 w-10 rounded-full mr-4" src="https://ui-avatars.com/api/?name={{$post->user->name}}" alt="">
                                    <div class="flex-grow">
                                        <div class="flex justify-between mb-2">
                                            <h3 class="text-sm font-medium text-gray-900">{{$comment->user->name}}</h3>
                                            <p class="text-xs text-gray-500">{{$comment->created_at->diffForHumans()}}</p>
                                            @if(auth()->id()==1 || auth()->id()==$comment->user_id)
                                                <button class="btn text-red-500 cursor-pointer capitalize" wire:click.prevent="deleteComment({{$comment}})">X</button>
                                            @endif

                                        </div>
                                        <p class="text-sm text-gray-800 leading-5 mb-2">{{$comment->body}}</p>
                                        @if($comment->getFirstMediaUrl('default', 'thumb'))
                                            <img class="object-cover" src="{{$comment->getFirstMediaUrl('default', 'thumb')}}">
                                        @endif
                                    </div>
                                </div>
                            @endforeach

                            <div x-show="comment" x-collapse class="flex gap-2 px-4 items-center" x-data="{ isUploading: false, progress: 0 }" x-on:livewire-upload-start="isUploading = true" x-on:livewire-upload-finish="isUploading = false" x-on:livewire-upload-error="isUploading = false" x-on:livewire-upload-progress="progress = $event.detail.progress">
                                <label for="image" class=" font-medium text-gray-600 transition-colors duration-200 dark:text-gray-300 ">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 sm:w-6 sm:h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 16.5V9.75m0 0l3 3m-3-3l-3 3M6.75 19.5a4.5 4.5 0 01-1.41-8.775 5.25 5.25 0 0110.233-2.33 3 3 0 013.758 3.848A3.752 3.752 0 0118 19.5H6.75z" />
                                    </svg>
                                </label>
                                <input type="file" id="image" wire:model.lazy="image" hidden>

{{--                                <div>--}}
{{--                                    <label class="text-gray-700 dark:text-gray-200" for="input">@lang('image link')</label>--}}
{{--                                    <input wire:model.lazy="image_link" type="url" class="input">--}}
{{--                                    @error('image_link')<p class="text-sm text-red-600">{{ $message }}</p>@enderror--}}
{{--                                </div>--}}
                                <div class="w-12 flex" x-show="isUploading"> <span x-text="progress"></span> <progress max="100" x-bind:value="progress"></progress></div>
                                @error('image')<span class="text-sm text-red-600 dark:text-red-400">{{ $message }}</span>@enderror
                                <div class="">
                                    <input type="text" wire:model.lazy="body" class="form-input w-full h-8 rounded-full border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                    @error('body')<span class="text-sm text-red-600 dark:text-red-400">{{ $message }}</span>@enderror

                                </div>
                                <button wire:click.prevent="addComment({{$post}})" class="px-2 py-1 text-sm capitalize font-medium tracking-wide text-white capitalize transition-colors duration-300 transform bg-blue-600 rounded-lg hover:bg-blue-500">
                                    send
                                </button>

                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

                <div class="mx-auto my-4 px-4">
                    {{--                    {{ $items->links('vendor.pagination.default') }}--}}
                    {{ $posts->links() }}
                </div>

             <div class="bg-white border-2 shadow-sm w-full h-48 mt-2">

            </div>
        </div>

        <div class="col-span-12 md:col-span-5">
            <div class="bg-white border-2 shadow-sm w-full  h-48 mt-2 "></div>
            <div class="bg-white border-2 shadow-sm w-full  h-48 mt-2 "></div>
        </div>
    </div>
</div>
