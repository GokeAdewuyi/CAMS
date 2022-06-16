<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Courses') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-3 sm:px-5 bg-white border-b border-gray-200">
                    @include('alert-messages')
{{--                    <button wire:click="create()"--}}
{{--                            class="my-4 float-right inline-flex justify-center rounded-md border border-transparent px-4 py-2 bg-green-600 text-base font-bold text-white shadow-sm hover:bg-green-800">--}}
{{--                        Create Student--}}
{{--                    </button>--}}
{{--                    @if($isModalOpen)--}}
{{--                        @include('livewire.create')--}}
{{--                    @endif--}}
                    <table class="table-fixed w-full">
                        <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-2 w-20">#</th>
                            <th class="px-4 py-2">Name</th>
                            <th class="px-4 py-2">Email</th>
                            <th class="px-4 py-2">Mobile</th>
                            <th class="px-4 py-2">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
