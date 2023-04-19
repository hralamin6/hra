<div class=" rounded-xl mt-4" x-data="{openTable: $persist(true), modal: false, editMode: false, viewProduct:false,
addModal() { this.modal = true; this.editMode = false; },
viewData(id) { $wire.viewProduct(id); this.viewProduct = true;  },
editModal(id) { $wire.loadData(id); this.modal = true; this.editMode = true;},
closeModal() { this.modal = false; this.viewProduct = false; this.editMode = false; $wire.resetData()},
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
        <div  class="inset-0 py-4 rounded-xl transition duration-150 ease-in-out z-50 absolute" id="modal">
            <div @click.outside="closeModal" class="container mx-auto ">
                <form @submit.prevent="editMode? $wire.editData(): $wire.saveData()" class="relative py-3 px-5 md:px-10 bg-white dark:bg-darkSidebar shadow-md rounded border border-gray-400 dark:border-gray-600 capitalize">
                    <h1 x-cloak x-show="!editMode" class="text-gray-800 dark:text-gray-200 font-lg font-semibold text-center mb-4">@lang('add new data')</h1>
                    <h1 x-cloak x-show="editMode" class="text-gray-800 dark:text-gray-200 font-lg font-semibold text-center mb-4">@lang('edit this data')</h1>

                    <aside class="border dark:border-gray-600 row-span-4 mt-4 px-1 pb-6 rounded shadow bg-white dark:bg-darkSidebar" x-data="">
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-2 mt-4 lg:grid-cols-6 justify-self-end">
                            <div class="flex gap-2 text-sm">
                                <span class="pt-4">purchase no: #{{$purchase_no}}</span>
                                <x-input wire:model="date" type="date" class="bg-purple-100"/>
                                @error('date')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>
                            <div x-show="!editMode">
                                <x-select wire:model="category_id" >
                                    <option value="">select category</option>

                                    @foreach($categories as $category)
                                        <option value="{{$category->id}}">{{$category->name}}</option>
                                    @endforeach
                                </x-select>
                            </div>
                            <div x-show="!editMode">
                                <x-select wire:model="brand_id" >
                                    <option value="">select brand</option>
                                    @foreach($brands as $brand)
                                        <option value="{{$brand->id}}">{{$brand->name}}</option>
                                    @endforeach
                                </x-select>
                            </div>
                            <div x-show="!editMode">
                                <x-select wire:model="group_id" >
                                    <option value="">select group</option>
                                    @foreach($groups as $group)
                                        <option value="{{$group->id}}">{{$group->name}}</option>
                                    @endforeach
                                </x-select>
                            </div>
                            {{--                            <div x-show="!editMode" class="flex gap-2">--}}
                            {{--                                @if($products!=null)--}}
                            {{--                                    <x-input wire:model="product_search" class="bg-indigo-100" type="search"/>--}}
                            {{--                                    <x-select wire:model="product_id" class="appearance-none">--}}
                            {{--                                        <option value="">select product</option>--}}
                            {{--                                        @foreach($products as $product)--}}

                            {{--                                            <option value="{{$product->id}}">{{$product->name}}</option>--}}
                            {{--                                        @endforeach--}}
                            {{--                                    </x-select>--}}
                            {{--                                @endif--}}
                            {{--                                @error('product_id')<p class="text-sm text-red-600">{{ $message }}</p>@enderror--}}
                            {{--                            </div>--}}
                            <div x-show="!editMode" x-data="{ option: false }" class="relative">
                                <x-input type="text" @click="option=true" wire:model.debounce.1000ms="product_search" @click.away="option = false" @keydown.escape="option = false" />
                                <div class="absolute mt-1 w-full rounded-md bg-white shadow-lg z-50" x-show="option" x-on:click.away="option = false">
                                    <div class="py-1 overflow-y-scroll w-48">
                                        @foreach($products as $product)
                                            <div wire:click.prevent="setProductValue({{$product->id}}, '{{$product->name}}')" class="px-6 py-2 hover:bg-gray-100 cursor-pointer">{{ $product->name }}</div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div>
                                <button x-show="!editMode" wire:click="add" class="flex justify-end gap-1 mt-2 text-white capitalize hover:bg-blue-700 p-2 font-semibold text-sm bg-blue-500 rounded">
                                    <x-h-o-plus-circle class="w-5"/>
                                </button>
                            </div>

                        </div>
                        <div class="w-full overflow-x-auto mt-4">
                            <table class="w-full min-w-fit">
                                <thead>
                                <tr
                                    class="text-xs font-semibold text-gray-500 border-b dark:border-gray-700 bg-gray-50 dark:text-gray-300 dark:bg-darkSidebar"
                                >
                                    <x-field :OB="$orderBy" :OD="$orderDirection" :field="'selling_unit_id'">@lang('product')</x-field>
                                    <x-field :OB="$orderBy" :OD="$orderDirection" :field="'unit_relation'">@lang('quantity')</x-field>
                                    <x-field :OB="$orderBy" :OD="$orderDirection" :field="'status'">@lang('price')</x-field>
                                    <x-field :OB="$orderBy" :OD="$orderDirection" :field="'created_at'">@lang('total')</x-field>
                                    <x-field :OB="$orderBy" :OD="$orderDirection" :field="'action'">@lang('action')</x-field>
                                </tr>
                                </thead>
                                <tbody
                                    class="bg-white divide-y capitalize dark:divide-gray-700 dark:bg-darkSidebar"
                                >

                                @foreach($inputs as $key=> $input)

                                    <tr id="item-id-{{$key}}" class="text-gray-700 dark:text-gray-300 capitalize">
                                        @php
                                            if(is_numeric($inputs[$key]['unit_price']) && is_numeric($inputs[$key]['quantity'])){
                                            $full = $inputs[$key]['unit_price']*$inputs[$key]['quantity'];
                                            }else{
                                            $full = 0;
                                            }
                                        @endphp
                                        <td class="p-1">
                                            {{\App\Models\Product::find($inputs[$key]['product_id'])->name}}
                                        </td>
                                        <td class="p-1">
                                            <x-input  wire:model.lazy="inputs.{{ $key }}.quantity" class="h-8" />
                                            @error('inputs.'.$key.'.quantity')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
                                        </td>
                                        <td class="p-1">
                                            <x-input wire:model.lazy="inputs.{{ $key }}.unit_price" class="h-8" />
                                            @error('inputs.'.$key.'.unit_price')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
                                        </td>
                                        <td class="p-1">
                                            <x-input readonly value="{{$full}}" class="bg-blue-100 h-8"/>
                                        </td>
                                        <td class="p-1">
                                            <button x-show="!editMode" wire:click="remove({{$key}})" class="flex gap-1 text-white capitalize hover:bg-red-700 p-2 font-semibold text-sm bg-red-500 rounded">
                                                <x-h-o-minus class="w-5"/></button>
                                        </td>

                                    </tr>
                                @endforeach
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td class="text-gray-500 dark:text-gray-300 font-semibold text-xs">total:</td>
                                    <td class="p-1 ">
                                        <x-input readonly value="{{$total}}" class="bg-green-100 h-8"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td class="text-gray-500 dark:text-gray-300 font-semibold text-xs">discount:</td>
                                    <td class="p-1 ">
                                        <x-input wire:model.lazy="discount" class="bg-red-100 h-8" type="text"/>
                                        @error('discount')<p class="text-sm text-red-600">{{ $message }}</p>@enderror

                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td class="text-gray-500 dark:text-gray-300 font-semibold text-xs">grand total:</td>
                                    <td class="p-1 ">
                                        <x-input readonly value="{{$grand_total}}" class="bg-green-200 h-8"/>
                                    </td>
                                </tr>

                                </tbody>
                            </table>
                        </div>
                        <div x-show="!editMode" class="grid grid-cols-2 capitalize gap-4 mt-4 lg:grid-cols-4">
                            <div>
                                <label class="text-gray-700 dark:text-gray-200" for="supplier_id">@lang('supplier')</label>
                                <x-select id="supplier_id" wire:model.lazy="supplier_id" class="w-72">
                                    <option value="">@lang('select supplier')</option>
                                    @foreach($suppliers as $supplier)
                                        <option value="{{$supplier->id}}">{{$supplier->name}}</option>
                                    @endforeach
                                </x-select>
                                @error('supplier_id')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="text-gray-700 dark:text-gray-200" for="input">@lang('note')</label>
                                <x-input x-ref="input" id="input" wire:model.lazy="note" type="text" />
                                @error('note')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="text-gray-700 dark:text-gray-200" for="paid_amount">@lang('paid amount')</label>
                                <x-input wire:model.debounce="paid_amount" type="text"/>
                                @error('paid_amount')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>
                            {{--                            <div>--}}
                            {{--                                <button wire:click.prevent="saveData" class="flex gap-1 mt-8 text-white capitalize hover:bg-blue-700 p-2 font-semibold text-sm bg-blue-500 rounded">--}}
                            {{--                                    <x-h-s-rectangle-group class="w-5"/>--}}
                            {{--                                    @lang('submit')</button>--}}
                            {{--                            </div>--}}
                        </div>
                    </aside>

                    <div class="flex items-center justify-between w-full mt-4">
                        <button type="button" @click="closeModal" class="bg-red-600 focus:ring-gray-400 transition duration-150 text-white ease-in-out hover:bg-red-300 rounded px-8 py-2 text-sm">Cancel</button>
                        <button type="submit" class="focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-700 transition duration-150 ease-in-out hover:bg-indigo-600 bg-indigo-700 rounded text-white px-8 py-2 text-sm">Submit</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    @include('livewire.view-purchase-details')

    <div class="flex gap-2 my-2 justify-between">
        <div class="w-24">
            <x-input wire:model.debounce.1000ms="itemPerPage" type="text" />
        </div>
        <div class="flex">
            <x-input placeholder="search" wire:model.debounce="search" type="search"/>
            <x-select wire:model="searchBy" >
                @foreach(\Illuminate\Support\Facades\Schema::getColumnListing('purchases') as $i=> $col)
                    @if($col!='created_at' && $col!='updated_at')
                        <option value="{{$col}}">{{$col}}</option>
                    @endif
                @endforeach
            </x-select>
        </div>
        <div x-show="!editMode" x-data="{ option: false }" class="relative">
            <x-input type="text" readonly @click="option=true; $nextTick(() => $refs.input.focus())" wire:model.debounce.1000ms="supplier_select" @keydown.escape="option = false" />
            <div class="absolute mt-1 w-full rounded-md bg-white dark:bg-darkBg shadow-lg z-50" x-show="option" x-on:click.away="option = false">
                <div class="py-1 overflow-y-scroll z-50 text-gray-800 dark:text-white">
                    <x-input x-ref="input"  type="text" class="px-2" wire:model.debounce.1000ms="supplier_search"/>
                    <div @click="option = false" wire:click.prevent="setSupplierValue('', 'select supplier')" class="px-2 py-2 dark:hover:bg-gray-900 hover:bg-gray-100 cursor-pointer">@lang('select supplier')</div>
                    @foreach($suppliers as $supplier)
                        <div @click="option = false" wire:click.prevent="setSupplierValue({{$supplier->id}}, '{{$supplier->name}}')" class="px-2 py-2 dark:hover:bg-gray-900 hover:bg-gray-100 cursor-pointer">{{ $supplier->name }}</div>
                    @endforeach
                </div>
            </div>
        </div>



    </div>


    @if($supplier_search_id!=null)
        <div class="bg-white dark:bg-gray-800">
            <div class="container mx-auto px-4 py-8">
                <div class="flex flex-col md:flex-row items-center justify-between md:space-x-10">
                    <div class="mb-4 md:mb-0">
                        <h1 class="text-3xl font-bold text-gray-800 dark:text-white">@lang('Supplier Profile') </h1>
                        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">@lang('View customer details, purchases, and bills.')</p>
                    </div>
                    {{--                <div class="flex items-center space-x-4">--}}
                    {{--                    <button class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md focus:outline-none focus:shadow-outline-blue">Edit Profile</button>--}}
                    {{--                    <button class="px-4 py-2 bg-gray-300 dark:bg-gray-700 hover:bg-gray-400 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 rounded-md focus:outline-none focus:shadow-outline-gray">Logout</button>--}}
                    {{--                </div>--}}
                </div>
                <div class="bg-gray-100 dark:bg-gray-700 px-6 py-4 rounded-md mt-8">
                    <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">Supplier Summary</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="bg-white dark:bg-gray-800 p-4 rounded-md text-center">
                            <p class="text-sm font-medium text-gray-700 dark:text-gray-300 uppercase">Grand Total</p>
                            <p class="mt-2 text-2xl font-bold text-gray-800 dark:text-white">{{$sup_bill->sum('total_amount');}}</p>
                        </div>
                        <div class="bg-white dark:bg-gray-800 p-4 rounded-md text-center">
                            <p class="text-sm font-medium text-gray-700 dark:text-gray-300 uppercase">Total Paid</p>
                            <p class="mt-2 text-2xl font-bold text-green-600 dark:text-green-400">{{$sup_bill->sum('paid_amount');}}</p>
                        </div>
                        <div class="bg-white dark:bg-gray-800 p-4 rounded-md text-center">
                            <p class="text-sm font-medium text-gray-700 dark:text-gray-300 uppercase">Total Due</p>
                            <p class="mt-2 text-2xl font-bold text-red-600 dark:text-red-400">{{$sup_bill->sum('due_amount');}}</p>
                        </div>
                    </div>
                </div>
                <!-- Supplier Details Section -->
                <div class="mt-8">
                    <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">@lang('Supplier Details')</h2>
                    <div class="bg-gray-100 dark:bg-gray-700 px-6 py-4 rounded-md">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">@lang('Name')</label>
                                <p class="mt-1 text-sm text-gray-900 dark:text-white" id="name">{{$sup->name}}</p>
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email Address</label>
                                <p class="mt-1 text-sm text-gray-900 dark:text-white" id="email">{{$sup->email}}</p>
                            </div>
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Phone Number</label>
                                <p class="mt-1 text-sm text-gray-900 dark:text-white" id="phone">{{$sup->phone}}</p>
                            </div>
                            <div>
                                <label for="address" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Address</label>
                                <p class="mt-1 text-sm text-gray-900 dark:text-white" id="address">{{$sup->address}}</p>
                            </div>
                        </div>
                    </div>
                </div>



                <!-- bills Section -->
                <div class="mt-8">
                    <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">bills</h2>
                    <div class="bg-gray-100 dark:bg-gray-700 px-6 py-4 rounded-md">
                        <div class="overflow-x-auto">
                            <table class="table-auto w-full">
                                <thead>
                                <tr class="text-left">
                                    <th class="font-semibold text-gray-700 dark:text-white">bill #</th>
                                    <th class="font-semibold text-gray-700 dark:text-white">Date</th>
                                    <th class="font-semibold text-gray-700 dark:text-white">Amount</th>
                                    <th class="font-semibold text-gray-700 dark:text-white">Status</th>
                                </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                @foreach($sup_bill_details as $sup_bill_detail)
                                    <tr>
                                        <td class="py-2 font-medium text-gray-900 dark:text-white">#{{$sup_bill_detail->purchase_id}}</td>
                                        <td class="py-2 text-gray-500 dark:text-gray-400">{{$sup_bill_detail->date}}</td>
                                        <td class="py-2 font-medium text-gray-900 dark:text-white">{{$sup_bill_detail->current_paid_amount}}</td>
                                        <td class="py-2">
                  <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100">
                    Paid
                  </span>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <aside class="border dark:border-gray-600 row-span-4 bg-white dark:bg-darkSidebar" x-data="{rows: @entangle('selectedRows').defer, selectPage: @entangle('selectPageRows')}">
        <div class="flex justify-between gap-3 bg-white border dark:border-gray-600 dark:bg-darkSidebar px-1 py-2">
            <p class="text-gray-600 dark:text-gray-200 capitalize">@lang('purchases')</p>
            {{--            <a class="text-blue-500" href="{{route('admin.quiz')}}">all quiz</a>--}}
            <div class="flex justify-center capitalize gap-4 text-gray-500 dark:text-gray-300 capitalize">
                <button @click.prevent="addModal" class="flex gap-1 text-white capitalize hover:bg-blue-700 font-semibold text-sm bg-blue-500 rounded">
                    <x-h-o-plus-circle class="w-5"/>
                    @lang('add new')</button>
                <button wire:click.prevent="generate_pdf" class="flex gap-1 text-white capitalize hover:bg-blue-700 font-semibold text-sm bg-blue-500 rounded">
                    <x-h-o-film class="w-5"/>
                    @lang('pdf')</button>
                <button class="" @click="openTable = !openTable">
                    <svg x-show="openTable" xmlns="http://www.w3.org/2000/svg" class="h-4" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd" />
                    </svg>
                    <svg x-show="!openTable" xmlns="http://www.w3.org/2000/svg" class="h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                </button>
                <div x-cloak x-show="rows.length > 0 " class="flex items-center justify-center" x-data="{bulk: false}">
                    <div class="relative inline-block">
                        <!-- Dropdown toggle button -->
                        <button @click="bulk=!bulk" class="relative z-10 block px-2 text-gray-700 border border-transparent rounded-md dark:text-white focus:border-blue-500 focus:ring-opacity-40 dark:focus:ring-opacity-40 focus:ring-blue-300 dark:focus:ring-blue-400 focus:ring focus:outline-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-800 dark:text-white" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z" />
                            </svg>
                        </button>

                        <!-- Dropdown menu -->
                        <div x-show="bulk" class="absolute right-0 z-20 w-48 py-2 mt-2 bg-white rounded-md shadow-xl dark:bg-gray-800" @click.outside="bulk= false">
                            <a @click="$dispatch('open-delete-modal', { title: 'Hello World!', text: 'you cant revert', icon: 'error', eventName: 'deleteMultiple', model: '' })" class="cursor-pointer block p-1 text-sm text-gray-600 capitalize transition-colors duration-200 transform dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 dark:hover:text-white">
                                Delete </a>
                            <a wire:click.prevent="" class="cursor-pointer block p-1 text-sm text-gray-600 capitalize transition-colors duration-200 transform dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 dark:hover:text-white">
                                Your projects </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div x-cloak x-show="openTable" x-collapse>
            <div class="mb-1 overflow-y-scroll scrollbar-none">
                <div class="w-full overflow-x-auto">
                    <table class="w-full whitespace-no-wrap">
                        <thead>
                        <tr
                            class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-300 dark:bg-darkSidebar"
                        >
                            <th class="p-1">
                                <input class="ring-0 dark:bg-gray-400" x-model="selectPage" type="checkbox" value="" name="todo2" id="todoCheck2">
                            </th>
                            <x-field :OB="$orderBy" :OD="$orderDirection" :field="'id'">@lang('sl')</x-field>
                            <x-field :OB="$orderBy" :OD="$orderDirection" :field="'purchase_no'">@lang('purchase no')</x-field>
                            <x-field :OB="$orderBy" :OD="$orderDirection" :field="'total'">@lang('total')</x-field>
                            <x-field :OB="$orderBy" :OD="$orderDirection" :field="'user_id'">@lang('supplier')</x-field>
                            <x-field :OB="$orderBy" :OD="$orderDirection" :field="''">@lang('due')</x-field>
                            <x-field :OB="$orderBy" :OD="$orderDirection" :field="''">@lang('paid status')</x-field>
                            <x-field :OB="$orderBy" :OD="$orderDirection" :field="'status'">@lang('status')</x-field>
                            <x-field :OB="$orderBy" :OD="$orderDirection" :field="'created_at'">@lang('date')</x-field>
                            <x-field :OB="$orderBy" :OD="$orderDirection" :field="'action'">@lang('action')</x-field>
                        </tr>
                        </thead>
                        <tbody
                            class="bg-white divide-y dark:divide-gray-700 dark:bg-darkSidebar"
                        >
                        @forelse($items as $i => $item)
                            @php
                                if ($item->bill->due_amount==0){
                                    $bill_status = 'paid';
                                }elseif($item->bill->due_amount==$item->bill->total_amount){
                                    $bill_status = 'due';
                                }else{
                                    $bill_status = __('partial');
                                }
                            @endphp
                            <tr id="item-id-{{$item->id}}" class="text-gray-700 dark:text-gray-300 capitalize" :class="{'bg-gray-200 dark:bg-gray-600': rows.includes('{{$item->id}}') }">
                                <td class="p-1">
                                    <input x-model="rows" class="ring-none dark:bg-gray-400" type="checkbox" value="{{ $item->id }}" name="todo2" id="{{ $item->id }}">
                                </td>
                                <td class="p-1">{{$items->firstItem() + $i}}</td>
                                <td class="p-1 text-sm">#{{ $item->purchase_no }} </td>
                                <td class="p-1 text-sm">{{ $item->total }} </td>
                                <td class="p-1 text-sm">{{ $item->supplier->name}}-{{$item->supplier->phone }} </td>
                                <td class="p-1 text-sm">{{ $item->bill->due_amount }} </td>
                                <td class="p-1 text-sm"> <span class="text-white cursor-pointer px-2 py-1 font-semibold rounded-lg
                                {{ $bill_status=='paid'?'bg-green-300 dark:bg-green-700' :($bill_status=='partial'? 'bg-blue-300 dark:bg-blue-700': ($bill_status=='due'? 'bg-red-300 dark:bg-red-700':'')) }} ">
                                    {{ $bill_status }}
                                </span></td>
                                <td class="p-1 text-xs">
                                    <button class="uppercase px-2 py-1 font-semibold leading-tight {{$item->status==='active'?'text-green-700 bg-green-100':'text-red-700 bg-red-100'}}  rounded-full " wire:click.prevent="changeStatus({{ $item->id }})">{{ $item->status }}
                                        <span wire:loading wire:target="changeStatus({{ $item->id }})" class="animate-spin rounded-full h-4 w-4 border-2 border-black"></span></button>
                                </td>
                                <td class="p-1 text-sm">{{ $item->created_at }} </td>
                                <td class="p-1 text-sm flex space-x-4">
                                    <a target="_blank" href="{{route('pdf.purchase', $item->id)}}" data-turbolinks="false"><x-h-o-printer class="w-5 text-purple-600 cursor-pointer"/></a>
                                    <x-h-o-identification wire:target="viewProduct({{$item->id}})" wire:loading.class="animate-spin" @click.prevent="viewData({{$item->id}})" class="w-5 text-purple-600 cursor-pointer"/>
                                    @if($item->status=='inactive')
                                    <x-h-o-pencil-square wire:target="loadData({{$item->id}})" wire:loading.class="animate-spin" @click.prevent="editModal({{$item->id}})" class="w-5 text-purple-600 cursor-pointer"/>
                                        <x-h-o-trash @click.prevent="$dispatch('open-delete-modal', { title: 'Hello World!', text: 'you cant revert', icon: 'error', eventName: 'deleteSingle', model: {{$item->id}} })" class="w-5 text-pink-500 cursor-pointer"/>
                                    @endif
                                </td>
                            </tr>
                        @empty

                        @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mx-auto my-4 px-1">
                    {{--                    {{ $items->links('vendor.pagination.default') }}--}}
                    {{ $items->links() }}
                </div>
            </div>
        </div>
    </aside>

</div>

