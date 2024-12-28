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

        // Chuyển dữ liệu từ PHP sang JavaScript
        var HanhKiemKhoi10 = <?= $HanhKiemKhoi10 ?>;
        var HanhKiemKhoi11 = <?= $HanhKiemKhoi11 ?>;
        var HanhKiemKhoi12 = <?= $HanhKiemKhoi12 ?>;

        console.log('Dữ liệu khối 10: ', HanhKiemKhoi10);
        console.log('Dữ liệu khối 11: ', HanhKiemKhoi11);
        console.log('Dữ liệu khối 12: ', HanhKiemKhoi12);

        var data = [];
        if (tabName === 'grade-10') {
            data = [
                ["Học sinh", "Số lượng", {
                    role: "style"
                }],
                ["Tốt", HanhKiemKhoi10['Tốt'], "#01427A"],
                ["Khá", HanhKiemKhoi10['Khá'], "#01B3EF"],
                ["Trung bình", HanhKiemKhoi10['Trung bình'], "#E14177"],
                ["Yếu", HanhKiemKhoi10['Yếu'], "#6C6C6C"]
            ];
        } else if (tabName === 'grade-11') {
            data = [
                ["Học sinh", "Số lượng", {
                    role: "style"
                }],
                ["Tốt", HanhKiemKhoi11['Tốt'], "#01427A"],
                ["Khá", HanhKiemKhoi11['Khá'], "#01B3EF"],
                ["Trung bình", HanhKiemKhoi11['Trung bình'], "#E14177"],
                ["Yếu", HanhKiemKhoi11['Yếu'], "#6C6C6C"]
            ];
        } else if (tabName === 'grade-12') {
            data = [
                ["Học sinh", "Số lượng", {
                    role: "style"
                }],
                ["Tốt", HanhKiemKhoi12['Tốt'], "#01427A"],
                ["Khá", HanhKiemKhoi12['Khá'], "#01B3EF"],
                ["Trung bình", HanhKiemKhoi12['Trung bình'], "#E14177"],
                ["Yếu", HanhKiemKhoi12['Yếu'], "#6C6C6C"]
            ];
        }

        drawChart(data); // Vẽ chart với dữ liệu mới
    }
</script>
<div id="columnchart_values" style="width: 100%; height: 500px;"></div>