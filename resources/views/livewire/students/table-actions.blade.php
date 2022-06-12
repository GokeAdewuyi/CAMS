@php
    $student = \App\Models\Student::where('course_id', session('current_course'))
                    ->where('semester_id', get_current_semester_id())
                    ->where('matric_number', $id)
                    ->first();
@endphp
<div class="flex space-x-1 justify-around">
    <x-modal :value="$student->matric_number">
        <x-slot name="trigger">
            <button class="p-1 text-blue-600 hover:bg-blue-600 hover:text-white rounded">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path></svg>
            </button>
        </x-slot>
        <x-slot name="header">
            {{ __('Student Details') }}
        </x-slot>
        <x-slot name="content">
            <div class="px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <table class="w-full">
                    <tr>
                        <td class="w-1/3"><b>Firstname:</b></td>
                        <td class="w-2/3 left">{{ $student['firstname'] }}</td>
                    </tr>
                    <tr>
                        <td class="w-1/3"><b>Lastname:</b></td>
                        <td class="w-2/3">{{ $student['lastname'] }}</td>
                    </tr>
                    <tr>
                        <td class="w-1/3"><b>Othername:</b></td>
                        <td class="w-2/3">{{ $student['othername'] }}</td>
                    </tr>
                    <tr>
                        <td class="w-1/3"><b>Email:</b></td>
                        <td class="w-2/3">{{ $student['email'] }}</td>
                    </tr>
                    <tr>
                        <td class="w-1/3"><b>Matric No:</b></td>
                        <td class="w-2/3">{{ $student['matric_number'] }}</td>
                    </tr>
                    <tr>
                        <td class="w-1/3"><b>Level</b></td>
                        <td class="w-2/3">{{ $student['level'] }}</td>
                    </tr>
                </table>
            </div>
        </x-slot>
    </x-modal>

    @if(get_current_semester_status() != 'closed')
        @include('datatables::delete', ['value' => $student['matric_number'], 'id' => $student['id']])
    @endif
</div>
