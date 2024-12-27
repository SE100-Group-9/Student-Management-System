<link rel="stylesheet" href="<?= base_url(relativePath: 'assets/css/style.css') ?>">

<div class="studentrecord">
    <div class="studentrecord-heading">
        <?= view('components/heading') ?>
    </div>
    <div class="body">
        <div class="body-left">
            <?= view('components/sidebar_director') ?>
        </div>
        <div class="body-right">
            Học tập / Học sinh / Thông tin học bạ
            <div class="studentrecord-tools">
                <form method="GET" action="/sms/public/director/student/record" id="form">
                    <div class="tool-search">
                        <?= view('components/searchbar') ?>
                        <?= view('components/dropdown', [
                            'options' => ['2023-2024', '2024-2025', '2025-2026'],
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
                            'value' => $selectedSemesterText ?? ''
                        ]) ?>
                        <?= view('components/dropdown', [
                            'options' => $classList ?? [],
                            'dropdown_id' => 'class-dropdown',
                            'name' => 'class',
                            'selected_text' => 'Chọn lớp học',
                            'value' => $selectedClass ?? ''
                        ]) ?>
                        <button type="submit" style="display: none;">Submit</button>
                    </div>
                </form>
                <div class="tool-add">
                    <?= view('components/excel_export') ?>
                </div>
            </div>
            <?= view('components/tables/directorStudentRecord', ['studentList' => $studentList]) ?>
            <?= view('components/pagination'); ?>
        </div>
    </div>
</div>

<style>
    *,
    *::before,
    *::after {
        padding: 0;
        margin: 0;
        box-sizing: border-box;
    }

    .studentrecord {
        display: flex;
        width: 100%;
        height: 100%;
        flex-direction: column;
        align-items: flex-start;
        background: #FFF;
    }

    .studentrecord-heading {
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

    .studentrecord-tools {
        display: flex;
        width: 100%;
        padding: 10px;
        justify-content: space-between;
        align-items: flex-start;
        border-radius: 10px;
        background: #FFF;
    }

    .tool-search {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .tool-add {
        display: flex;
        align-items: center;
        gap: 10px;
    }
</style>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Lấy form
        const form = document.getElementById('form'); // Đảm bảo form có id="form"

        // Lấy các dropdown
        const yearDropdown = document.querySelector('[data-dropdown-id="year-dropdown"]');
        const semesterDropdown = document.querySelector('[data-dropdown-id="semester-dropdown"]');
        const classDropdown = document.querySelector('[data-dropdown-id="class-dropdown"]');

        // Xử lý sự kiện click cho yearDropdown
        if (yearDropdown) {
            const yearOptions = yearDropdown.querySelectorAll('.option');
            yearOptions.forEach(option => {
                option.addEventListener('click', function() {
                    // Cập nhật giá trị của input ẩn
                    const selectedValue = this.getAttribute('data-value');
                    yearDropdown.querySelector('input').value = selectedValue;

                    // Cập nhật text hiển thị trong dropdown
                    yearDropdown.querySelector('.selected-text').textContent = this.textContent;

                    // Tự động submit form
                    form.submit();
                });
            });
        }

        // Xử lý sự kiện click cho semesterDropdown
        if (semesterDropdown) {
            const semesterOptions = semesterDropdown.querySelectorAll('.option');
            semesterOptions.forEach(option => {
                option.addEventListener('click', function() {
                    // Cập nhật giá trị của input ẩn
                    const selectedValue = this.getAttribute('data-value');
                    semesterDropdown.querySelector('input').value = selectedValue;

                    // Cập nhật text hiển thị trong dropdown
                    semesterDropdown.querySelector('.selected-text').textContent = this.textContent;

                    // Tự động submit form
                    form.submit();
                });
            });
        }

        // Xử lý sự kiện click cho classDropdown
        if (classDropdown) {
            const classOptions = classDropdown.querySelectorAll('.option');
            classOptions.forEach(option => {
                option.addEventListener('click', function() {
                    // Cập nhật giá trị của input ẩn
                    const selectedValue = this.getAttribute('data-value');
                    classDropdown.querySelector('input').value = selectedValue;

                    // Cập nhật text hiển thị trong dropdown
                    classDropdown.querySelector('.selected-text').textContent = this.textContent;

                    // Tự động submit form
                    form.submit();
                });
            });
        }
    });
</script>