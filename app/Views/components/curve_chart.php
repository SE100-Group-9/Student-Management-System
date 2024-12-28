<div id="curve_chart" style="width: 100%; height: 600px"></div>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    google.charts.load('current', {
        'packages': ['corechart']
    });
    google.charts.setOnLoadCallback(drawChart);



    function drawChart() {
        // Chuyển dữ liệu từ PHP sang JavaScript
        var enrolledStudentData = <?= $enrolledStudentData ?>; // Đảm bảo dữ liệu được mã hóa JSON
        var warnedStudentData = <?= $warnedStudentData ?>; // Đảm bảo dữ liệu được mã hóa JSON

        console.log('Dữ liệu nhập học: ', enrolledStudentData);
        console.log('Dữ liệu cảnh báo: ', warnedStudentData);

        // Khởi tạo bảng dữ liệu
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Year'); // Cột năm học (chuỗi)
        data.addColumn('number', 'Nhập học'); // Cột số lượng nhập học (số)
        data.addColumn('number', 'Bị cảnh báo'); // Cột số lượng bị cảnh báo (số)

        enrolledStudentData.forEach(function(item) {
            var year = String(item.NamHoc); // Ép kiểu về chuỗi
            var enrolledCount = parseInt(item.SoLuongHS, 10) || 0; // Ép kiểu về số, nếu không phải số thì trả về 0

            var warnedCount = 0;
            warnedStudentData.forEach(function(warnedItem) {
                if (warnedItem.NamHoc === year) {
                    warnedCount = parseInt(warnedItem.SoLuongHS, 10) || 0; // Ép kiểu về số
                }
            });

            data.addRow([year, enrolledCount, warnedCount]); // Thêm hàng dữ liệu
        });

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