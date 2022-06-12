@php $courses = request()->user()->courses()->withPivotValue(['semester_id' => get_current_semester_id()])->orderBy('code')->get() @endphp
@if(count($courses) > 0)
    <div class="bg-gray-200 bg-opacity-25 grid grid-cols-1 md:grid-cols-2">
        @foreach($courses as $key => $course)
            <div class="p-6 border-t border-gray-200 md:border-t-0 md:border-l">
                <div class="flex items-center">
                    <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" class="w-8 h-8 text-gray-400"><path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    <div class="ml-4 text-lg text-gray-600 leading-7 font-semibold"><a href="{{ route('assessments').'?c='.$course['id'] }}">{{ $course['code'] }}</a></div>
                </div>

                <div class="ml-12">
                    <div class="mt-2 text-sm text-gray-500">{{ $course['title'] }}</div>

                    <a href="{{ route('assessments').'?c='.$course['id'] }}">
                        <div class="mt-3 flex items-center text-sm font-semibold text-indigo-700">
                            <div>Add / View Assessments</div>

                            <div class="ml-1 text-indigo-500">
                                <svg viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        @endforeach
    </div>
@else
    <div class="bg-gray-200 bg-opacity-25">
        <div class="p-6 border-t border-gray-200">
            <div class="ml-12">
                @php $semester = get_current_semester() @endphp
                <div class="mt-2 text-md text-gray-500">
                    You have no courses allocated to you for the {{ $semester->type }} semester, {{ $semester->session }} academic session, contact admin.
                </div>

            </div>
        </div>
    </div>
@endif

