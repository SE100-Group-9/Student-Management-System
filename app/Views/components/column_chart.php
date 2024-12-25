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
            title: "Hạnh kiểm",
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
    function loadChartData(tabName) {
        var data = [];
        if (tabName === 'grade-10') {
            data = [
                ["Học sinh", "Số lượng", {
                    role: "style"
                }],
                ["Xuất sắc", 1000, "#01427A"],
                ["Giỏi", 600, "#01B3EF"],
                ["Yếu", 200, "#E14177"]
            ];
        } else if (tabName === 'grade-11') {
            data = [
                ["Học sinh", "Số lượng", {
                    role: "style"
                }],
                ["Xuất sắc", 300, "#01427A"],
                ["Giỏi", 900, "#01B3EF"],
                ["Yếu", 100, "#E14177"]
            ];
        } else if (tabName === 'grade-12') {
            data = [
                ["Học sinh", "Số lượng", {
                    role: "style"
                }],
                ["Xuất sắc", 100, "#01427A"],
                ["Giỏi", 200, "#01B3EF"],
                ["Yếu", 800, "#E14177"]
            ];
        }

        drawChart(data); // Vẽ chart với dữ liệu mới
    }
</script>
<div id="columnchart_values" style="width: 100%; height: 500px;"></div>