<link rel="stylesheet" href="<?= base_url(relativePath: 'assets/css/style.css') ?>">

<div class="classlists">
    <div class="classlists-heading">
        <?= view('components/heading') ?>
    </div>
    <div class="body">
        <div class="body-left">
            <?= view('components/sidebar_director') ?>
        </div>
        <div class="body-right">
            Học tập / Lớp học / Lớp <?= esc($TenLop) ?> / Giáo viên
            <div>
                <?= view('components/tab', ['MaLop' => $MaLop, 'activeTab' => 'teacher']) ?>
            </div>
            <div class="classlists-tools">
                <form method="GET" action="/sms/public/director/class/arrange/teacher/<?= $MaLop ?>" id="form">
                    <div class="tools">
                        <?= view('components/searchbar', ['searchTerm' => $searchTerm]) ?>
                        <?= view('components/dropdown', [
                            'options' => ['Học kỳ 1', 'Học kỳ 2'],
                            'dropdown_id' => 'semester-dropdown',
                            'name' => 'semester',
                            'selected_text' => 'Chọn học kỳ',
                            'value' => $selectedSemester ?? ''
                        ]) ?>
                        <button type="submit" style="display: none;">Submit</button>
                    </div>
                </form>
                <div class="tool-add">
                    <a " style=" text-decoration: none;" href="/sms/public/director/class/arrange/addteacher/<?= $MaLop ?>">
                        <?= view('components/add', data: ['button_text' => 'Thêm giáo viên']) ?>
                    </a>
                    <?= view('components/excel_export') ?>
                    <?= view('components/upload') ?>
                </div>
            </div>
            <div class="tabless">
                <?= view('components/tables/directorClassArrangeTeacher', ['teacherList' => $teacherList]) ?>
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
        width: 60%;
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
        // Lấy form và dropdown "semester"
        const form = document.getElementById('form'); // Đảm bảo form có id="form"
        const semesterDropdown = document.querySelector('[data-dropdown-id="semester-dropdown"]'); // Lấy dropdown bằng data-dropdown-id

        // Kiểm tra nếu dropdown semester tồn tại
        if (semesterDropdown) {
            const semesterOptions = semesterDropdown.querySelectorAll('.option'); // Lấy tất cả các option trong dropdown
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
    });
</script>