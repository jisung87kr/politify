<x-app-layout>
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
    function initParliamentChart(){
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
                name: 'Representatives',
                keys: ['name', 'y', 'color', 'label'],
                data: [
                    ['The Left', 39, '#CC0099', 'DIE LINKE'],
                    ['Social Democratic Party', 206, '#EE0011', 'SPD'],
                    ['Alliance 90/The Greens', 118, '#448833', 'GRÜNE'],
                    ['Free Democratic Party', 92, '#FFCC00', 'FDP'],
                    ['Christian Democratic Union', 152, '#000000', 'CDU'],
                    ['Christian Social Union in Bavaria', 45, '#3366CC', 'CSU'],
                    ['Alternative for Germany', 83, '#3399FF', 'AfD'],
                    ['South Schleswig Voters\' Association', 1, '#000099', 'SSW']
                ],
                dataLabels: {
                    enabled: true,
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
        Highcharts.chart('chart-term_number', {
            chart: {
                type: 'column'
            },
            title: {
                text: '',
            },
            xAxis: {
                categories: ['USA', 'China', 'Brazil', 'EU', 'Argentina', 'India'],
                crosshair: true,
                accessibility: {
                    description: 'Countries'
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: '1000 metric tons (MT)'
                }
            },
            tooltip: {
                valueSuffix: ' (1000 MT)'
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },
            series: [
                {
                    name: 'Corn',
                    data: [387749, 280000, 129000, 64300, 54000, 34300]
                },
            ]
        });
    }

    function initGenderChart(){
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
                    name: 'Percentage',
                    colorByPoint: true,
                    data: [
                        {
                            name: 'Water',
                            y: 55.02
                        },
                        {
                            name: 'Fat',
                            sliced: true,
                            selected: true,
                            y: 26.71
                        },
                        {
                            name: 'Carbohydrates',
                            y: 1.09
                        },
                        {
                            name: 'Protein',
                            y: 15.5
                        },
                        {
                            name: 'Ash',
                            y: 1.68
                        }
                    ]
                }
            ]
        });
    }

    function initAgeChart(){
        Highcharts.chart('chart-age', {
            chart: {
                type: 'column'
            },
            title: {
                text: '',
            },
            xAxis: {
                categories: ['USA', 'China', 'Brazil', 'EU', 'Argentina', 'India'],
                crosshair: true,
                accessibility: {
                    description: 'Countries'
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: '1000 metric tons (MT)'
                }
            },
            tooltip: {
                valueSuffix: ' (1000 MT)'
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },
            series: [
                {
                    name: 'Corn',
                    data: [387749, 280000, 129000, 64300, 54000, 34300]
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
