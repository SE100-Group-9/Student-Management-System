<link rel="stylesheet" href="<?= base_url(relativePath: 'assets/css/style.css') ?>">

<div class="cashier-profile">
    <div class="cashier-profile-heading">
        <?= view('components/heading') ?>
    </div>
    <div class="body">
        <div class="body-left">
            <?= view('components/sidebar_cashier') ?>
        </div>
        <div class="body-right">
            <h2>Thông tin cá nhân:</h2>
            <form method="POST" action="/sms/public/cashier/profile">
                <div class="cashier-profile-fields">
                <input type="hidden" name="MaTN" value="<?= $cashier['MaTN'] ?? '' ?>">
                <input type="hidden" name="MaTK" value="<?= $cashier['MaTK'] ?? '' ?>">
                    <div class="cashier-profile-field">
                        Mã Thu Ngân
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'cashier_id',
                            'readonly' => true,
                            'value' => $cashier['MaTN']
                        ]) ?>
                    </div>
                    <div class="cashier-profile-field">
                        Họ tên
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'cashier_name',
                            'readonly' => true,
                            'value' => $cashier['HoTen']
                        ]) ?>
                    </div>
                </div>
                <div class="cashier-profile-fields">
                    <div class="cashier-profile-field">
                        Giới tính
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'cashier_sex',
                            'readonly' => true,
                            'value' => $cashier['GioiTinh']
                        ]) ?>
                    </div>
                    <div class="cashier-profile-field">
                        Ngày sinh
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'cashier_date-of-birth',
                            'readonly' => true,
                            'value' => date('d/m/Y', strtotime($cashier['NgaySinh'])),
                        ]) ?>
                    </div>
                </div>
                <div class="cashier-profile-fields">
                    <div class="cashier-profile-field">
                        Địa chỉ
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'cashier_address',
                            'readonly' => false,
                            'value' => $cashier['DiaChi']
                        ]) ?>
                    </div>
                    <div class="cashier-profile-field">
                        Số điện thoại
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'cashier_phone',
                            'readonly' => false,
                            'value' => $cashier['SoDienThoai']
                        ]) ?>
                    </div>
                </div>
                <div class="cashier-profile-fields">
                    <div class="cashier-profile-field">
                        Email
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'cashier_email',
                            'readonly' => false,
                            'value' => $cashier['Email']
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

                <div class="cashieradd-btns">
                    <a style="text-decoration: none" href="/sms/public/cashier/invoice/list">
                        <?= view('components/exit_button') ?>
                    </a href="/sms/public/cashier/profile">
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

    .cashier-profile {
        display: flex;
        width: 100%;
        height: 100%;
        flex-direction: column;
        align-items: flex-start;
        background: #FFF;
    }

    .cashier-profile-heading {
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

    .cashieradd-btns {
        display: flex;
        width: 100%;
        justify-content: flex-end;
        align-items: center;
        gap: 20px;
    }

    .cashier-profile-fields {
        display: flex;
        width: 100%;
        justify-content: space-between;
        align-items: center;
    }

    .cashier-profile-field {
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