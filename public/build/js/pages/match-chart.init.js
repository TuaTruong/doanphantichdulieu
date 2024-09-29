/*
Template Name: Velzon - Admin & Dashboard Template
Author: Themesbrand
Website: https://Themesbrand.com/
Contact: Themesbrand@gmail.com
File: Echarts Init Js File
*/

// get colors array from the string
function getChartColorsArray(chartId) {
    if (document.getElementById(chartId) !== null) {
        var colors = document.getElementById(chartId).getAttribute("data-colors");
        colors = JSON.parse(colors);
        return colors.map(function (value) {
            var newValue = value.replace(" ", "");
            if (newValue.indexOf(",") === -1) {
                var color = getComputedStyle(document.documentElement).getPropertyValue(newValue);
                if (color) return color;
                else return newValue;;
            } else {
                var val = value.split(',');
                if (val.length == 2) {
                    var rgbaColor = getComputedStyle(document.documentElement).getPropertyValue(val[0]);
                    rgbaColor = "rgba(" + rgbaColor + "," + val[1] + ")";
                    return rgbaColor;
                } else {
                    return newValue;
                }
            }
        });
    }
}

//  line chart
var chartLineColors = getChartColorsArray("chart-line");
if (chartLineColors) {
    var chartDom = document.getElementById('chart-line');
    var myChart = echarts.init(chartDom);
    var option;
    option = {
        grid: {
            left: '0%',
            right: '0%',
            bottom: '0%',
            top: '4%',
            containLabel: true
        },
        xAxis: {
            type: 'category',
            data: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            axisLine: {
                lineStyle: {
                    color: '#858d98'
                },
            },
        },
        yAxis: {
            type: 'value',
            axisLine: {
                lineStyle: {
                    color: '#858d98'
                },
            },
            splitLine: {
                lineStyle: {
                    color: "rgba(133, 141, 152, 0.1)"
                }
            }
        },
        series: [{
            data: [150, 230, 224, 218, 135, 147, 260],
            type: 'line'
        }],
        textStyle: {
            fontFamily: 'Poppins, sans-serif'
        },
        color: chartLineColors
    };

    if (option && typeof option === "object") {
        option && myChart.setOption(option);
    }
}

fetch('http://127.0.0.1:9090/get-match-statistic',{
    method : "POST",
    body: JSON.stringify({"match_id":1})
}).then(response => {
    if (!response.ok) {
        throw new Error('Network response was not ok');
    }
    return response.json(); // Read the response as JSON
})
    .then(data => {
        console.log(data); // Handle the data you receive
    })
    .catch(error => {
        console.error('There was a problem with the fetch operation:', error);
    });
// line stacked charts
var chartLineStackedColors = getChartColorsArray("chart-line-stacked");
if (chartLineStackedColors) {
    var chartDom = document.getElementById('chart-line-stacked');
    var myChart = echarts.init(chartDom);
    var option;

    option = {
        tooltip: {
            trigger: 'axis'
        },
        legend: {
            data: ['Email', 'Union Ads', 'Video Ads', 'Direct', 'Search Engine'],
            textStyle: { //The style of the legend text
                color: '#858d98',
            },
        },
        grid: {
            left: '0%',
            right: '0%',
            bottom: '0%',
            containLabel: true
        },
        toolbox: {
            feature: {
                saveAsImage: {}
            }
        },
        textStyle: {
            fontFamily: 'Poppins, sans-serif'
        },
        xAxis: {
            type: 'category',
            boundaryGap: false,
            data: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            axisLine: {
                lineStyle: {
                    color: '#858d98'
                },
            },
        },
        yAxis: {
            type: 'value',
            axisLine: {
                lineStyle: {
                    color: '#858d98'
                },
            },
            splitLine: {
                lineStyle: {
                    color: "rgba(133, 141, 152, 0.1)"
                }
            }
        },
        series: [{
            name: 'Email',
            type: 'line',
            stack: 'Total',
            data: [120, 132, 101, 134, 90, 230, 210],
        },
            {
                name: 'Union Ads',
                type: 'line',
                stack: 'Total',
                data: [220, 182, 191, 234, 290, 330, 310]
            },
            {
                name: 'Video Ads',
                type: 'line',
                stack: 'Total',
                data: [150, 232, 201, 154, 190, 330, 410]
            },
            {
                name: 'Direct',
                type: 'line',
                stack: 'Total',
                data: [320, 332, 301, 334, 390, 330, 320]
            },
            {
                name: 'Search Engine',
                type: 'line',
                stack: 'Total',
                data: [820, 932, 901, 934, 1290, 1330, 1320]
            }
        ],
        textStyle: {
            fontFamily: 'Poppins, sans-serif'
        },
        color: chartLineStackedColors
    };

    option && myChart.setOption(option);
}

