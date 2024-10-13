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

fetch('http://127.0.0.1:8001/get-match-statistic',{
    method : "POST",
    headers: {
        "Content-Type": "application/json"
    },
    body: JSON.stringify({"matchId":document.querySelector(".matchId").value})
}).then(response => {
    if (!response.ok) {
        throw new Error('Network response was not ok');
    }
    return response.json(); // Read the response as JSON
})
    .then(data => {
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
                    data: data["minutesArray"],
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
                    name: 'Tài xỉu cả trận',
                    type: 'line',
                    stack: 'Total',
                    data: data["cornerOddArrayFullTime"],
                },
                    {
                        name: 'Tài xiu hiệp 1',
                        type: 'line',
                        stack: 'Total',
                        data: data["cornerOddHalf1"]
                    },
                    {
                        name: `Tổng chỉ số ${data["team_away"]}`,
                        type: 'line',
                        stack: 'Total',
                        data: data["totalStatisticAway"]
                    },
                    {
                        name: `Tổng chỉ số ${data["team_home"]}`,
                        type: 'line',
                        stack: 'Total',
                        data: data["totalStatisticHome"]
                    },
                    {
                        name: `Tổng chỉ số 2 đội`,
                        type: 'line',
                        stack: 'Total',
                        data: data["totalStatisticBoth"]
                    }
                ],
                textStyle: {
                    fontFamily: 'Poppins, sans-serif'
                },
                color: chartLineStackedColors
            };

            option && myChart.setOption(option);
        }
    })
    .catch(error => {
        console.error('There was a problem with the fetch operation:', error);
    });
// line stacked charts


