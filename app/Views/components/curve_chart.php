<div id="curve_chart" style="width: 100%; height: 600px"></div>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    google.charts.load('current', {
        'packages': ['corechart']
    });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['Year', 'Nhập học', 'Bảo lưu', 'Bị cảnh báo'],
            ['2020', 1000, 400, 500],
            ['2021', 1170, 460, 650],
            ['2022', 660, 1120, 600],
            ['2023', 1030, 540, 265],
            ['2024', 900, 840, 650]
        ]);

        var options = {
            title: 'Học sinh',
            curveType: 'function',
            legend: {
                position: 'bottom'
            },
            colors: ['#01B3EF', '#01427A', 'E14177']
        };

        var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

        chart.draw(data, options);
    }
</script>