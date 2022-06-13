@php $semester = App\Models\Semester::where('id', $id)->first() @endphp
<div class="flex space-x-1 justify-around">
    <x-modal :value="$id" :open="false">
        <x-slot name="trigger">
            <button class="p-1 text-blue-600 hover:bg-blue-600 hover:text-white rounded" title="Change Status">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path></svg>            </button>
        </x-slot>
        <x-slot name="header">
            {{ __('Change Semester Status') }}
        </x-slot>
        <x-slot name="content">
            <div class="px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <form method="POST" action="{{ route('semesters.update', $id) }}">
                    @csrf
                    @method('PUT')
                    <div class="mt-2">
                        <x-jet-label for="" value="{{ __('Select Status') }}" />
                        <x-jet-input-error for="lecturers" class="" />
                        <div class="grid grid-cols-2 gap-2" id="semester-list-{{ $semester['id'] }}">
                            <div>
                                <x-jet-label for="status-current-{{ $semester['id'] }}">
                                    <div class="flex items-center">
                                        <input name="status" type="radio"
                                               {{ $semester['status'] == 'current' ? 'checked' : '' }}
                                               id="status-current-{{ $semester['id'] }}" value="current" />
                                        <div class="ml-2">Current</div>
                                    </div>
                                </x-jet-label>
                            </div>

                            <div>
                                <x-jet-label for="status-open-{{ $semester['id'] }}">
                                    <div class="flex items-center">
                                        <input name="status" type="radio"
                                               {{ $semester['status'] == 'open' ? 'checked' : '' }}
                                               id="status-open-{{ $semester['id'] }}" value="open" />
                                        <div class="ml-2">Open</div>
                                    </div>
                                </x-jet-label>
                            </div>

                            <div>
                                <x-jet-label for="status-closed-{{ $semester['id'] }}">
                                    <div class="flex items-center">
                                        <input name="status" type="radio"
                                               {{ $semester['status'] == 'closed' ? 'checked' : '' }}
                                               id="status-closed-{{ $semester['id'] }}" value="closed" />
                                        <div class="ml-2">Closed</div>
                                    </div>
                                </x-jet-label>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse mt-4">
                        <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                            <x-jet-button type="submit" class="bg-green-500 show-loader">
                                {{ __('Save') }}
                            </x-jet-button>
                        </span>
                    </div>
                </form>
            </div>
        </x-slot>
    </x-modal>

    @include('datatables::delete', ['value' => $semester['type'].' Semester - '.$semester['session'], 'id' => $id])
</div>
