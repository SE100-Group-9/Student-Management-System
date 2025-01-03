<link rel="stylesheet" href="<?= base_url(relativePath: 'assets/css/style.css') ?>">

<div class="statics-grade">
    <div class="grade-heading">
        <?= view('components/heading') ?>
    </div>
    <div class="body">
        <div class="body-left">
            <?= view('components/sidebar_teacher') ?>
        </div>
        <div class="body-right">
            Trung tâm / Thống kê / Học lực
            <form method="GET" action="/sms/public/teacher/statics/grade" id="form">
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

            <?php
            // Xác định text comparison dựa trên selectedSemester
            $comparisonText = 'so với ';
            if ($selectedSemester === 'Học kỳ 1' || $selectedSemester === 'Học kỳ 2') {
                $comparisonText .= strtolower($selectedSemester) . ' năm ' . $previousYear;
            } else {
                $comparisonText .= 'năm ' . $previousYear;
            }
            ?>
            <?php if (isset($error) && $error): ?>
                <p><?= $error ?></p>
            <?php endif; ?>
            <div style="display: none;">
                <?= view('components/dropdown', []) ?>
            </div>

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
                    Thống kê học lực học sinh trong học kỳ

                    <?= view('components/pie_chart_teacher', [
                        'excellentCount' => $excellentCount,
                        'goodCount' => $goodCount,
                        'averageCount' => $averageCount,
                        'weakCount' => $weakCount
                    ]) ?>
                </div>
                <div class="charts">
                    Biểu đồ so sánh số lượng học sinh theo học lực trong học kỳ
                    <?= view('components/column_chart_teacher', [
                        'excellentCount' => $excellentCount,
                        'goodCount' => $goodCount,
                        'averageCount' => $averageCount,
                        'weakCount' => $weakCount
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
        width: 100%;
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
        // Lấy form
        const form = document.querySelector('#form'); // Đảm bảo form cần xử lý có tồn tại

        // Lấy các dropdown
        const yearDropdown = document.querySelector('[data-dropdown-id="year-dropdown"]');
        const semesterDropdown = document.querySelector('[data-dropdown-id="semester-dropdown"]');

        // Hàm xử lý sự kiện click cho các dropdown
        function handleDropdownClick(dropdown) {
            if (!dropdown) return;

            const options = dropdown.querySelectorAll('.option');
            options.forEach(option => {
                option.addEventListener('click', function() {
                    const selectedValue = this.getAttribute('data-value'); // Lấy giá trị từ data-value
                    const input = dropdown.querySelector('input'); // Input ẩn
                    const selectedText = dropdown.querySelector('.selected-text'); // Text hiển thị

                    if (input && selectedText) {
                        input.value = selectedValue; // Cập nhật giá trị cho input
                        selectedText.textContent = this.textContent; // Cập nhật text hiển thị
                    }

                    // Submit form tự động
                    if (form) form.submit();
                });
            });
        }

        // Áp dụng sự kiện cho các dropdown
        handleDropdownClick(yearDropdown);
        handleDropdownClick(semesterDropdown);
    });
</script>