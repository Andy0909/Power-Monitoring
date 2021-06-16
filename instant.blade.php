(instant.blade.php)
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>智慧電表</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--<link rel="stylesheet" type="text/css" media="screen" href="main.css">-->
    <!--<script src="main.js"></script>-->
</head>
<body>
<input type = "button" value = "即時資訊" onclick = "location.href = '/instant information'">
<input type = "button" value = "電價資訊" onclick = "location.href = '/price information'">
<input type = "button" value = "歷史紀錄" onclick = "location.href = '/record'">
</form>
    <H1><font size="20", face="標楷體">即時資訊</font></H1>
    <p id="demo" style="font-size:50px;position:right;"></p>
    <table id="table1" style="font-size:20px; line-height:40px; #cccccc black; opacity:0.9;" cellpadding="60"  >
    <table id="table2" style="font-size:20px; line-height:40px; #cccccc black; opacity:0.9;" cellpadding="60"  >
    <table id="table3" style="font-size:20px; line-height:40px; #cccccc black; opacity:0.9;" cellpadding="60"  >
    <table id="table4" style="font-size:20px; line-height:80px; #cccccc black; opacity:0.9;" cellpadding="60"  >
<body
        
    style = "background-color:#FCFCFC; background-repeat:no-repeat;background-attachment:fixed;background-position:right 100% bottom 30%; background-size: 2000px 2000px;">
              
</body>
<div style = "position: relative; top: 100px; left: 0px; height:40vh; width:40vw; margin: 0 ">
<canvas id="myChart" ></canvas>
</div>

<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.js"></script>
<script src="https://playground.abysscorp.org/chartjs/livecharts/dist/Chart.min.js"></script>
<script src="https://cdn.plot.ly/plotly-latest.min.js"></script>

<script>
setInterval(function() {                                 //設定更新資料之間隔時間
    $(document).ready(function() {
        $.ajax({
            url: "http://35.231.251.115/value",          //從url抓取資料
            method: "GET",
            success: function(value) {
                value = JSON.parse(value);
                var v = new Array();
                var i = new Array();
                var dates = new Array();
                for(var a in value) 
                {
                    v.push(value[a].v);                      //將資料存到陣列
                    i.push(value[a].i);                      //將資料存到陣列
                    dates.push(value[a].updated_at);         //將資料存到陣列
                }

                //以下為電壓電流折線圖繪圖
                var chartdata = {
                    labels:dates,
                    datasets: [{
                            label: 'voltage',
                            yAxisID: 'A',
                            backgroundColor: 'rgba(255, 0, 0, 0.75)',
                            borderColor: 'rgba(255, 0, 0, 0.75)',
                            borderWidth: 2,
                            pointRadius:0,
                            hoverBackgroundColor: 'rgba(255, 0, 0, 0.75)',
                            hoverBorderColor: 'rgba(200, 200, 200, 1)',
                            fill: false,
                            data: v,
                            
                        },
                        {
                            label: 'current',
                            yAxisID: 'B',
                            backgroundColor: 'rgba(30, 144, 255, 0.75)',
                            borderColor: 'rgba(30, 144, 255, 0.75)',
                            borderWidth: 2,
                            pointRadius:0,
                            hoverBackgroundColor: 'rgba(100, 100, 100, 1)',
                            hoverBorderColor: 'rgba(30, 144, 255, 1)',
                            fill: false,
                            data: i,
                            
                        },

                    ]
                };

                var options1 = {
                    animation: false,
                    scales: {
                        yAxes: [{
                            id: 'A',
                            position: 'left',
                            display: false,
                            ticks: {
                                beginAtZero: true,
                            }
                        }, {
                            id: 'B',
                            position: 'left',
                            display: true,
                            ticks: {
                                beginAtZero: true,
                                min: -200,
                                max: 200
                            }
                        }]
                    },
                    
                    layout: {
                        padding: {
                            left: 0,
                            right: 0,
                            top: 0,
                            bottom: 10
                        }
                    }
                }
                
                var ctx = $("#myChart");
                var barGraph = new Chart(ctx, {
                    type: 'line',
                    data: chartdata,
                    options: options1                
                });
            },
            error: function(value) {
                console.log(value);
            }
        });
    });

},10);
