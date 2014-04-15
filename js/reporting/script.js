var BarCharts = function() {

    return {
        //jsonurl is passed in from php call to this script
        init: function(id) {

            var jsonexternalurl = "http://www.biota-labs.com/ei/sales/ei_return_sales_outlet.php?clientid=1&campaignid=" + id;
            var dataJson;
            var venueTicks = new Array();
            var volumes = new Array();
            var eventvenues = new Array();
            var sortedEventVenues = new Array();
            var outlets = new Array();
            var sortedOutlets = new Array();
            var values = new Array();
            var mySeries = new Array();
            var ticksArray = new Array();



            //get data from json            
            $.ajax({
                type:'GET',
                dataType:'json',
                url: jsonexternalurl,
                success: onDataReceived
            });

            function onDataReceived(series){
                dataJson = series;
                sortData();
                getOutlets();
                getVenues();
                getShitDone();
                plotTheChart();
            }

            function sortData(){
                console.log("split up data");
                for (var i = 0; i < dataJson.length; i++) {
                    volumes[i] = dataJson[i]["volume"];
                    eventvenues[i] = dataJson[i]["eventvenue"];
                    outlets[i] = dataJson[i]["outlet"];
                    values[i] = dataJson[i]["value"];
                };
            }

            function getVenues(){
                var currentVenue = eventvenues[0];
                sortedEventVenues[0] = eventvenues[0];
                venueTicksTemp = [0,eventvenues[0]];
                venueTicks.push(venueTicksTemp);
                var count = 1;
                for (var i = 0; i < eventvenues.length; i++) {
                    if(currentVenue !== eventvenues[i]){
                        sortedEventVenues.push(eventvenues[i]);
                        currentVenue = eventvenues[i];
                        venueTicksTemp = [count,currentVenue];
                        venueTicks.push(venueTicksTemp);
                        count++;
                    }
                }
            }

            function getOutlets(){
                console.log("find number of outlets");
                sortedOutlets = outlets.filter(function(itm,i,outlets){
                    return i==outlets.indexOf(itm);
                });
            }



            function getShitDone(){
                var myData = [];//data object inside series
                var myLabel;//label for each series (outlet)
                var order;
                var seriesObject = {};
                var started = false;

                for (var i = 0; i < sortedOutlets.length; i++) {
                    started = true;
                    myData = [];
                    myLabel = sortedOutlets[i];
                    order = 0;

                    for (var j = 0; j < dataJson.length; j++) {
                         if (sortedOutlets[i] === dataJson[j]["outlet"]){
                            var tempData = [order,dataJson[j]["volume"]];
                            myData.push(tempData);
                            order++;
                         };
                    };

                    seriesObject = {data:myData,label:myLabel};
                    mySeries.push(seriesObject);
                };
                console.log(venueTicks);
                console.log(mySeries);
            }

            function plotTheChart(){
                var fontOptions = {
                    size: 9,
                    lineHeight: 10,
                    style: "italic",
                    family: "sans-serif",
                    color: "#545454"
                }
                var options = {
                    xaxis: {
                       ticks: venueTicks, tickColor: '#ffffff',
                       font:fontOptions,
                    },
                    series: {
                        bars: {
                            show: true,
                            barWidth: .6,
                            align: "center"
                        },
                        stack: true
                    }
                };
                $.plot("#bar", mySeries, options);
            }

        }
    };
}();


 var LineCharts = function() {

    return {
        //jsonurl is passed in from php call to this script
        init: function(id) {

            var chartClassic = $('#line');
            var outletSalesJsonURL = "http://www.biota-labs.com/ei/sales/ei_return_sales_outlet_month.php?clientid=1&campaignid=" + id;
            var totalSalesJsonURL = "http://www.biota-labs.com/ei/sales/ei_return_sales_total_month.php?clientid=1&campaignid=" + id;

            var months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
            var totalSalesJson;
            var outletSalesJson;
            var dateTicks = [];
            var salesSeries = [];
            var outlets = [];
            var sortedOutlets = [];
            var allSeries = [];

            $.ajax({
                url: totalSalesJsonURL,
                type: "GET",
                dataType: "json",
                success: onDataReceivedTotal
            });

        function onDataReceivedTotal(totalSalesData) {
            totalSalesJson = totalSalesData;
            createTotalSalesAndTicks();
            nextAjaxCall();
        }


        function createTotalSalesAndTicks(){
            for (var i = 0; i < totalSalesJson.length; i++) {
                var mySeriesObject = [i+1,parseInt(totalSalesJson[i]["volume"])];
                salesSeries.push(mySeriesObject);
                var monthPlusYear = (months[totalSalesJson[i]["SaleMonth"]-1] + "," + totalSalesJson[i]["SaleYear"]);
                var dateTicksObject = [i+1,monthPlusYear];
                dateTicks.push(dateTicksObject);
            };

            var salesSeriesObject = {data:salesSeries,label:"Total"};
            allSeries.push(salesSeriesObject);
        }

        function nextAjaxCall(){
            $.ajax({
                url: outletSalesJsonURL,
                type: "GET",
                dataType: "json",
                success: onDataReceivedOutlet
            });

            function onDataReceivedOutlet(outletData){
                outletSalesJson = outletData;
                for (var i = 0; i < outletSalesJson.length; i++) {
                    outlets.push(outletSalesJson[i]["outlet"]); 
                };
                getOutlets();
                createOutletsSeries();

            }
        }



            function getOutlets(){
                sortedOutlets = outlets.filter(function(itm,i,outlets){
                    return i==outlets.indexOf(itm);
                });
            }



            function createOutletsSeries(){

                var outletDataObject = [];//data object inside series
                var myLabel;//label for each series (outlet)
                var order;
                var seriesObject = {};
                var started = false;

                for (var i = 0; i < sortedOutlets.length; i++) {
                    started = true;
                    outletDataObject = [];
                    myLabel = sortedOutlets[i];
                    order = 1;

                    for (var j = 0; j < outletSalesJson.length; j++) {
                         if (sortedOutlets[i] === outletSalesJson[j]["outlet"]){
                            var tempData = [order,parseInt(outletSalesJson[j]["volume"])];
                            outletDataObject.push(tempData);
                            order++;
                         };
                    };

                    seriesObject = {data:outletDataObject,label:myLabel};
                    allSeries.push(seriesObject);
                };
                buildTable();
            }

        function buildTable(){

            var options = 
                    {
                       // colors: ['#3498db', '#333333'],
                        legend: {show: true, position: 'nw', margin: [15, 10]},
                        grid: {borderWidth: 0, hoverable: true, clickable: true},
                        yaxis: {ticks: 4, tickColor: '#eeeeee'},
                        xaxis: {ticks: dateTicks, tickColor: '#ffffff'}
                    };

            var allSeriesWithOptions = [];
            for (var i = 0; i < allSeries.length; i++) {
                var seriesObjectWithOptions = {
                        label: allSeries[i].label,
                        data: allSeries[i].data,
                        lines: {show: true, fill: false},//, fillColor: {colors: [{opacity: 0.25}, {opacity: 0.25}]}},
                        points: {show: true, radius: 3}
                };
                allSeriesWithOptions.push(seriesObjectWithOptions);
            };
            console.log(allSeriesWithOptions);
            console.log(options);

           $.plot(chartClassic,allSeriesWithOptions,options);
        }

            // Creating and attaching a tooltip to the classic chart
            var previousPoint = null, ttlabel = null;
            chartClassic.bind('plothover', function(event, pos, item) {

                if (item) {
                    if (previousPoint !== item.dataIndex) {
                        previousPoint = item.dataIndex;

                        $('#chart-tooltip').remove();
                        var y = item.datapoint[1];
                        var name = item.series.label;
                        ttlabel = '<strong>' + y + '</strong>';


                        $('<div id="chart-tooltip" class="chart-tooltip">' + ttlabel + '<br>' + name +'</div>')
                            .css({top: item.pageY - 45, left: item.pageX + 5}).appendTo("body").show();
                    }
                }
                else {
                    $('#chart-tooltip').remove();
                    previousPoint = null;
                }
            });
    }

};
}();
var GenderCharts = function() {

    return {
        //jsonurl will be passed in from php call to this script
        init: function(id) {

            var jsonGenderStackedBarURL = "http://www.biota-labs.com/ei/sales/ei_return_sales_gender_country.php?clientid=1&campaignid=" + id;
            var jsonGenderPieChartURL = "http://www.biota-labs.com/ei/sales/ei_return_sales_gender_campaign.php?clientid=1&campaignid=" + id;
            var barData;
            var barSeries = [];
            var genderKey = {"M": "Male", "F": "Female", "NA": "Unknown"};


            var customerCounts = [];
            var countries = [];
            var countryTicks = [];
            var genders = [];



            //get data from json            
            $.ajax({
                type:'GET',
                dataType:'json',
                url: jsonGenderStackedBarURL,
                success: onDataReceived
            });

            function onDataReceived(stackedBarJsonData){
                barData = stackedBarJsonData;
                sortData();
                getShitDone();
                plotTheChart();
            }

            function sortData(){
                console.log("get countries and sort them");
                var unsortedCountries = [];
                var unsortedGenders = [];
                for (var i = 0; i < barData.length; i++) {
                    unsortedCountries[i] = barData[i]["country"];
                    unsortedGenders[i] = barData[i]["gender"];
                };
                countries = unsortedCountries.filter(function(itm,i,unsortedCountries){
                    return i==unsortedCountries.indexOf(itm);
                });
                genders = unsortedGenders.filter(function(itm,i,unsortedGenders){
                    return i==unsortedGenders.indexOf(itm);
                });
                for (var i = 0; i < countries.length; i++) {
                    var countryTemp = [i,countries[i]];
                    countryTicks.push(countryTemp);
                };

            }

            function getShitDone(){
                var myData = [];//data object inside series
                var myLabel;//label for each series (outlet)
                var order;
                var seriesObject = {};

                for (var i = 0; i < genders.length; i++) {
                    myData = [];
                    myLabel = genderKey[genders[i]];
                    order = 0;
                    for (var j = 0; j < barData.length; j++) {
                       if (genders[i] === barData[j]["gender"]){
                        var tempData = [order,parseInt(barData[j]["customers"])];
                        myData.push(tempData);
                        order++;
                    };
                };

                seriesObject = {data:myData,label:myLabel};
                barSeries.push(seriesObject);
            };
            console.log(barSeries);
        }

        function plotTheChart(){
            var fontOptions = {
                size: 9,
                lineHeight: 10,
                style: "italic",
                family: "sans-serif",
                color: "#545454"
            }
            var options = {
                xaxis: {
                 ticks: countryTicks, tickColor: '#ffffff',
                 font:fontOptions,
             },
             series: {
                bars: {
                    show: true,
                    barWidth: .6,
                    align: "center"
                },
                stack: true
            }
        };

        $.plot("#gender-stacked-chart", barSeries, options);
    }

            //following is for the pie chart...
            var pieChartSeries = [];
            var pieData;
            $.ajax({
                type:'GET',
                dataType:'json',
                url: jsonGenderPieChartURL,
                success: onDataReceivedPie
            });

            function onDataReceivedPie(pieJson){

                pieData = pieJson;

                for (var i = 0; i < pieData.length; i++) {
                    var seriesObjectPieTemp = {label: genderKey[pieData[i]["gender"]],data: pieData[i]["customers"]};
                    pieChartSeries.push(seriesObjectPieTemp);
                };
                console.log(pieChartSeries);
                buildPieChart();
            }
            function buildPieChart(){

                $.plot('#gender-pie-chart', pieChartSeries,
                     {
                    //colors: ['#333333', '#1abc9c', '#16a085'],
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

}
};
}();