<x-app-layout>
    <x-slot name="header">
        <a href="{{ route('term.member.index', $term ?? config('app.currentTermId')) }}" class="px-3 @if(request()->routeIs('term.member.index')) font-bold @endif">국회의원현황</a>
        <a href="{{ route('statistics') }}" class="px-3 @if(request()->routeIs('statistics')) font-bold @endif">통계</a>
    </x-slot>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/item-series.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <section class="mb-6 my-10">
            <h1 class="mb-3 text-2xl font-bold">정당별 의원현황</h1>
            <div class="border rounded-xl bg-white w-full pt-5">
                <div id="chart-parliament" style="width: 80%; height: 400px; margin: 0 auto;"></div>
            </div>
        </section>
        <section class="mb-6">
            <h1 class="mb-3 text-2xl font-bold">당선횟수별 의원현황</h1>
            <div class="border rounded-xl bg-white w-full pt-5">
                <div id="chart-term_number" style="width: 80%; height: 400px; margin: 0 auto;"></div>
            </div>
        </section>
        <section class="mb-6">
            <h1 class="mb-3 text-2xl font-bold">성별 의원현황</h1>
            <div class="border rounded-xl bg-white w-full pt-5">
                <div id="chart-gender" style="width: 80%; height: 400px; margin: 0 auto;"></div>
            </div>
        </section>
        <section class="mb-6">
            <h1 class="mb-3 text-2xl font-bold">연령별 의원현황</h1>
            <div class="border rounded-xl bg-white w-full pt-5">
                <div id="chart-age" style="width: 80%; height: 400px; margin: 0 auto;"></div>
            </div>
        </section>
    </div>
    <script>
    var statistics = @json($statistics);
    function initParliamentChart(){
        var data = statistics.parties.map(function(item){
            return [
                item.party_name,
                item.party_count,
                item.party_color,
            ]
        });

        Highcharts.chart('chart-parliament', {
            chart: {
                type: 'item'
            },
            title: {
              text: '',
            },
            legend: {
                labelFormat: '{name} <span style="opacity: 0.4">{y}</span>'
            },
            series: [{
                name: '정당별 의원현황',
                keys: ['name', 'y', 'color'],
                data: data,
                dataLabels: {
                    enabled: false,
                    format: '{point.label}',
                    style: {
                        textOutline: '3px contrast'
                    }
                },

                // Circular options
                center: ['50%', '88%'],
                size: '170%',
                startAngle: -100,
                endAngle: 100
            }],

            responsive: {
                rules: [{
                    condition: {
                        maxWidth: 600
                    },
                    chartOptions: {
                        series: [{
                            dataLabels: {
                                distance: -30
                            }
                        }],
                    }
                }]
            }
        });
    }

    function initTermNumberChart(){
        var category = statistics.termNumbers.map(function(item){
            return [
                item.term_count == 1 ? '초선' :item.term_count+'선',
            ]
        });

        var data = statistics.termNumbers.map(function(item){
            return [
                item.member_count,
            ]
        });

        Highcharts.chart('chart-term_number', {
            chart: {
                type: 'column'
            },
            title: {
                text: '',
            },
            xAxis: {
                categories: category,
                crosshair: true,
                accessibility: {
                    description: '당선횟수'
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: ''
                }
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },
            series: [
                {
                    name: '의원수',
                    data: data
                },
            ]
        });
    }

    function initGenderChart(){
        let totalCount = 0;
        statistics.gender.map(item => {
            totalCount += item.gender_count;
        });

        let data = statistics.gender.map(item => {
            return {
                name: item.gender,
                y: (item.gender_count / totalCount) * 100,
                color: item.gender == '남' ? '#7F9CF5' : '#F472B6',
            }
        });

        console.log(totalCount);

        Highcharts.chart('chart-gender', {
            chart: {
                type: 'pie'
            },
            title: {
                text: '',
            },
            tooltip: {
                valueSuffix: '%'
            },
            plotOptions: {
                series: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: [{
                        enabled: true,
                        distance: 20
                    }, {
                        enabled: true,
                        distance: -40,
                        format: '{point.percentage:.1f}%',
                        style: {
                            fontSize: '1.2em',
                            textOutline: 'none',
                            opacity: 0.7
                        },
                        filter: {
                            operator: '>',
                            property: 'percentage',
                            value: 10
                        }
                    }]
                }
            },
            series: [
                {
                    name: '비율',
                    colorByPoint: true,
                    data: data,
                }
            ]
        });
    }

    function initAgeChart(){
        var category = statistics.ageGroups.map(function(item){
            return [
                item.age_group,
            ]
        });

        var data = statistics.ageGroups.map(function(item){
            return [
                item.age_group_count,
            ]
        });

        Highcharts.chart('chart-age', {
            chart: {
                type: 'column'
            },
            title: {
                text: '',
            },
            xAxis: {
                categories: category,
                crosshair: true,
                accessibility: {
                    description: '연령'
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: ''
                }
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },
            series: [
                {
                    name: '의원수',
                    data: data
                },
            ]
        });
    }

    initParliamentChart();
    initTermNumberChart();
    initGenderChart();
    initAgeChart();

    </script>
</x-app-layout>
