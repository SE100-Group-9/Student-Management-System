<link rel="stylesheet" href="<?= base_url(relativePath: 'assets/css/style.css') ?>">

<div class="teacherstudentlist">
    <div class="teacherstudentlist-heading">
        <?= view('components/heading') ?>
    </div>
    <div class="body">
        <div class="body-left">
            <?= view('components/sidebar_teacher') ?>
        </div>
        <div class="body-right">
            Học tập / Học sinh / Danh sách học sinh
            <div class="teacherstudentlist-tools">
                <form method="GET" action="/sms/public/teacher/student/list" id="form">
                    <div class="tool-search">
                        <?= view('components/searchbar') ?>
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
                                'options' => $classList ?? [],
                                'dropdown_id' => 'class-dropdown',
                                'name' => 'class',
                                'selected_text' => 'Chọn lớp học',
                                'value' => $selectedClass ?? ''
                            ]) ?>
                        </div>
                        <button type="submit" style="display: none;">Submit</button>
                    </div>
                </form>
                <div class="tool-add">
                    <?= view('components/excel_export') ?>
                </div>
            </div>
            <?= view('components/tables/teacherStudentList', ['studentList' => $studentList]) ?>
            <?php if (isset($error) && $error): ?>
                <p><?= $error ?></p>
            <?php endif; ?>
            <?= view('components/pagination'); ?>
        </div>
    </div>
</div>
<div style="display: none;">
    <?= view('components/dropdown', []) ?>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Lấy form và các dropdown
        const form = document.getElementById('form');
        const yearDropdown = document.querySelector('[data-dropdown-id="year-dropdown"]');
        const classDropdown = document.querySelector('[data-dropdown-id="class-dropdown"]');

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
        if (classDropdown) {
            const classOptions = classDropdown.querySelectorAll('.option');
            classOptions.forEach(option => {
                option.addEventListener('click', function() {
                    // Cập nhật giá trị của input ẩn
                    const selectedValue = this.getAttribute('data-value');
                    classDropdown.querySelector('input').value = selectedValue;

                    // Cập nhật text hiển thị trong dropdown
                    classDropdown.querySelector('.selected-text').textContent = this.textContent;

                    // Tự động submit form khi chọn xong
                    form.submit();
                });
            });
        }
    });
</script>

<style>
    *,
    *::before,
    *::after {
        padding: 0;
        margin: 0;
        box-sizing: border-box;
    }

    .teacherstudentlist {
        display: flex;
        width: 100%;
        height: 100%;
        flex-direction: column;
        align-items: flex-start;
        background: #FFF;
    }

    .teacherstudentlist-heading {
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

    .teacherstudentlist-tools {
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

    .dropdown-edit {
        width: 180px;
    }

    .tabless {
        width: 100%;
        height: 100%;
    }
</style>