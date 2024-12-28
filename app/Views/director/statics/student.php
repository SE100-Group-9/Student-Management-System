<link rel="stylesheet" href="<?= base_url(relativePath: 'assets/css/style.css') ?>">

<div class="statics-student">
    <div class="student-heading">
        <?= view('components/heading') ?>
    </div>
    <div class="body">
        <div class="body-left">
            <?= view('components/sidebar_director') ?>
        </div>
        <div class="body-right">
            Trung tâm / Thống kê / Học sinh
            <!-- Dropdown -->
            <form method="GET" action="/sms/public/director/statics/student" id="form">
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
                    <button type="submit" style="display: none;">Submit</button>
                </div>
            </form>

            <!-- Cards -->
            <div class="student-cards">
                <?php if ($enrolledChange >= 0): ?>
                    <?= view('components/card_increase', [
                        'title' => 'Số học sinh nhập học',
                        'count' => $currentEnrolledCount,
                        'percentage' => number_format(abs($enrolledChange), 2) . '%',
                        'comparison' => 'so với năm ' . $previousYear
                    ]) ?>
                <?php else: ?>
                    <?= view('components/card_decrease', [
                        'title' => 'Số học sinh nhập học',
                        'count' => $currentEnrolledCount,
                        'percentage' => number_format(abs($enrolledChange), 2) . '%',
                        'comparison' => 'so với năm ' . $previousYear
                    ]) ?>
                <?php endif; ?>
                <?php if ($totalChange >= 0): ?>
                    <?= view('components/card_increase', [
                        'title' => 'Tổng số học sinh',
                        'count' => $currentTotalCount,
                        'percentage' => number_format(abs($totalChange), 2) . '%',
                        'comparison' => 'so với năm ' . $previousYear
                    ]) ?>
                <?php else: ?>
                    <?= view('components/card_decrease', [
                        'title' => 'Tổng số học sinh',
                        'count' => $currentTotalCount,
                        'percentage' => number_format(abs($totalChange), 2) . '%',
                        'comparison' => 'so với năm ' . $previousYear
                    ]) ?>
                <?php endif; ?>
                <?php if ($warnedChange >= 0): ?>
                    <?= view('components/card_increase', [
                        'title' => 'Số học sinh bị cảnh báo',
                        'count' => $currentWarnedCount,
                        'percentage' => number_format(abs($warnedChange), 2) . '%',
                        'comparison' => 'so với năm ' . $previousYear
                    ]) ?>
                <?php else: ?>
                    <?= view('components/card_decrease', [
                        'title' => 'Số học sinh bị cảnh báo',
                        'count' => $currentWarnedCount,
                        'percentage' => number_format(abs($warnedChange), 2) . '%',
                        'comparison' => 'so với năm ' . $previousYear
                    ]) ?>
                <?php endif; ?>
            </div>
            <!-- Chart -->
            <div class="student-chart">
                <div class="chart-text">
                    Biểu đồ biểu diễn sự thay đổi của học sinh theo từng năm
                </div>
                <?= view('components/curve_chart', [
                    'enrolledStudentData' => $enrolledStudentData,
                    'warnedStudentData' => $warnedStudentData,
                ]) ?>
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

    .statics-student {
        display: flex;
        width: 100%;
        height: 100%;
        flex-direction: column;
        align-items: flex-start;
        background: var(--White, #FFF);
    }

    .student-heading {
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

    .student-cards {
        display: flex;
        justify-content: space-between;
        align-items: center;
        align-self: stretch;
    }

    .student-chart {
        display: flex;
        padding: 20px;
        flex-direction: column;
        align-items: flex-start;
        gap: 20px;
        flex: 1 0 0;
        align-self: stretch;
        border-radius: 10px;
        background: var(--White, #FFF);
    }

    .chart-text {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        gap: 31px;
        align-self: stretch;
        color: #000;
        font-family: Inter;
        font-size: 20px;
        font-style: normal;
        font-weight: 400;
        line-height: 24px;
        /* 120% */
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
        // Lấy form và dropdown "year"
        const form = document.getElementById('form'); // Đảm bảo form có id="form"
        const yearDropdown = document.querySelector('[data-dropdown-id="year-dropdown"]');

        // Kiểm tra nếu dropdown year tồn tại
        if (yearDropdown) {
            const yearOptions = yearDropdown.querySelectorAll('.option'); // Lấy tất cả các option trong dropdown
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
    });
</script>