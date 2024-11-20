<div id="piechart" style="width: 100%; height: 100%;"></div>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    google.charts.load('current', {
        'packages': ['corechart']
    });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {

        var data = google.visualization.arrayToDataTable([
            ['Loại', 'Số lượng'],
            ['Giỏi', 1100],
            ['Khá', 6500],
            ['Trung bình', 2604],
            ['Yếu', 1105]
        ]);

        var options = {
            title: 'Học lực',
            fontName: "Inter",
            colors: ['#01427A', '#01B3EF', '#E14177', '#6C6C6C']
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
    }
</script>