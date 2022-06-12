<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ auth()->user()['is_admin'] ? __('Courses') : __('My Courses') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-3 sm:px-5 bg-white border-b border-gray-200">
                    @include('alert-messages')
                    @if(auth()->user()['is_admin'])
                        <div class="flex justify-end mt-4">
                            <div class="mr-2">
                                <x-jet-button wire:click="create()">
                                    {{ __('Add Course') }}
                                </x-jet-button>
                            </div>
                        </div>

                        @if($openModal)
                            @include('admin.courses.create')
                        @endif
                    @endif
                    <livewire:course-table />
                </div>
            </div>
        </div>
    </div>
</div>
