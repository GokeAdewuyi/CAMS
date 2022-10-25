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
                 class="relative bg-gray-100 rounded-lg px-4 pt-5 pb-4 overflow-y-scroll shadow-xl transform transition-all sm:max-w-lg sm:w-full sm:p-6">
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
                            {{ __('Add Student') }}
                        </h3>
                        <div class="mt-2">
                            <form>
                                @csrf

                                <div class="">
                                    <x-jet-label for="firstname" value="{{ __('First Name') }}" />
                                    <x-jet-input id="firstname" class="block mt-1 w-full" type="text" name="firstname" wire:model.defer="firstname" required autofocus autocomplete="firstname" />
                                    <x-jet-input-error for="firstname" class="mt-2" />
                                </div>

                                <div class="mt-4">
                                    <x-jet-label for="lastname" value="{{ __('Last Name') }}" />
                                    <x-jet-input id="lastname" class="block mt-1 w-full" type="text" name="lastname" wire:model.defer="lastname" required />
                                    <x-jet-input-error for="lastname" class="mt-2" />
                                </div>

                                <div class="mt-4">
                                    <x-jet-label for="othername" value="{{ __('Other Names') }}" />
                                    <x-jet-input id="othername" class="block mt-1 w-full" type="text" name="othername" wire:model.defer="othername" />
                                </div>

                                <div class="mt-4">
                                    <x-jet-label for="email" value="{{ __('Email') }}" />
                                    <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" wire:model.defer="email" />
                                </div>

                                <div class="mt-4">
                                    <x-jet-label for="matric_number" value="{{ __('Matric Number') }}" />
                                    <x-jet-input id="matric_number" class="block mt-1 w-full" type="text" name="matric_number" wire:model.defer="matric_number" required />
                                    <x-jet-input-error for="matric_number" class="mt-2" />
                                </div>

                                <div class="mt-4">
                                    <x-jet-label for="level" value="{{ __('Level') }}" />
                                    <x-jet-input id="level" class="block mt-1 w-full" type="text" name="level" wire:model.defer="level" required />
                                    <x-jet-input-error for="level" class="mt-2" />
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
