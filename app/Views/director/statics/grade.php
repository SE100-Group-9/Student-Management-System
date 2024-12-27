<link rel="stylesheet" href="<?= base_url(relativePath: 'assets/css/style.css') ?>">

<div class="statics-grade">
    <div class="grade-heading">
        <?= view('components/heading') ?>
    </div>
    <div class="body">
        <div class="body-left">
            <?= view('components/sidebar_director') ?>
        </div>
        <div class="body-right">
            Trung tâm / Thống kê / Học lực
            <!-- Dropdown -->
            <form method="GET" action="/sms/public/director/statics/grade" id="form">
                <div class="tool-search">
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
                            'options' => ['Học kỳ 1', 'Học kỳ 2', 'Cả năm'],
                            'dropdown_id' => 'semester-dropdown',
                            'name' => 'semester',
                            'selected_text' => 'Chọn học kỳ',
                            'value' => $selectedSemester ?? ''
                        ]) ?>
                    </div>
                    <div class="dropdown-edit">
                        <?= view('components/dropdown', [
                            'options' => ['Khối 10', 'Khối 11', 'Khối 12'],
                            'dropdown_id' => 'grade-dropdown',
                            'name' => 'grade',
                            'selected_text' => 'Chọn khối',
                            'value' => $selectedGrade ?? ''
                        ]) ?>
                    </div>
                    <button type="submit" style="display: none;">Submit</button>
                </div>

            </form>
            <?php
            // Xác định text comparison dựa trên selectedSemester
            $comparisonText = 'so với ';
            if ($selectedSemester === 'Học kỳ 1' || $selectedSemester === 'Học kỳ 2') {
                $comparisonText .= strtolower($selectedSemester) . ' năm ' . $previousYear;
            } else {
                $comparisonText .= 'năm ' . $previousYear;
            }
            ?>
            <!-- Cards -->
            <div class="grade-cards">
                <!-- Học lực Giỏi -->
                <?php if ($excellentChange >= 0): ?>
                    <?= view('components/card_increase', [
                        'title' => 'Học lực giỏi',
                        'count' => $excellentCount,
                        'percentage' => number_format(abs($excellentChange), 2) . '%',
                        'comparison' => $comparisonText
                    ]) ?>
                <?php else: ?>
                    <?= view('components/card_decrease', [
                        'title' => 'Học lực giỏi',
                        'count' => $excellentCount,
                        'percentage' => number_format(abs($excellentChange), 2) . '%',
                        'comparison' => $comparisonText
                    ]) ?>
                <?php endif; ?>
                <!-- Học lực Khá -->
                <?php if ($goodChange >= 0): ?>
                    <?= view('components/card_increase', [
                        'title' => 'Học lực khá',
                        'count' => $goodCount,
                        'percentage' => number_format(abs($goodChange), 2) . '%',
                        'comparison' => $comparisonText
                    ]) ?>
                <?php else: ?>
                    <?= view('components/card_decrease', [
                        'title' => 'Học lực khá',
                        'count' => $goodCount,
                        'percentage' => number_format(abs($goodChange), 2) . '%',
                        'comparison' => $comparisonText
                    ]) ?>
                <?php endif; ?>
                <!-- Học lực Trung bình -->
                <?php if ($averageChange >= 0): ?>
                    <?= view('components/card_increase', [
                        'title' => 'Học lực trung bình',
                        'count' => $averageCount,
                        'percentage' => number_format(abs($averageChange), 2) . '%',
                        'comparison' => $comparisonText
                    ]) ?>
                <?php else: ?>
                    <?= view('components/card_decrease', [
                        'title' => 'Học lực trung bình',
                        'count' => $averageCount,
                        'percentage' => number_format(abs($averageChange), 2) . '%',
                        'comparison' => $comparisonText
                    ]) ?>
                <?php endif; ?>
                <!-- Học lực Yếu -->
                <?php if ($weakChange >= 0): ?>
                    <?= view('components/card_increase', [
                        'title' => 'Học lực yếu',
                        'count' => $weakCount,
                        'percentage' => number_format(abs($weakChange), 2) . '%',
                        'comparison' => $comparisonText
                    ]) ?>
                <?php else: ?>
                    <?= view('components/card_decrease', [
                        'title' => 'Học lực yếu',
                        'count' => $weakCount,
                        'percentage' => number_format(abs($weakChange), 2) . '%',
                        'comparison' => $comparisonText
                    ]) ?>
                <?php endif; ?>
            </div>
            <!-- Chart -->
            <div class="grade-chart">
                <div class="charts">
                    <?= view('components/pie_chart', [
                        'excellentCount' => $excellentCount,
                        'goodCount' => $goodCount,
                        'averageCount' => $averageCount,
                        'weakCount' => $weakCount
                    ]) ?>
                </div>
                <div class="grade-statics">
                    Top 10 học sinh điểm trung bình cao nhất khối
                    <?= view('components/tables/directorStaticsGrade', ['topStudents' => $topStudents]) ?>
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

    .statics-grade {
        display: flex;
        width: 100%;
        height: 100%;
        flex-direction: column;
        align-items: flex-start;
        background: var(--White, #FFF);
    }

    .grade-heading {
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

    .body-right {
        display: flex;
        padding: 20px;
        flex-direction: column;
        align-items: flex-start;
        gap: 20px;
        flex: 1 0 0;
        align-self: stretch;
        color: #000;
        font-family: Inter;
        font-size: 16px;
        font-style: normal;
        font-weight: 400;
        line-height: normal;
        overflow-y: auto;
    }

    .grade-cards {
        display: flex;
        justify-content: space-between;
        align-items: center;
        align-self: stretch;
    }

    .grade-chart {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        align-self: stretch;
    }

    .charts {
        width: 50%;
    }

    .grade-statics {
        width: 50%;
        display: flex;
        padding: 10px;
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
        flex: 1 0 0;
        align-self: stretch;
        background: #FFF;
        color: #000;
        font-family: Inter;
        font-size: 20px;
        font-style: normal;
        font-weight: 700;
        line-height: normal;
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

        // Dropdown năm học
        const yearDropdown = document.querySelector('[data-dropdown-id="year-dropdown"]');
        // Dropdown học kỳ
        const semesterDropdown = document.querySelector('[data-dropdown-id="semester-dropdown"]');
        // Dropdown khối
        const gradeDropdown = document.querySelector('[data-dropdown-id="grade-dropdown"]');

        // Xử lý sự kiện click cho dropdown "year"
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

        // Xử lý sự kiện click cho dropdown "semester"
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

        // Xử lý sự kiện click cho dropdown "grade"
        if (gradeDropdown) {
            const gradeOptions = gradeDropdown.querySelectorAll('.option');
            gradeOptions.forEach(option => {
                option.addEventListener('click', function() {
                    // Cập nhật giá trị của input ẩn
                    const selectedValue = this.getAttribute('data-value');
                    gradeDropdown.querySelector('input').value = selectedValue;

                    // Cập nhật text hiển thị trong dropdown
                    gradeDropdown.querySelector('.selected-text').textContent = this.textContent;

                    // Tự động submit form khi chọn xong
                    form.submit();
                });
            });
        }
    });
</script>