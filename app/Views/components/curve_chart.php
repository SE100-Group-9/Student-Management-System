<div id="curve_chart" style="width: 100%; height: 600px"></div>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    google.charts.load('current', {
        'packages': ['corechart']
    });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['Year', 'Nhập học', 'Bị cảnh báo'],
            ['2023-2024', 60, 12],
            ['2024-2025', 75, 11],
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