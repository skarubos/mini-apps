// ここでデータの開始日を指定
const specificDate = moment("2023-10-29").startOf('day');

// 最新データの日付を取得
// var now = moment().startOf('day');
// now.subtract(2, 'days');
let newestText =  document.getElementById('newest-date').textContent;
var now = moment(newestText, "YYYY-MM-DD HH:mm").startOf('day');
now.subtract(1, 'days');
const newestDay = now.clone();
// var now = latestDate();
// const newestDay = now.clone();


// DateRangePickerを適用
$('#dateSelector').daterangepicker({
    singleDatePicker: true,
    showDropdowns: true,
    autoApply: true,
    minDate: specificDate,
    maxDate: newestDay
}, function(start) {
    // 選択された日付の増減日数計算
    let dNum = start.diff(now, 'days');
    let newDate = dateSetting(now, dNum)

    fetchData(newDate);
});


// グラフの表示・デザイン指定
var mainChart;
var chrt = document.getElementById('mainChart').getContext('2d');
mainChart = new Chart(chrt, {
    data: {
        // labels: dataX,
        datasets: [{
            type: 'line',
            label: '温度',
            // data: dataT,
            backgroundColor: 'rgba(255,100,0,0)',
            borderColor: 'rgba(255,100,0,1)',
            borderWidth: 5,
            hoverBorderWidth: 10,
            lineTension: 0.3,
            yAxisID: 'y-axis-left',
            pointRadius: 0,
            hitRadius: 5,
        }, {
            type: 'line',
            label: '湿度',
            // data: dataH,
            backgroundColor: 'rgba(255,100,0,0)',
            borderColor: 'rgba(110,185,255,0.4)',
            borderWidth: 5,
            hoverBorderWidth: 10,
            lineTension: 0.3,
            yAxisID: 'y-axis-right',
            pointRadius: 0,
            hitRadius: 5,
        },
        {
            type: 'line',
            label: '外気温',
            // data: dataT_ref,
            backgroundColor: 'rgba(255,100,0,0)',
            borderColor: 'rgba(255,100,0,1)',
            borderWidth: 3,
            hoverBorderWidth: 10,
            borderDash: [5, 3],
            lineTension: 0.3,
            yAxisID: 'y-axis-left',
            pointRadius: 0,
            hitRadius: 5,
            spanGaps: true,
        }, {
            type: 'line',
            label: '外湿度',
            // data: dataH_ref,
            backgroundColor: 'rgba(255,100,0,0)',
            borderColor: 'rgba(110,185,255,0.4)',
            borderWidth: 3,
            hoverBorderWidth: 10,
            borderDash: [5, 3],
            lineTension: 0.3,
            yAxisID: 'y-axis-right',
            pointRadius: 0,
            hitRadius: 5,
            spanGaps: true,
        }, {
            type: 'bar',
            label: '日照度',
            // data: dataS,
            yAxisID: 'y-axis-right',
            categoryPercentage: 1,
            barPercentage: 1,
            backgroundColor: 'rgba(255,223,149,0.5)',
        }],
    },
    options: {
        responsive: true,
        plugins:{
            legend:{
                position:'bottom',
                labels:{
                    font:{
                        size :20
                    }
                }
            }
        },
        scales: {
            'y-axis-left': {
                position: 'left',
                title: {
                    display: true,
                    text: '[ ℃ ]',
                    font: {
                        size: 20,
                        weight: 'bold'
                    }
                },
                ticks: {
                    font: {
                        size: 15,
                        weight: 'bold'
                    }
                },
                max: 40,
                min: -10,
            },
            'y-axis-right': {
                position: 'right',
                title: {
                    display: true,
                    text: '[ % ]',
                    font: {
                        size: 20,
                        weight: 'bold'
                    }
                },
                ticks: {
                    font: {
                        size: 15,
                        weight: 'bold'
                    }
                },
                max: 100,
                min: 0,
                grid: {
                    display: false
                }
            },
            x: {
                ticks: {
                    font: {
                        size: 12,
                        weight: 'normal'
                    },
                    autoSkip: false,
                    callback: function(value, index) {
                        return index % 6 === 5 ? this.getLabelForValue(value) : '';
                    }
                },
                
            },
        },
    },
});

