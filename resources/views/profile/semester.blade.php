<x-jet-action-section>
    <x-slot name="title">
        {{ __('Current Semester') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Set the current semester.') }}
    </x-slot>

    <x-slot name="content">
        <form action="{{ route('semesters.set') }}" method="post">
            @csrf
            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for="semester" value="{{ __('Semester') }}" />
                <select name="semester" id="semester"
                        class="mt-1 block w-1/2 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                    <option value="">Select Semester</option>
                    @foreach(\App\Models\Semester::orderByDesc('session')->get() as $semester)
                        <option value="{{ $semester['id'] }}"
                                {{ get_current_semester_id() == $semester['id'] ? 'selected' : '' }}
                        >{{ $semester['session'] }} - {{ $semester['status'] }}</option>
                    @endforeach
                </select>
                <x-jet-input-error for="semester" class="mt-2" />
            </div>
            <div class="flex items-center justify-end px-4 py-3 bg-gray-50 text-right mt-6 sm:px-6 shadow sm:rounded-bl-md sm:rounded-br-md">
                @if(session('semester_saved'))
                    <div x-data="{ shown: true, timeout: null }"
                         x-init="() => { clearTimeout(timeout); timeout = setTimeout(() => { shown = false }, 2000);  }"
                         x-show.transition.out.opacity.duration.1500ms="shown"
                         x-transition:leave.opacity.duration.1500ms
                         style="display: none;" class="text-sm text-gray-600 mr-2"> Saved. </div>
                @endif
                <x-jet-button type="submit" @click="document.querySelector('#semester-form').submit()">
                    {{ __('Save') }}
                </x-jet-button>
            </div>
        </form>
    </x-slot>
</x-jet-action-section>
