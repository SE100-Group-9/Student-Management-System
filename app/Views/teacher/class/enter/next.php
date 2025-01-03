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
            <div class="classlists-tools">
                <div class="tools">
                    <?= view('components/searchbar') ?>
                </div>
                <?= view('components/save_button') ?>
            </div>

            <?php if (session()->getFlashdata('success')): ?>
                <p class="alert alert-success"><?= session()->getFlashdata('success') ?></p>
            <?php elseif (session()->getFlashdata('error')): ?>
                <p class="alert alert-danger"><?= session()->getFlashdata('error') ?></p>
            <?php endif; ?>

            <?php if (session()->has('errors')): ?>
                <div class="alert alert-danger">
                    <?php foreach (session('errors') as $error): ?>
                        <p><?= esc($error) ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <div class="tabless">
                <?= view('components/tables/teacherEnterScore', [
                    'scoreList' => $scoreList ?? [],
                    'NamHoc' => $NamHoc,
                    'HocKy' => $HocKy,
                    'TenMH' => $TenMH,
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
        let isFormDirty = false; // Biến theo dõi trạng thái thay đổi của form

        // Theo dõi sự thay đổi trong các ô nhập liệu
        const commentInputs = document.querySelectorAll('input[name^="scores"]');
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
        document.getElementById('score-form').submit();
    });
</script>