// データを取得し、グラフに適用
var iniDay = dateSetting(now, 0);
fetchData(iniDay);



// 前の日に戻るボタンのクリックイベント
$("#prev-button").click(function() {
    // 日付を1日戻す
    let newDate = dateSetting(now, -1)

    fetchData(newDate);
});

// 次の日に進むボタンのクリックイベント
$("#next-button").click(function() {
    // 日付を1日進める
    let newDate = dateSetting(now, +1)

    fetchData(newDate);
});




// 日付を指定する関数：引数(now,増減日数)、先頭を0で埋めた年月日をオブジェクトで返す
function dateSetting(now, dNum) {
    now.add(dNum, 'days');
    let year = now.year();
    let month = now.month() + 1;
    let date = now.date();
    console.log("新しい日付: " + now.format("YYYY-MM-DD"));
    console.log("newestDay: " + newestDay.format("YYYY-MM-DD"));

    // 前後ボタンの表記と操作可能かを切替
    if (dNum <= -1) {
        $("#next-button").text("▶");
        $("#next-button").prop("disabled", false);

        // データの開始日以降に制限
        if (now.isSameOrBefore(specificDate)) {
            $("#prev-button").text("ll");
            $("#prev-button").prop("disabled", true);
        }
    } else if (dNum => 1) {
        $("#prev-button").text("◀");
        $("#prev-button").prop("disabled", false);

        // データのある日までに制限
        if (now.isSameOrAfter(newestDay)) {
            $("#next-button").text("ll");
            $("#next-button").prop("disabled", true);
        }
    }

    // 新しい年、月、日を表示
    $("#theY").text(year);
    $("#theM").text(month);
    $("#theD").text(date);
    // DateRangePickerに適用
    $('#dateSelector').data('daterangepicker').setStartDate(now);
    $('#dateSelector').data('daterangepicker').setEndDate(now);

    // 文字列にして、先頭を0で埋める
    const newDate = {
        yyyy: String(year),
        mm: String(month).padStart(2, '0'),
        dd: String(date).padStart(2, '0')
    } 
    return newDate;
}

// データを取得し、グラフに適用する関数
async function fetchData(date) {
    const response = await fetch(`data_day.php?year=${date.yyyy}&month=${date.mm}&date=${date.dd}`);
    const data = await response.json();

    let dataX = [], dataT = [], dataH = [], dataT_ref = [], dataH_ref = [], dataS = [];

    data['ref'].forEach(({time, temperature, humidity, sunlight}) => {
        dataX.push(time);
        dataT_ref.push(temperature !== null ? Number(temperature) : null);
        dataH_ref.push(humidity !== null ? Number(humidity) : null);
        dataS.push(Number(sunlight));
    });
    data['sb'].forEach(({temp_A, hum_A}) => {
        dataT.push(temp_A !== null ? Number(temp_A) : null);
        dataH.push(hum_A !== null ? Number(hum_A) : null);
    });

    // 温度の最大値と最小値を取得
    let maxT = Math.max(...dataT.filter(t => t !== null));
    let minT = Math.min(...dataT.filter(t => t !== null));

    console.log(maxT, minT);
    console.log(dataT);

    // データセットを更新
    mainChart.data.labels = dataX;
    mainChart.data.datasets[0].data = dataT;
    mainChart.data.datasets[0].pointStyle = dataT.map((value) => {
        return (value === maxT || value === minT) ? 'crossRot' : 'circle';
    });
    mainChart.data.datasets[0].pointRadius = dataT.map((value) => {
        return (value === maxT || value === minT) ? 10 : 0;
    });
    mainChart.data.datasets[1].data = dataH;
    mainChart.data.datasets[2].data = dataT_ref;
    mainChart.data.datasets[3].data = dataH_ref;
    mainChart.data.datasets[4].data = dataS;

    mainChart.update();
}