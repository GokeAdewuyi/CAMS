<div x-data="{ open: {{ isset($openModal) && $openModal ? 'true' : 'false' }}, working: false }" x-cloak>
    <div class="flex space-x-1 justify-around">
        <div x-show="open"
             class="w-full fixed z-50 bottom-0 inset-x-0 px-4 pb-4 sm:inset-0 sm:flex sm:items-start mt-5 sm:justify-center">
            <div x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                 class="fixed inset-0 transition-opacity">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>

            <div x-show="open" x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="relative bg-gray-100 rounded-lg px-4 pt-5 pb-4 overflow-auto shadow-xl transform transition-all sm:max-w-lg sm:w-full sm:p-6">
                <div class="hidden sm:block absolute top-0 right-0 pt-4 pr-4">
                    <button wire:click="closeModalPopover()" type="button"
                            class="text-gray-400 hover:text-gray-500 focus:outline-none focus:text-gray-500 transition ease-in-out duration-150">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="w-full">
                    <div class="mt-3">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                            {{ __('Add Course') }}
                        </h3>
                        <div class="mt-2">
                            <form>
                                @csrf

                                <div class="">
                                    <x-jet-label for="curriculum" value="{{ __('Curriculum*') }}" />
                                    <select name="curriculum" id="curriculum" class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" wire:model.defer="curriculum" required>
                                        <option value=""> Select Curriculum</option>
                                        @foreach(\App\Models\Curriculum::orderBy('name')->get() as $cur)
                                            <option value="{{ $cur['id'] }}"> {{ $cur['name'] }}</option>
                                        @endforeach
                                    </select>
                                    <x-jet-input-error for="curriculum" class="mt-2" />
                                </div>

                                <div class="mt-4">
                                    <x-jet-label for="code" value="{{ __('Code*') }}" />
                                    <x-jet-input id="code" class="block mt-1 w-full" type="text" name="code" wire:model.defer="code" required autofocus autocomplete="firstname" />
                                    <x-jet-input-error for="code" class="mt-2" />
                                </div>

                                <div class="mt-4">
                                    <x-jet-label for="title" value="{{ __('Title*') }}" />
                                    <x-jet-input id="title" class="block mt-1 w-full" type="text" name="title" wire:model.defer="title" />
                                    <x-jet-input-error for="title" class="mt-2" />
                                </div>

                                <div class="mt-4">
                                    <x-jet-label for="unit" value="{{ __('Unit*') }}" />
                                    <x-jet-input id="unit" class="block mt-1 w-full" type="number" step="1" name="unit" wire:model.defer="unit" />
                                    <x-jet-input-error for="unit" class="mt-2" />
                                </div>

                                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse mt-4">
                                    <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                                        <x-jet-button wire:click.prevent="store()" class="bg-green-500">
                                            {{ __('Save') }}
                                        </x-jet-button>
                                    </span>
                                    <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
                                        <x-jet-button wire:click="closeModalPopover()">
                                            {{ __('Close') }}
                                        </x-jet-button>
                                    </span>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
