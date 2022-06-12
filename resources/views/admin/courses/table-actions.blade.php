@php
    $course = App\Models\Course::where('id', $id)->first();
@endphp
<div class="flex space-x-1 justify-around">
{{--    <x-modal :value="$id">--}}
{{--        <x-slot name="trigger">--}}
{{--            <button class="p-1 text-blue-600 hover:bg-blue-600 hover:text-white rounded">--}}
{{--                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path></svg>--}}
{{--            </button>--}}
{{--        </x-slot>--}}
{{--        <x-slot name="header">--}}
{{--            {{ __('Course Details') }}--}}
{{--        </x-slot>--}}
{{--        <x-slot name="content">--}}
{{--            <div class="px-4 pt-5 pb-4 sm:p-6 sm:pb-4">--}}
{{--                <table class="w-full">--}}
{{--                    <tr>--}}
{{--                        <td class="w-1/3"><b>Code:</b></td>--}}
{{--                        <td class="w-2/3 left">{{ $course['code'] }}</td>--}}
{{--                    </tr>--}}
{{--                    <tr>--}}
{{--                        <td class="w-1/3"><b>Title:</b></td>--}}
{{--                        <td class="w-2/3">{{ $course['title'] }}</td>--}}
{{--                    </tr>--}}
{{--                    <tr>--}}
{{--                        <td class="w-1/3"><b>Unit:</b></td>--}}
{{--                        <td class="w-2/3">{{ $course['unit'] }}</td>--}}
{{--                    </tr>--}}
{{--                    <tr>--}}
{{--                        <td class="w-1/3"><b>Curriculum:</b></td>--}}
{{--                        <td class="w-2/3">{{ $course->curriculum->name }}</td>--}}
{{--                    </tr>--}}
{{--                    <tr>--}}
{{--                        <td class="w-1/3"><b>Date Added:</b></td>--}}
{{--                        <td class="w-2/3">{{ date('Y-m-d', strtotime($course['created_at'])) }}</td>--}}
{{--                    </tr>--}}
{{--                    <tr>--}}
{{--                        <td class="w-1/3"><b>Total Lecturers:</b></td>--}}
{{--                        <td class="w-2/3">--}}
{{--                            @if(count($course->lecturers) > 0)--}}
{{--                                {{ $course->lecturers()->count() }}--}}
{{--                            @else--}}
{{--                                <i class="text-blue-400">Course not allocated yet</i>--}}
{{--                            @endif--}}
{{--                        </td>--}}
{{--                    </tr>--}}
{{--                </table>--}}
{{--            </div>--}}
{{--        </x-slot>--}}
{{--    </x-modal>--}}
    <x-modal :value="$id" :open="old('course') == $id">
        <x-slot name="trigger">
            <button class="p-1 text-blue-600 hover:bg-blue-600 hover:text-white rounded" title="Allocate Course">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            </button>
        </x-slot>
        <x-slot name="header">
            {{ __('Allocate Course - ').$course['code'] }}
        </x-slot>
        <x-slot name="content">
            <div class="px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <form method="POST" action="{{ route('courses.allocate') }}">
                    @csrf
                    <input type="hidden" name="course" value="{{ $id }}">
                    <div class="">
                        <x-jet-label for="semester" value="{{ __('Semester*') }}" />
                        <select name="semester" id="semester" class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                                required onchange="fetchLecturers({{$course['id']}},this.value)" >
                            <option value=""> Select Semester</option>
                            @foreach(\App\Models\Semester::orderByDesc('session')->where('status', '!=', 'closed')->get() as $sem)
                                <option value="{{ $sem['id'] }}"
                                    {{ get_current_semester_id() == $sem['id'] ? 'selected' : '' }}
                                > {{ $sem['type'].' - '.$sem['session'] }}</option>
                            @endforeach
                        </select>
                        <x-jet-input-error for="semester" class="mt-2" />
                    </div>
                    <div class="mt-2">
                        <x-jet-label for="" value="{{ __('Lecturers*') }}" />
                        <x-jet-input-error for="lecturers" class="" />
                        <div class="grid grid-cols-2 gap-2" id="lecturers-list-{{ $course['id'] }}">
                            @foreach(\App\Models\User::where('id', '!=', 1)->orderBy('name')->get() as $key => $lecturer)
                                <div>
                                    <x-jet-label for="lecturer-{{ $course['id'] }}-{{ $key }}">
                                        <div class="flex items-center">
                                            <input name="lecturers[]" type="checkbox"
                                                   id="lecturer-{{ $course['id'] }}-{{ $key }}" value="{{ $lecturer['id'] }}"
                                                   class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                                {{ $lecturer->canLectureCourse($course['id']) ? 'checked' : '' }}
                                            />
                                            <div class="ml-2">
                                                {{ $lecturer->name }}
                                            </div>
                                        </div>
                                    </x-jet-label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse mt-4">
                        <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                            <x-jet-button type="submit" class="bg-green-500">
                                {{ __('Save') }}
                            </x-jet-button>
                        </span>
                    </div>
                </form>
            </div>
        </x-slot>
    </x-modal>

    @include('datatables::delete', ['value' => $course['code'], 'id' => $id])
</div>

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script>
        const users = {!! json_encode(\App\Models\User::query()->where('id', '!=', 1)->orderBy('name')->get()) !!};
        function fetchLecturers(course, id) {
            if (id) {
                $.ajax({
                    type: "GET",
                    url: `lecturers/course/${course}/semester/${id}`,
                    headers: {'X-CSRF-Token': '{{ csrf_token() }}'},
                    processData: false,
                    contentType: false,
                    cache: false,
                    success: function (res) {
                        let html = '';
                        if (res.length)
                            users.forEach((user, index) => {
                                const lecturer = res.find(cur => cur.id === user.id)
                                html += `
                                    <div>
                                        <x-jet-label for="lecturer-${course}-${index}">
                                            <div class="flex items-center">
                                                <input name="lecturers[]" type="checkbox" id="lecturer-${course}-${index}" value="${user.id}" ${lecturer ? 'checked' : ''} />
                                                <div class="ml-2">
                                                    ${user.name}
                                                </div>
                                            </div>
                                        </x-jet-label>
                                    </div>
                                `
                            })
                        else
                            users.forEach((user, index) => {
                                html += `
                                    <div>
                                        <x-jet-label for="lecturer-${course}-${index}">
                                            <div class="flex items-center">
                                                <input name="lecturers[]" type="checkbox" id="lecturer-${course}-${index}" value="${user.id}" />
                                                <div class="ml-2">
                                                    ${user.name}
                                                </div>
                                            </div>
                                        </x-jet-label>
                                    </div>
                                `
                            })
                        if (html)
                            $(`#lecturers-list-${course}`).html(html)
                    },
                    error: function (res) {
                        //
                    }
                })
            } else {
                let html = ''
                users.forEach((user, index) => {
                    html += `
                        <div>
                            <x-jet-label for="lecturer-${course}-${index}">
                                <div class="flex items-center">
                                    <input name="lecturers[]" type="checkbox" id="lecturer-${course}-${index}" value="${user.id}" />
                                    <div class="ml-2">
                                        ${user.name}
                                    </div>
                                </div>
                            </x-jet-label>
                        </div>
                    `
                })
                if (html)
                    $(`#lecturers-list-${course}`).html(html)
            }
        }
    </script>
@endsection
