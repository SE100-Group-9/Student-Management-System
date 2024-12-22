<link rel="stylesheet" href="<?= base_url(relativePath: 'assets/css/style.css') ?>">

<div class="supervisor-profile">
    <div class="supervisor-profile-heading">
        <?= view('components/heading') ?>
    </div>
    <div class="body">
        <div class="body-left">
            <?= view('components/sidebar_supervisor') ?>
        </div>
        <div class="body-right">
            <h2>Thông tin cá nhân:</h2>
            <form method="POST" action="/sms/public/supervisor/profile">
                <div class="supervisor-profile-fields">
                <input type="hidden" name="MaGT" value="<?= $supervisor['MaGT'] ?? '' ?>">
                <input type="hidden" name="MaTK" value="<?= $supervisor['MaTK'] ?? '' ?>">
                    <div class="supervisor-profile-field">
                        Mã Giám Thị
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'supervisor_id',
                            'readonly' => true,
                            'value' => $supervisor['MaGT']
                        ]) ?>
                    </div>
                    <div class="supervisor-profile-field">
                        Họ tên
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'supervisor_name',
                            'readonly' => true,
                            'value' => $supervisor['HoTen']
                        ]) ?>
                    </div>
                </div>
                <div class="supervisor-profile-fields">
                    <div class="supervisor-profile-field">
                        Giới tính
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'supervisor_sex',
                            'readonly' => true,
                            'value' => $supervisor['GioiTinh']
                        ]) ?>
                    </div>
                    <div class="supervisor-profile-field">
                        Ngày sinh
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'supervisor_date-of-birth',
                            'readonly' => true,
                            'value' => date('d/m/Y', strtotime($supervisor['NgaySinh'])),
                        ]) ?>
                    </div>
                </div>
                <div class="supervisor-profile-fields">
                    <div class="supervisor-profile-field">
                        Địa chỉ
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'supervisor_address',
                            'readonly' => false,
                            'value' => $supervisor['DiaChi']
                        ]) ?>
                    </div>
                    <div class="supervisor-profile-field">
                        Số điện thoại
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'supervisor_phone',
                            'readonly' => false,
                            'value' => $supervisor['SoDienThoai']
                        ]) ?>
                    </div>
                </div>
                <div class="supervisor-profile-fields">
                    <div class="supervisor-profile-field">
                        Email
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'supervisor_email',
                            'readonly' => false,
                            'value' => $supervisor['Email']
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
                    <a style="text-decoration: none" href="/sms/public/supervisor/fault">
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

    .supervisor-profile {
        display: flex;
        width: 100%;
        height: 100%;
        flex-direction: column;
        align-items: flex-start;
        background: #FFF;
    }

    .supervisor-profile-heading {
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

    .supervisor-profile-fields {
        display: flex;
        width: 100%;
        justify-content: space-between;
        align-items: center;
    }

    .supervisor-profile-field {
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