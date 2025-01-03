<link rel="stylesheet" href="<?= base_url(relativePath: 'assets/css/style.css') ?>">

<div class="classlists">
    <div class="classlists-heading">
        <?= view('components/heading') ?>
    </div>
    <div class="body">
        <div class="body-left">
            <?= view('components/sidebar_teacher') ?>
        </div>
        <div class="body-right">
            Học tập / Lớp học / Báo cáo học lực lớp
            <div class="classlists-tools">
                <form method="GET" action="/sms/public/teacher/class/record/list" id="form">
                    <div class="tools">
                        <?= view('components/searchbar') ?>
                        <?= view('components/dropdown', [
                            'options' => $yearList ?? [],
                            'dropdown_id' => 'year-dropdown',
                            'name' => 'year',
                            'selected_text' => 'Chọn năm học',
                            'value' => $selectedYear ?? ''
                        ]) ?>
                        <?= view('components/dropdown', [
                            'options' => ['Học kỳ 1', 'Học kỳ 2'],
                            'dropdown_id' => 'semester-dropdown',
                            'name' => 'semester',
                            'selected_text' => 'Chọn học kỳ',
                            'value' => $selectedSemester ?? ''
                        ]) ?>
                        <?= view('components/dropdown', [
                            'options' => ['15 Phút lần 1', '15 Phút lần 2', '1 Tiết lần 1', '1 Tiết lần 2', 'Cuối kỳ'],
                            'dropdown_id' => 'exam-dropdown',
                            'name' => 'exam',
                            'selected_text' => 'Bài kiểm tra',
                            'value' => $selectedExam ?? ''
                        ]) ?>
                        <button type="submit" style="display: none;">Submit</button>
                    </div>
                </form>
                <div class="tool-add">
                    <?= view('components/excel_export') ?>
                </div>
            </div>

            <?= view('components/tables/teacherRecordList', [
                'academicReport' => $academicReport ?? [],
                'selectedYear' => $selectedYear ?? '',
                'selectedSemester' => $selectedSemester ?? '',
                'selectedExam' => $selectedExam ?? ''
            ]) ?>

            <?php if (isset($error) && $error): ?>
                <p><?= $error ?></p>
            <?php endif; ?>

            <?= view('components/pagination') ?>
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

    .classlists {
        display: flex;
        width: 100%;
        height: 100%;
        flex-direction: column;
        align-items: flex-start;
        background: #FFF;
    }

    .classlists-heading {
        height: 60px;
        width: 100%;
    }

    .body {
        display: flex;
        align-items: flex-start;
        flex: 1 0 0;
        align-self: stretch;
        background: #F9FAFB;
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

    .classlists-tools {
        display: flex;
        padding: 10px;
        justify-content: space-between;
        align-items: flex-start;
        align-self: stretch;
        border-radius: 10px;
        background: #FFF;
    }

    .tools {
        width: 50%;
        display: flex;
        gap: 10px;
    }

    .tool-add {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .tabless {
        width: 100%;
        height: 100%;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Lấy form
        const form = document.querySelector('form'); // Đảm bảo form cần xử lý có tồn tại

        // Lấy các dropdown
        const yearDropdown = document.querySelector('[data-dropdown-id="year-dropdown"]');
        const semesterDropdown = document.querySelector('[data-dropdown-id="semester-dropdown"]');
        const examDropdown = document.querySelector('[data-dropdown-id="exam-dropdown"]');

        // Hàm xử lý sự kiện click
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

        // Áp dụng sự kiện cho từng dropdown
        handleDropdownClick(yearDropdown);
        handleDropdownClick(semesterDropdown);
        handleDropdownClick(examDropdown);
    });
</script>