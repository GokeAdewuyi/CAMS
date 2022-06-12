@php
    $courses = request()->user()->courses()->where('semester_id', get_current_semester_id())->get();
@endphp
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="mt-5 sm:px-6 lg:px-8">
                    <h1 class="text-2xl">Course Analysis</h1>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($courses as $key => $course)
                        <div class="card">
                            <h3 class="heading my-4">Top Performers - {{ $course->code }}</h3>
                            @if(!$course->assessments()->whereHas('results')->first())
                                No assessment yet.
                            @endif
                            <div id="chart-{{ $key }}"></div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    @section('scripts')
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
        <script>
            let chart, series, labels, options;
            @foreach($courses as $key => $course)
                @php $percentage = $course->assessments()->where('semester_id', get_current_semester_id())->sum('percentage'); @endphp
                series = {!! json_encode(\App\Models\Result::query()
                    ->join('assessments', 'assessments.id', '=', 'results.assessment_id')
                    ->join('students', 'students.id', '=', 'results.student_id')
                    ->select(
                        DB::raw("CONCAT(firstname, ' ', lastname) as name"),
                        'matric_number',
                        DB::raw("round((sum(results.score) / $percentage) * 30) as score")
                    )
                    ->where('assessments.semester_id', get_current_semester_id())
                    ->where('assessments.course_id', $course->id)
                    ->where('assessments.user_id', auth()->id())
                    ->groupBy('student_id', 'matric_number')
                    ->orderByDesc('score')
                    ->get()
                    ->take(5)
                    ->each(function ($data) {
                        return $data['score'] = (int) $data['score'];
                    })
                    ->pluck('score')) !!};

                labels = {!! json_encode(\App\Models\Result::query()
                    ->join('assessments', 'assessments.id', '=', 'results.assessment_id')
                    ->join('students', 'students.id', '=', 'results.student_id')
                    ->select(
                        DB::raw("CONCAT(firstname, ' ', lastname) as name"),
                        'matric_number',
                        DB::raw("round((sum(results.score) / $percentage) * 30) as score")
                    )
                    ->where('assessments.semester_id', get_current_semester_id())
                    ->where('assessments.course_id', $course->id)
                    ->where('assessments.user_id', auth()->id())
                    ->groupBy('student_id', 'matric_number')
                    ->orderByDesc('score')
                    ->get()
                    ->take(5)
                    ->pluck('matric_number')) !!};

                options = {
                    series,
                    chart: {
                        width: 360,
                        type: 'pie',
                    },
                    labels,
                    responsive: [{
                        breakpoint: 480,
                        options: {
                            chart: {
                                width: 360
                            },
                            legend: {
                                position: 'top'
                            }
                        }
                    }],
                    dataLabels: {
                        enabled: true,
                        formatter: function (val, key) {
                            return series[key.seriesIndex]
                        },
                        dropShadow: {
                            //
                        }
                    }
                };

                chart = new ApexCharts(document.querySelector("#chart-{{ $key }}"), options);
                chart.render();
            @endforeach
        </script>
    @endsection
</x-app-layout>
