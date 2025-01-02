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
            Học tập / Lớp học / Danh sách
            <div class="classlists-tools">
                <form method="GET" action="/sms/public/director/class/list" id="form">
                    <div class="tools">
                        <?= view('components/searchbar') ?>
                        <?= view('components/dropdown', [
                            'options' => ['2023-2024', '2024-2025', '2025-2026'],
                            'dropdown_id' => 'year-dropdown',
                            'name' => 'year',
                            'selected_text' => 'Chọn năm học',
                            'value' => $selectedYear ?? ''
                        ]) ?>
                        <button type="submit" style="display: none;">Submit</button>
                    </div>
                </form>
                <div class="tool-add">
                    <a style="text-decoration: none" href="/sms/public/director/class/add">
                        <?= view('components/add', ['button_text' => 'Thêm lớp học']) ?>
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
                <?= view('components/tables/directorClassList', [
                    'classList' => $classList,
                    'selectedYear' => $selectedYear
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

    .tabless {
        width: 100%;
        height: 100%;
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