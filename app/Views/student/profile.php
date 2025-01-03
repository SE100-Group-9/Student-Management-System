<link rel="stylesheet" href="<?= base_url(relativePath: 'assets/css/style.css') ?>">

<div class="student-profile">
    <div class="student-profile-heading">
        <?= view('components/heading') ?>
    </div>
    <div class="body">
        <div class="body-left">
            <?= view('components/sidebar_student') ?>
        </div>
        <div class="body-right">
            <h2>Thông tin cá nhân:</h2>
            <form method="POST" action="/sms/public/student/profile">
                <div class="student-profile-fields">
                <input type="hidden" name="MaHS" value="<?= $Student['MaHS'] ?? '' ?>">
                <input type="hidden" name="MaTK" value="<?= $Student['MaTK'] ?? '' ?>">
                    <div class="student-profile-field">
                        Mã học sinh
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'student_id',
                            'readonly' => true,
                            'value' => $Student['MaHS']
                        ]) ?>
                    </div>
                    <div class="student-profile-field">
                        Họ tên
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'student_name',
                            'readonly' => true,
                            'value' => $Student['HoTen']
                        ]) ?>
                    </div>
                </div>
                <div class="student-profile-fields">
                    <div class="student-profile-field">
                        Giới tính
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'student_sex',
                            'readonly' => true,
                            'value' => $Student['GioiTinh']
                        ]) ?>
                    </div>
                    <div class="student-profile-field">
                        Ngày sinh
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'student_date-of-birth',
                            'readonly' => true,
                            'value' => $Student['NgaySinh']
                        ]) ?>
                    </div>
                </div>
                <div class="student-profile-fields">
                    <div class="student-profile-field">
                        Địa chỉ
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'address',
                            'readonly' => false,
                            'value' => $Student['DiaChi']
                        ]) ?>
                    </div>
                    <div class="student-profile-field">
                        Số điện thoại
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'phone',
                            'readonly' => false,
                            'value' => $Student['SoDienThoai']
                        ]) ?>
                    </div>
                </div>
                <div class="student-profile-fields">
                    <div class="student-profile-field">
                        Email
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'email',
                            'readonly' => false,
                            'value' => $Student['Email']
                        ]) ?>
                    </div>
                    <div class="student-profile-field">
                        Nơi sinh
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'country',
                            'readonly' => false,
                            'value' => $Student['NoiSinh']
                        ]) ?>
                    </div>
                </div>
                <div class="student-profile-fields">
                    <div class="student-profile-field">
                        Dân tộc
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'nation',
                            'readonly' => false,
                            'value' => $Student['DanToc']
                        ]) ?>
                    </div>
                    <div class="student-profile-field">
                        Tình trạng
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'student_status',
                            'readonly' => true,
                            'value' => $Student['TinhTrang']
                        ]) ?>
                    </div>
                </div>
                <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success">
                        <?= session()->getFlashdata('success') ?>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('errors')): ?>
                    <div class="alert alert-danger">
                        <?= session()->getFlashdata('error') ?>
                        <?php foreach (session()->getFlashdata('errors') as $error): ?>
                            <p><?= $error ?><p>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <div class="supervisoradd-btns">
                    <a style="text-decoration: none" href="/sms/public/student/score">
                        <?= view('components/exit_button') ?>
                    </a>
                    <?= view('components/save_button') ?>
                </div>
            </form>
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

    .student-profile {
        display: flex;
        width: 100%;
        height: 100%;
        flex-direction: column;
        align-items: flex-start;
        background: #FFF;
    }

    .student-profile-heading {
        width: 100%;
        height: 60px;
    }

    .body {
        display: flex;
        align-items: flex-start;
        flex: 1 0 0;
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
        overflow-y: auto;
        color: #000;
        font-family: Inter;
        font-size: 16px;
        font-style: normal;
        font-weight: 400;
        line-height: normal;
    }

    .body-right h1 {
        color: #000;
        font-family: Inter;
        font-size: 16px;
        font-style: normal;
        font-weight: 700;
        line-height: normal;
    }

    .body-right h2 {
        color: var(--Cerulean, #01B3EF);
        font-family: Inter;
        font-size: 16px;
        font-style: normal;
        font-weight: 700;
        line-height: normal;
    }

    .supervisoradd-btns {
        display: flex;
        width: 100%;
        justify-content: flex-end;
        align-items: center;
        gap: 20px;
    }

    .student-profile-fields {
        display: flex;
        width: 100%;
        justify-content: space-between;
        align-items: center;
    }

    .student-profile-field {
        display: flex;
        width: 45%;
        flex-direction: column;
        align-items: flex-start;
        gap: 20px;
        flex-shrink: 0;
        color: #000;
        font-family: Inter;
        font-size: 16px;
        font-style: normal;
        font-weight: 400;
        line-height: normal;
    }
</style>