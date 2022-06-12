@php $lecturer = App\Models\User::where('id', $id)->first() @endphp
<div class="flex space-x-1 justify-around">
    <x-modal :value="$id">
        <x-slot name="trigger">
            <button class="p-1 text-blue-600 hover:bg-blue-600 hover:text-white rounded">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path></svg>
            </button>
        </x-slot>
        <x-slot name="header">
            {{ __('Lecturer Details') }}
        </x-slot>
        <x-slot name="content">
            <div class="px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <table class="w-full">
                    <tr>
                        <td class="w-1/3"><b>Name:</b></td>
                        <td class="w-2/3 left">{{ $lecturer['name'] }}</td>
                    </tr>
                    <tr>
                        <td class="w-1/3"><b>Email:</b></td>
                        <td class="w-2/3">{{ $lecturer['email'] }}</td>
                    </tr>
                    <tr>
                        <td class="w-1/3"><b>PFN:</b></td>
                        <td class="w-2/3">{{ $lecturer['pfn'] }}</td>
                    </tr>
                    <tr>
                        <td class="w-1/3"><b>Date Added:</b></td>
                        <td class="w-2/3">{{ date('Y-m-d', strtotime($lecturer['created_at'])) }}</td>
                    </tr>
                    <tr>
                        <td class="w-1/3"><b>Course(s):</b></td>
                        <td class="w-2/3">
{{--                            {{ $lecturer->courses()->count() }}--}}
                            @if(count($lecturer->courses) > 0)
                                @foreach($lecturer->courses as $key => $course)
                                    @if($key != count($lecturer->courses) - 1)
                                        {{ $course->code .' / ' }}
                                    @else
                                        {{ $course->code }}
                                    @endif
                                @endforeach
                            @else
                                <i class="text-blue-400">No course allocated yet</i>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
        </x-slot>
    </x-modal>

    @include('datatables::delete', ['value' => $lecturer['name'], 'id' => $id])
</div>
