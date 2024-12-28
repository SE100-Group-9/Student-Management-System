<link rel="stylesheet" href="<?= base_url(relativePath: 'assets/css/style.css') ?>">

<div class="teacher-profile">
    <div class="teacher-profile-heading">
        <?= view('components/heading') ?>
    </div>
    <div class="body">
        <div class="body-left">
            <?= view('components/sidebar_teacher') ?>
        </div>
        <div class="body-right">
            <h2>Thông tin cá nhân:</h2>
            <form method="POST" action="/sms/public/teacher/profile">
                <div class="teacher-profile-fields">
                    <input type="hidden" name="MaBGH" value="<?= $teacher['MaGV'] ?? '' ?>">
                    <input type="hidden" name="MaTK" value="<?= $teacher['MaTK'] ?? '' ?>">

                    <div class="teacher-profile-field">
                        Mã giáo viên
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'teacher_id',
                            'readonly' => true,
                            'value' => $teacher['MaGV']
                        ]) ?>
                    </div>
                    <div class="teacher-profile-field">
                        Họ tên
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'teacher_name',
                            'readonly' => true,
                            'value' => $teacher['HoTen']
                        ]) ?>
                    </div>
                </div>
                <div class="teacher-profile-fields">
                    <div class="teacher-profile-field">
                        Giới tính
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'teacher_gender',
                            'readonly' => true,
                            'value' => $teacher['GioiTinh']
                        ]) ?>
                    </div>
                    <div class="teacher-profile-field">
                        Ngày sinh
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'teacher_birthday',
                            'readonly' => true,
                            'value' => date('d/m/Y', strtotime($teacher['NgaySinh']))
                        ]) ?>
                    </div>
                </div>
                <div class="teacher-profile-fields">
                    <div class="teacher-profile-field">
                        Địa chỉ
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'teacher_address',
                            'readonly' => false,
                            'required' => true,
                            'value' => $teacher['DiaChi']
                        ]) ?>
                    </div>
                    <div class="teacher-profile-field">
                        Số điện thoại
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'teacher_phone',
                            'readonly' => false,
                            'required' => true,
                            'value' => $teacher['SoDienThoai']
                        ]) ?>
                    </div>
                </div>
                <div class="teacher-profile-fields">
                    <div class="teacher-profile-field">
                        Email
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'teacher_email',
                            'readonly' => false,
                            'required' => true,
                            'value' => $teacher['Email']
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
                            <p><?= $error ?>
                            <p>
                            <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <div class="teacheradd-btns">
                    <a style="text-decoration: none" href="/sms/public/teacher/statics/grade">
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

    .teacher-profile {
        display: flex;
        width: 100%;
        height: 100%;
        flex-direction: column;
        align-items: flex-start;
        background: #FFF;
    }

    .teacher-profile-heading {
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

    .teacher-profile-fields {
        display: flex;
        width: 100%;
        justify-content: space-between;
        align-items: center;
    }

    .teacher-profile-field {
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

    .teacheradd-btns {
        display: flex;
        width: 100%;
        justify-content: flex-end;
        align-items: center;
        gap: 20px;
    }
</style>