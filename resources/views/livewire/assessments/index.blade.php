<div x-data="{ openCumulative: false, working: false }" x-cloak>
    <x-slot name="header">
        @if($course)
            @if($assessment)
                <a href="{{ route('assessments').'?r=1' }}" class="float-right flex text-indigo-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mt-1 text-indigo-700" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M7.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                    </svg>
                    Switch Assessment
                </a>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Result - ').$assessment['title'] }}
                </h2>
            @else
                <a href="{{ route('assessments').'?b=1' }}" class="float-right flex text-indigo-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mt-1 text-indigo-700" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M7.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                    </svg>
                    Switch Course
                </a>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Assessment - ').$course['code'] }}
                </h2>
            @endif
        @else
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Select Course') }}
            </h2>
        @endif
    </x-slot>

    <div class="py-12">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                @include('alert-messages')
                @if($course)
                    @php
                        $assessments = $course->assessments()->where('user_id', auth()->id())->where('semester_id', get_current_semester_id())->get();
                        $students = $course->students()->where('semester_id', get_current_semester_id())->orderBy('matric_number')->get();
                    @endphp
                    @if($assessment)
                        @include('livewire.assessments.students', ['openResultModal' => $openResultModal, 'assessment' => $assessment])
                    @else
                        <div class="flex justify-end mt-4">
                            <div class="ml-2 mr-2">
                                @if(count($assessments) > 0)
                                    <x-jet-button @click="openCumulative = true">
                                        {{ __('View Cumulative') }}
                                    </x-jet-button>

                                    @include('livewire.assessments.cumulative')
                                @endif
                            </div>
                            @if(get_current_semester_status() != 'closed')
                                <div class="ml-2 mr-2">
                                    <x-jet-button wire:click="create()">
                                        {{ __('Add Assessment') }}
                                    </x-jet-button>
                                </div>
                            @endif
                        </div>

                        @if($openModal)
                            @include('livewire.assessments.create', ['course' => $course])
                        @endif
                        <div class="p-3 sm:px-5 bg-white border-b border-gray-200">
                            <div class="">
                                <livewire:assessment-table />
                            </div>
                        </div>
                    @endif
                @else
                    @include('livewire.assessments.details')
                @endif
            </div>
        </div>
    </div>
</div>
