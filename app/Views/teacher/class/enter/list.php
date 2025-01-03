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
            Học tập / Lớp học / Nhập điểm
            <form method="GET" action="/sms/public/teacher/class/enter/list" id="form">
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
                <?= view('components/dropdown') ?>
            </div>

            <div class="tabless">
                <?= view('components/tables/teacherEnterList',[
                    'enterList' => $enterList ?? [],
                    'selectedYear' => $selectedYear ?? '',
                    'selectedSemester' => $selectedSemester ?? ''
                ]) ?>
            </div>
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

    .dropdown-edit {
        width: 180px;
    }

    .tool-search {
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