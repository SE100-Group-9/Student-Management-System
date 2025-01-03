<link rel="stylesheet" href="<?= base_url(relativePath: 'assets/css/style.css') ?>">

<div class="statics-conduct">
    <div class="conduct-heading">
        <?= view('components/heading') ?>
    </div>
    <div class="body">
        <div class="body-left">
            <?= view('components/sidebar_director') ?>
        </div>
        <div class="body-right">
            Trung tâm / Thống kê / Hạnh kiểm
            <form method="GET" action="/sms/public/director/statics/conduct" id="form">
                <div class=" tool-search">
                <div class="dropdown-edit">
                    <?= view('components/dropdown', [
                        'options' => $yearList ?? [],
                        'dropdown_id' => 'year-dropdown',
                        'name' => 'year',
                        'selected_text' => 'Chọn năm học',
                        'value' => $selectedYear ?? ''
                    ]) ?>
                </div>
                <div class="dropdown-edit">
                    <?= view('components/dropdown', [
                        'options' => ['Học kỳ 1', 'Học kỳ 2'],
                        'dropdown_id' => 'semester-dropdown',
                        'name' => 'semester',
                        'selected_text' => 'Chọn học kỳ',
                        'value' => $selectedSemester ?? ''
                    ]) ?>
                </div>
                <button type="submit" style="display: none;">Submit</button>
        </div>
        </form>

        <div style="display: none;">
            <?= view('components/dropdown', []) ?>
        </div>

        <div class="conduct-btns">
            <button class="conduct-btn" onclick="loadChartData('grade-10')">Khối 10</button>
            <button class="conduct-btn" onclick="loadChartData('grade-11')">Khối 11</button>
            <button class="conduct-btn" onclick="loadChartData('grade-12')">Khối 12</button>
        </div>
        <div class="body-below">
            <div id="excellent">
                <div class="conduct-chart">
                    <?= view('components/column_chart', [
                        'HanhKiemKhoi10' => $HanhKiemKhoi10,
                        'HanhKiemKhoi11' => $HanhKiemKhoi11,
                        'HanhKiemKhoi12' => $HanhKiemKhoi12
                    ]) ?>
                </div>
            </div>
            <div class="conduct-table">
                Danh sách các học sinh có điểm hạnh kiểm thấp nhất
                <?= view('components/tables/directorStaticsConduct', [
                    'worstStudents' => $worstStudents
                ]) ?>
            </div>
        </div>
    </div>
</div>
</div>


<style>
    *,
    *::before,
    *::after {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    .statics-conduct {
        display: flex;
        width: 100%;
        height: 100%;
        flex-direction: column;
        align-items: flex-start;
        background: var(--White, #FFF);
    }

    .conduct-heading {
        width: 100%;
        height: 60px;
        position: fixed;
    }

    .body {
        display: flex;
        align-items: flex-start;
        flex: 1 0 0;
        margin-top: 60px;
        align-self: stretch;
        background: var(--light-grey, #F9FAFB);
        overflow: hidden;
    }

    .body-left {
        height: 100%;
        overflow-y: auto;
    }

    .body-below {
        display: flex;
        align-items: flex-start;
        gap: 5px;
        align-self: stretch;
        width: 100%;
        background-color: white;
        overflow: visible;
    }

    .body-right {
        display: flex;
        padding: 20px;
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
        flex: 1;
        align-self: stretch;
        color: #000;
        font-family: Inter;
        font-size: 16px;
        font-style: normal;
        font-weight: 400;
        line-height: normal;
        height: auto;
    }

    .conduct-table {
        display: flex;
        flex-direction: column;
        gap: 10px;
        flex: 1;
        align-self: stretch;
        background: #FFF;
        overflow-y: auto; 
        max-height: none; 
        height: auto; 
        padding: 10px;
    }

    .conduct-table table {
        width: 100%;
        border-collapse: collapse;
        border-spacing: 0;
    }

    .conduct-table th, .conduct-table td {
        padding: 8px;
        text-align: left;
    }

    .conduct-table th {
        position: sticky;
        top: 0;
        z-index: 1;
    }

    .conduct-chart {
        display: flex;
        width: 500px;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        gap: 10px;
        background: var(--White, #FFF);
        z-index: 0;
    }

    .conduct-btns {
        display: inline-flex;
        padding: 4px 5px;
        align-items: flex-start;
        border-radius: 6px;
        border: 1px solid var(--slate-300, #CBD5E1);
        background: var(--White, #FFF);
    }

    .conduct-btn {
        display: flex;
        padding: 6px 12px;
        align-items: flex-start;
        background: var(--White, #FFF);
        border: none;
        font-family: "Inter";
        cursor: pointer;
    }

    .conduct-btn:hover {
        background: var(--slate-100, #F1F5F9);
    }

    .conduct-btn:focus {
        background: var(--slate-100, #F1F5F9);
    }

    .conduct-btn.active {
        background: var(--slate-100, #F1F5F9);
    }

    

    #excellent {
        width: 50%;
    }

    #good {
        width: 50%;
    }

    #bad {
        width: 50%;
    }

    .conduct-table {
        display: flex;
        padding: 10px;
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
        flex: 1;
        align-self: stretch;
        background: #FFF;
        overflow: auto;
        
    }

    .dropdown-edit {
        width: 180px;
    }

    .tool-search {
        display: flex;
        align-items: center;
        gap: 10px;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Lấy form và các dropdown
        const form = document.getElementById('form');
        const yearDropdown = document.querySelector('[data-dropdown-id="year-dropdown"]');
        const semesterDropdown = document.querySelector('[data-dropdown-id="semester-dropdown"]');

        // Bắt sự kiện click cho dropdown "year"
        if (yearDropdown) {
            const yearOptions = yearDropdown.querySelectorAll('.option');
            yearOptions.forEach(option => {
                option.addEventListener('click', function() {
                    // Cập nhật giá trị của input ẩn
                    const selectedValue = this.getAttribute('data-value');
                    yearDropdown.querySelector('input').value = selectedValue;

                    // Cập nhật text hiển thị trong dropdown
                    yearDropdown.querySelector('.selected-text').textContent = this.textContent;

                    // Tự động submit form khi chọn xong
                    form.submit();
                });
            });
        }

        // Bắt sự kiện click cho dropdown "class"
        if (semesterDropdown) {
            const semesterOptions = semesterDropdown.querySelectorAll('.option');
            semesterOptions.forEach(option => {
                option.addEventListener('click', function() {
                    // Cập nhật giá trị của input ẩn
                    const selectedValue = this.getAttribute('data-value');
                    semesterDropdown.querySelector('input').value = selectedValue;

                    // Cập nhật text hiển thị trong dropdown
                    semesterDropdown.querySelector('.selected-text').textContent = this.textContent;

                    // Tự động submit form khi chọn xong
                    form.submit();
                });
            });
        }
    });

    function openConduct(ConductName) {
        var x = document.getElementsByClassName("Conduct");
        for (var i = 0; i < x.length; i++) {
            x[i].style.display = "none";
        }
        document.getElementById(ConductName).style.display = "block";

        loadChartData(ConductName); // Gọi hàm vẽ chart khi chuyển tab
    }
</script>