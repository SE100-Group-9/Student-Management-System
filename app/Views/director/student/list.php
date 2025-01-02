<link rel="stylesheet" href="<?= base_url(relativePath: 'assets/css/style.css') ?>">

<div class="student-lists">
    <div class="lists-heading">
        <?= view('components/heading') ?>
    </div>
    <div class="body">
        <div class="body-left">
            <?= view('components/sidebar_director') ?>
        </div>
        <div class="body-right">
            Học tập / Học sinh / Danh sách học sinh
            <div class="studentlist-tool">
                <form method="GET" action="/sms/public/director/student/list" id="form">
                    <div class="tool-search">
                        <?= view('components/searchbar', ['searchTerm' => $searchTerm]) ?>

                        <?= view('components/dropdown', [
                            'options' => $yearList ?? [],
                            'dropdown_id' => 'year-dropdown',
                            'name' => 'year',
                            'selected_text' => 'Chọn năm học',
                            'value' => $selectedYear ?? ''
                        ]) ?>

                        <?= view('components/dropdown', [
                            'options' => $classList ?? [],
                            'dropdown_id' => 'class-dropdown',
                            'name' => 'class',
                            'selected_text' => 'Chọn lớp học',
                            'value' => $selectedClass ?? ''
                        ]) ?>
                        <?= view('components/dropdown', [
                            'options' => $statusList ?? [],
                            'dropdown_id' => 'status-dropdown',
                            'name' => 'status',
                            'selected_text' => 'Chọn trạng thái',
                            'value' => $selectedStatus ?? ''
                        ]) ?>
                        <button type="submit" style="display: none;">Submit</button>
                    </div>
                </form>
                <div class="tool-add">
                    <a style="text-decoration: none" href="/sms/public/director/student/add">
                        <?= view('components/add', ['button_text' => 'Thêm học sinh']) ?>
                    </a>
                    <?= view('components/excel_export') ?>
                    <?= view('components/upload') ?>

                </div>
            </div>

            <?php if (session()->getFlashdata('success')) : ?>
                <div style="color: green;"><?= session()->getFlashdata('success') ?></div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('error')) : ?>
                <div style="color: red;"><?= session()->getFlashdata('error') ?></div>
            <?php endif; ?>

            <div class="tabless">
                <?= view('components/tables/directorStudentList', ['studentlist' => $studentlist]) ?>
            </div>
            <div style="max-width: 200px; align-items: flex-end">
                <?= view('components/pagination') ?>
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

    .hidden {
        display: none;
    }

    .student-lists {
        display: flex;
        width: 100%;
        height: 100%;
        flex-direction: column;
        align-items: flex-start;
        background: var(--White, #FFF);
    }

    .lists-heading {
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

    .studentlist-tool {
        display: flex;
        padding: 10px;
        justify-content: space-between;
        align-items: flex-start;
        align-self: stretch;
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

    .tabless {
        width: 100%;
        height: 100%;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Lấy form và các dropdown
        const form = document.getElementById('form'); // Đảm bảo form có id="form"

        // Lấy các dropdown
        const yearDropdown = document.querySelector('[data-dropdown-id="year-dropdown"]');
        const classDropdown = document.querySelector('[data-dropdown-id="class-dropdown"]');
        const statusDropdown = document.querySelector('[data-dropdown-id="status-dropdown"]');

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

        // Xử lý sự kiện click cho statusDropdown
        if (statusDropdown) {
            const statusOptions = statusDropdown.querySelectorAll('.option');
            statusOptions.forEach(option => {
                option.addEventListener('click', function() {
                    // Cập nhật giá trị của input ẩn
                    const selectedValue = this.getAttribute('data-value');
                    statusDropdown.querySelector('input').value = selectedValue;

                    // Cập nhật text hiển thị trong dropdown
                    statusDropdown.querySelector('.selected-text').textContent = this.textContent;

                    // Tự động submit form
                    form.submit();
                });
            });
        }
    });
</script>