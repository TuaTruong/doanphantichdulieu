/*
Template Name: Velzon - Admin & Dashboard Template
Author: Themesbrand
Website: https://Themesbrand.com/
Contact: Themesbrand@gmail.com
File: Echarts Init Js File
*/

function getQueryParam(param) {
    const urlParams = window.location.search.substring(1);
    const paramsArray = urlParams.split('&');

    for (let paramPair of paramsArray) {
        const [key, value] = paramPair.split('=');
        if (key === param) {
            return decodeURIComponent(value);
        }
    }
    return null; // Return null if the parameter is not found
}

document.addEventListener("DOMContentLoaded",function (){
    document.querySelector('button.watch-minute-split').addEventListener('click',function (){
        let minute = document.querySelector('input.minuteSplit').value;
        let url = new URL(window.location.href);
        url.searchParams.set('minuteSplit', minute);
        window.location.href = url;
    })
})


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
const minuteSplit = getQueryParam('minuteSplit') ?? 1;
fetch('/get-match-statistic',{
    method : "POST",
    headers: {
        "Content-Type": "application/json"
    },
    body: JSON.stringify({"matchId":document.querySelector(".matchId").value, "minuteSplit": minuteSplit})
}).then(response => {
    if (!response.ok) {
        throw new Error('Network response was not ok');
    }
    return response.json(); // Read the response as JSON
})
    .then(data => {
        var chartLineIndicesStatistic = getChartColorsArray("chart-line-indices-statistics");
        if (chartLineIndicesStatistic) {
            var chartDom = document.getElementById('chart-line-indices-statistics');
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
            };

            option && myChart.setOption(option);
        }

        var chartLineDiffStatistic = getChartColorsArray("chart-line-differences-statistics");
        if (chartLineDiffStatistic) {
            var chartDom = document.getElementById('chart-line-differences-statistics');
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
                    name: 'So sánh',
                    type: 'line',
                    stack: 'Total',
                    data: data["differences"],
                },
                ],
                textStyle: {
                    fontFamily: 'Poppins, sans-serif'
                },
            };

            option && myChart.setOption(option);
        }
    })
    .catch(error => {
        console.error('There was a problem with the fetch operation:', error);
    });
// line stacked charts


