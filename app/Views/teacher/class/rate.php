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
                        'options' => [],
                        'dropdown_id' => 'hocky-dropdown',
                        'name' => 'hocky',
                        'selected_text' => 'Chọn học kỳ',
                        'value' => $selectedHocKy ?? ''
                    ]) ?>
                    <?= view('components/dropdown', [
                        'options' => [],
                        'dropdown_id' => 'lophoc-dropdown',
                        'name' => 'lophoc',
                        'selected_text' => 'Chọn lớp học',
                        'value' => $selectedLopHoc ?? ''
                    ]) ?>
                </div>
                <div class="tool-add">
                    <?= view('components/excel_export') ?>
                </div>
            </div>
            <?= view('components/tables/teacherClassRate', ['tableId' => 'teacherClassRate']) ?>
            <?= view('components/pagination'); ?>
        </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
                const yearDropdown = document.querySelector('[data-dropdown-id="year-dropdown"]');
                const hocKyDropdown = document.querySelector('[data-dropdown-id="hocky-dropdown"]');
                const lopHocDropdown = document.querySelector('[data-dropdown-id="lophoc-dropdown"]');

                console.log('Year Dropdown:', yearDropdown);
                console.log('Hoc Ky Dropdown:', hocKyDropdown);
                console.log('Lop Hoc Dropdown:', lopHocDropdown);

                // Kiểm tra nếu các dropdown không được tìm thấy
                if (!yearDropdown || !hocKyDropdown || !lopHocDropdown) {
                    console.error("Một trong các dropdown không tồn tại!");
                    return;

                    // Khi chọn năm học
                    yearDropdown.addEventListener('change', function() {
                        const selectedYear = this.querySelector('input').value;

                        // Gọi API để lấy danh sách học kỳ
                        fetch(`http://localhost/sms/public/teacher/class/rate/getHocKyByYear/${selectedYear}`)
                            .then(response => response.json())
                            .then(data => {
                                // Cập nhật học kỳ
                                updateDropdown(hocKyDropdown, data, 'Chọn học kỳ');
                                updateDropdown(lopHocDropdown, [], 'Chọn lớp học'); // Reset lớp học
                            })
                            .catch(error => {
                                console.error('Lỗi khi gọi API học kỳ:', error);
                            });
                    });

                    // Khi chọn học kỳ
                    hocKyDropdown.addEventListener('change', function() {
                        const selectedYear = yearDropdown.querySelector('input').value;
                        const selectedHocKy = this.querySelector('input').value;

                        console.log('Selected Year:', selectedYear);
                        console.log('Selected Hoc Ky:', selectedHocKy);
                        if (!selectedYear || !selectedHocKy) {
                            console.log('Không có lớp học nào');
                            return;
                        }
                        // Nếu không thấy thì console.log('Không có lớp học nào');
                        if (!selectedYear || !selectedHocKy) {
                            console.log('Không có lớp học nào');
                            return;
                        }

                        // Gọi API để lấy danh sách lớp học
                        fetch(`http://localhost/sms/public/teacher/class/rate/getLopHocByHocKy/${selectedYear}/${selectedHocKy}`)
                            .then(response => response.json())
                            .then(data => {
                                // Cập nhật lớp học
                                updateDropdown(lopHocDropdown, data, 'Chọn lớp học');
                            })
                            .catch(error => {
                                console.error('Lỗi khi gọi API lớp học:', error);
                            });
                    });


                    // Hàm cập nhật dropdown
                    function updateDropdown(dropdown, options, placeholder) {
                        const dropdownInput = dropdown.querySelector('input');
                        const dropdownText = dropdown.querySelector('.selected-text');
                        const dropdownOptions = dropdown.querySelector('.dropdown-option');

                        console.log('Dropdown trước khi cập nhật:', dropdown);
                        console.log('Danh sách tùy chọn:', options);

                        dropdownInput.value = '';
                        dropdownText.textContent = placeholder;
                        dropdownOptions.innerHTML = options.map(option => `
                <div class="option" data-value="${option}">
                    <p>${option}</p>
                </div>
            `).join('');

                        dropdownOptions.querySelectorAll('.option').forEach(option => {
                            option.addEventListener('click', function() {
                                dropdownInput.value = this.dataset.value;
                                dropdownText.textContent = this.textContent;
                                console.log('Giá trị đã chọn:', this.dataset.value);
                                console.log('Tên lớp học đã chọn:', this.textContent);
                            });
                        });
                    }
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