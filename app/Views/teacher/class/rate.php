<link rel="stylesheet" href="<?= base_url(relativePath: 'assets/css/style.css') ?>">

<div class="teacherClassRate">
    <div class="teacherclassrate-heading">
        <?= view('components/heading') ?>
    </div>
    <div class="body">
        <div class="body-left">
            <?= view('components/sidebar_teacher') ?>
        </div>
        <div class="body-right">
            Học tập / Lớp học / Đánh giá kết quả học
            <div class="teacherclassrate-tools">
                <form method="GET" action="/sms/public/teacher/class/rate" id="form">
                    <div class="tool-search">
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
                    <?= view('components/save_button', ['text' => 'Lưu đánh giá']) ?>
                    <?= view('components/excel_export') ?>
                </div>
            </div>

            <?php if (session()->getFlashdata('success')): ?>
                <p class="alert alert-success"><?= session()->getFlashdata('success') ?></p>
            <?php elseif (session()->getFlashdata('error')): ?>
                <p class="alert alert-danger"><?= session()->getFlashdata('error') ?></p>
            <?php endif; ?>

                <?= view('components/tables/teacherClassRate', [
                    'studentList' => $studentList,
                    'selectedYear' => $selectedYear,
                    'selectedSemester' => $selectedSemester,
                    'selectedClass' => $selectedClass
                ]) ?>


            <?php if (isset($error) && $error): ?>
                <p><?= $error ?></p>
            <?php endif; ?>

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

    .teacherclassrate {
        display: flex;
        width: 100%;
        height: 100%;
        flex-direction: column;
        align-items: flex-start;
        background: #FFF;
    }

    .teacherclassrate-heading {
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

    .teacherclassrate-tools {
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
        let isFormDirty = false; // Biến theo dõi trạng thái thay đổi của form

        // Theo dõi sự thay đổi trong các ô nhập liệu
        const commentInputs = document.querySelectorAll('input[name^="comments"]');
        commentInputs.forEach(input => {
            input.addEventListener('input', function() {
                isFormDirty = true; // Đánh dấu form đã thay đổi
            });
        });

        // Theo dõi sự kiện trước khi rời khỏi trang
        window.addEventListener('beforeunload', function(event) {
            if (isFormDirty) {
                // Hiển thị thông báo cảnh báo
                event.preventDefault();
                event.returnValue = ''; // Bắt buộc phải có để kích hoạt hộp thoại xác nhận
            }
        });

        // Khi người dùng nhấn nút Lưu đánh giá, đặt lại trạng thái
        document.getElementById('button-save').addEventListener('click', function() {
            isFormDirty = false; // Đặt lại trạng thái form
        });
    });

    // Lấy nút submit và form
    document.getElementById('button-save').addEventListener('click', function() {
        // Gửi form
        document.getElementById('comment-form').submit();
    });

    document.addEventListener('DOMContentLoaded', function() {
        // Lấy form
        const form = document.querySelector('form'); // Đảm bảo form cần xử lý có tồn tại

        // Lấy các dropdown
        const yearDropdown = document.querySelector('[data-dropdown-id="year-dropdown"]');
        const semesterDropdown = document.querySelector('[data-dropdown-id="semester-dropdown"]');
        const classDropdown = document.querySelector('[data-dropdown-id="class-dropdown"]');

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
        handleDropdownClick(classDropdown);
    });
</script>