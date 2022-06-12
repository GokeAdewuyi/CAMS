@php
    $total = \App\Models\Assessment::query()
            ->where('semester_id', get_current_semester_id())
            ->where('course_id', $course->id)
            ->where('user_id', auth()->id())
            ->sum('percentage');
@endphp
<div x-show="openCumulative"
     class="w-full fixed z-50 bottom-0 inset-x-0 px-4 pb-4 mt-5 sm:inset-0 sm:flex sm:items-start sm:justify-center">
    <div x-show="openCumulative" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
         class="fixed inset-0 transition-opacity">
        <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
    </div>

    <div x-show="openCumulative" x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
         x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
         class="relative bg-gray-100 rounded-lg px-4 pt-5 pb-4 overflow-auto shadow-xl transform transition-all">
        <div class="hidden sm:block absolute top-0 right-0 pt-4 pr-4">
            <button @click="openCumulative = false" type="button"
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
                    {{ $course->code }} {{ __(' Assessment Cumulative') }}
                </h3>
                <div class="mt-2" id="preview-table-container">
                    <livewire:cumulative-table course="{!! $course->id !!}" total="{!! $total !!}" />
                </div>
            </div>
        </div>
    </div>
</div>
