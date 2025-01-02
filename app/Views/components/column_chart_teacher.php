<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    google.charts.load("current", {
        packages: ['corechart']
    });
    google.charts.setOnLoadCallback(() => loadChartData('grade-10'));

    function drawChart(dataArray) {
        var data = google.visualization.arrayToDataTable(dataArray);

        var view = new google.visualization.DataView(data);
        view.setColumns([0, 1, {
                calc: "stringify",
                sourceColumn: 1,
                type: "string",
                role: "annotation"
            },
            2
        ]);

        var options = {
            title: "Học lực của học sinh",
            width: 600,
            height: 500,
            fontName: "Inter",
            bar: {
                groupWidth: "95%"
            },
            legend: {
                position: "none"
            },
        };

        var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values"));
        chart.draw(view, options);
    }

    // Lấy dữ liệu khi gọi các tab
    function loadChartData() {


        var data = [];
            data = [
                ["Học sinh", "Số lượng", {
                    role: "style"
                }],
                ["Giỏi", <?php echo $excellentCount; ?>, "#01427A"],
                ["Khá", <?php echo $goodCount; ?>, "#01B3EF"],
                ["Trung bình", <?php echo $averageCount; ?>, "#E14177"],
                ["Yếu", <?php echo $weakCount; ?>, "#6C6C6C"]
            ];

        drawChart(data); // Vẽ chart với dữ liệu mới
    }
</script>
<div id="columnchart_values" style="width: 100%; height: 500px;"></div>