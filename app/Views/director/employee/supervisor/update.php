<link rel="stylesheet" href="<?= base_url(relativePath: 'assets/css/style.css') ?>">

<div class="supervisoradd">
    <div class="supervisoradd-heading">
        <?= view('components/heading') ?>
    </div>
    <div class="body">
        <div class="body-left">
            <?= view('components/sidebar_director') ?>
        </div>
        <div class="body-right">
            Quản lý / Quản lý nhân viên / Giám thị
            <h1>Tạo hồ sơ:</h1>
            <form method="POST" action="/sms/public/director/employee/supervisor/update/<?= $supervisor['MaGT'] ?>">
                <h2>Thông tin tài khoản:</h2>
                <div class="supervisoradd-fields">
                    <input type="hidden" name="MaGT" value="<?= $supervisor['MaGT'] ?? '' ?>">
                    <input type="hidden" name="MaTK" value="<?= $supervisor['MaTK'] ?? '' ?>">
                    <div class="supervisoradd-field">
                        Tài khoản
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'supervisor_account',
                            'required' => true,
                            'value' => $supervisor['TenTK'],
                            'readonly' => true,
                        ]) ?>
                    </div>
                    <div class="supervisoradd-field">
                        Mật khẩu
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'supervisor_password',
                            'required' => true,
                            'value' => $supervisor['MatKhau'],
                            'readonly' => false,
                        ]) ?>
                    </div>
                </div>
                <h2>Thông tin cá nhân:</h2>
                <div class="supervisoradd-fields">
                    <div class="supervisoradd-field">
                        Họ và tên
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'supervisor_name',
                            'required' => true,
                            'value' => $supervisor['HoTen'],
                        ]) ?>
                    </div>
                    <div class="supervisoradd-field">
                        Email
                        <?= view('components/input', [
                            'type' => 'email',
                            'name' => 'supervisor_email',
                            'required' => true,
                            'value' => $supervisor['Email'],
                        ]) ?>
                    </div>
                </div>
                <div class="supervisoradd-fields">
                    <div class="supervisoradd-field">
                        Số điện thoại
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'supervisor_phone',
                            'required' => true,
                            'value' => $supervisor['SoDienThoai'],
                        ]) ?>
                    </div>
                    <div class="supervisoradd-field">
                        Địa chỉ
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'supervisor_address',
                            'required' => true,
                            'value' => $supervisor['DiaChi'],
                        ]) ?>
                    </div>
                </div>
                <div class="supervisoradd-fields">
                    <div class="supervisoradd-specials">
                        <div class="supervisoradd-special">
                            Giới tính
                            <?= view('components/dropdown', [
                                'options' => ['Nữ', 'Nam', 'Khác'],
                                'dropdown_id' => 'gender-dropdown',
                                'name' => 'supervisor_gender',
                                'selected_text' => 'Giới tính',
                                'value' => $supervisor['GioiTinh'],
                            ]) ?>
                        </div>
                        <div class="supervisoradd-special">
                            Ngày sinh
                            <?= view('components/datepicker', [
                                'datepicker_id' => 'birthday',
                                'name' => 'supervisor_birthday',
                                'value' => $supervisor['NgaySinh'],
                            ]) ?>
                        </div>
                    </div>
                    <div class="supervisoradd-specials">
                        <div class="supervisoradd-special">
                            Tình trạng
                            <?= view('components/dropdown', [
                                'options' => ['Đang làm việc', 'Đã nghỉ việc'],
                                'dropdown_id' => 'status-dropdown',
                                'name' => 'supervisor_status',
                                'selected_text' => 'Tình trạng',
                                'value' => $supervisor['TinhTrang'],
                            ]) ?>
                        </div>
                        <!-- Đừng đụng vào cái này -->
                        <div class="supervisoradd-special" style="display:none">
                            Tình trạng
                            <?= view('components/dropdown', [
                                'options' => ['Nữ', 'Nam'],
                                'dropdown_id' => 'gender-dropdown',
                                'name' => 'teacher_gender',
                                'selected_text' => 'Giới tính',
                            ]) ?>
                        </div>
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
                    <a style="text-decoration: none" href="/sms/public/director/employee/supervisor/list">
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

    .supervisoradd {
        display: flex;
        width: 100%;
        height: 100%;
        flex-direction: column;
        align-items: flex-start;
        background: #FFF;
    }

    .supervisoradd-heading {
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

    .supervisoradd-fields {
        display: flex;
        width: 100%;
        justify-content: space-between;
        align-items: center;
    }

    .supervisoradd-field {
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

    .supervisoradd-btns {
        display: flex;
        width: 100%;
        justify-content: flex-end;
        align-items: center;
        gap: 20px;
    }

    .supervisoradd-specials {
        display: flex;
        width: 45%;
        justify-content: space-between;
        align-items: flex-start;
    }

    .supervisoradd-special {
        display: flex;
        width: 45%;
        flex-direction: column;
        align-items: flex-start;
        gap: 20px;
        flex-shrink: 0;
    }
</style>