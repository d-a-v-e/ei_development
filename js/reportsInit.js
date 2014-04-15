/*
 *  Document   : compCharts.js
 *  Author     : pixelcave
 *  Description: Custom javascript code used in Charts page
 */

var Reporting = function() {

    return {
        init: function() {
            
            /*
             * Flot 0.8.2 Jquery plugin is used for charts
             *
             * For more examples or getting extra plugins you can check http://www.flotcharts.org/
             * Plugins included in this template: pie, resize, stack, time
             */

            // Get the elements where we will attach the charts
            var chartClassic = $('#chart-classic');
            var chartStacked = $('#chart-stacked');
            var chartLive = $('#chart-live');
            var chartBars = $('#chart-bars');
            var chartPie = $('#chart-pie');

            // Random data for the charts
            var dataEarnings = [[1, 1560], [2, 1650], [3, 1320], [4, 1950], [5, 1800], [6, 2400], [7, 2100], [8, 2550], [9, 3300], [10, 3900], [11, 4200], [12, 4500]];
            var dataSales = [[1, 500], [2, 420], [3, 480], [4, 350], [5, 600], [6, 850], [7, 1100], [8, 950], [9, 1220], [10, 1300], [11, 1500], [12, 1700]];
            var dataSales2 = [[1, 150], [3, 200], [5, 250], [7, 300], [9, 420], [11, 350], [12, 450]];

            // Array with month labels used in Classic and Stacked chart
            var chartMonths = [[1, 'Jan'], [2, 'Feb'], [3, 'Mar'], [4, 'Apr'], [5, 'May'], [6, 'Jun'], [7, 'Jul'], [8, 'Aug'], [9, 'Sep'], [10, 'Oct'], [11, 'Nov'], [12, 'Dec']];

            // Classic Chart
            $.plot(chartClassic,
                [
                    {
                        label: 'Earnings',
                        data: dataEarnings,
                        lines: {show: true, fill: true, fillColor: {colors: [{opacity: 0.25}, {opacity: 0.25}]}},
                        points: {show: true, radius: 6}
                    },
                    {
                        label: 'Sales',
                        data: dataSales,
                        lines: {show: true, fill: true, fillColor: {colors: [{opacity: 0.2}, {opacity: 0.2}]}},
                        points: {show: true, radius: 6}
                    },
                    {
                        label: 'Sales 2',
                        data: dataSales2,
                        lines: {show: true, fill: true, fillColor: {colors: [{opacity: 0.15}, {opacity: 0.15}]}},
                        points: {show: true, radius: 6}
                    }
                ],
                {
                    colors: ['#3498db', '#333333', '#ffffff'],
                    legend: {show: true, position: 'nw', margin: [15, 10]},
                    grid: {borderWidth: 0, hoverable: true, clickable: true},
                    yaxis: {ticks: 4, tickColor: '#eeeeee'},
                    xaxis: {ticks: chartMonths, tickColor: '#ffffff'}
                }
            );

            // Creating and attaching a tooltip to the classic chart
            var previousPoint = null, ttlabel = null;
            chartClassic.bind('plothover', function(event, pos, item) {

                if (item) {
                    if (previousPoint !== item.dataIndex) {
                        previousPoint = item.dataIndex;

                        $('#chart-tooltip').remove();
                        var x = item.datapoint[0], y = item.datapoint[1];

                        if (item.seriesIndex === 1) {
                            ttlabel = '<strong>' + y + '</strong> sales';
                        } else {
                            ttlabel = '$ <strong>' + y + '</strong>';
                        }

                        $('<div id="chart-tooltip" class="chart-tooltip">' + ttlabel + '</div>')
                            .css({top: item.pageY - 45, left: item.pageX + 5}).appendTo("body").show();
                    }
                }
                else {
                    $('#chart-tooltip').remove();
                    previousPoint = null;
                }
            });

            

            // Pie Chart
            $.plot(chartPie,
                [
                    {label: 'Support', data: 20},
                    {label: 'Earnings', data: 45},
                    {label: 'Sales', data: 35}
                ],
                {
                    colors: ['#333333', '#1abc9c', '#16a085'],
                    legend: {show: false},
                    series: {
                        pie: {
                            show: true,
                            radius: 1,
                            label: {
                                show: true,
                                radius: 3 / 4,
                                formatter: function(label, pieSeries) {
                                    return '<div class="chart-pie-label">' + label + '<br>' + Math.round(pieSeries.percent) + '%</div>';
                                },
                                background: {opacity: 0.75, color: '#000000'}
                            }
                        }
                    }
                }
            );

        }
    };
}();