<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="mt-5 mb-5 sm:px-6 lg:px-8">
                    <h1 class="text-2xl">Course Analysis</h1>
                    @if(!\App\Models\CourseAllocation::query()->where('semester_id', get_current_semester_id())->first())
                        No course allocation yet.
                    @endif
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($charts as $key => $chart)
                        <div class="card">
                            <h3 class="heading my-4">Top Performers - {{ $chart['course']['code'] }}</h3>
                            @if(count($chart['labels']) < 1)
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
            @foreach($charts as $key => $chart)
                labels = {!! json_encode($chart['labels']) !!};
            series = {!! json_encode($chart['series']) !!};
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
