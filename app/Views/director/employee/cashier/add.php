<link rel="stylesheet" href="<?= base_url(relativePath: 'assets/css/style.css') ?>">

<div class="cashieradd">
    <div class="cashieradd-heading">
        <?= view('components/heading') ?>
    </div>
    <div class="body">
        <div class="body-left">
            <?= view('components/sidebar_director') ?>
        </div>
        <div class="body-right">
            Quản lý / Quản lý nhân viên / Thu ngân
            <h1>Tạo hồ sơ:</h1>
            <form method="POST" action="/sms/public/director/employee/cashier/add">
                <h2>Thông tin tài khoản:</h2>
                <div class="cashieradd-fields">
                    <div class="cashieradd-field">
                        Tài khoản
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'cashier_account',
                            'value' => $newMaTN ?? '', // Load mã HS tự động
                            'readonly' => true, // Chỉ đọc để không cho sửa
                            'placeholder' => 'Tên tài khoản'
                        ]) ?>
                    </div>
                    <div class="cashieradd-field">
                        Mật khẩu
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'cashier_password',
                            'readonly' => false,
                            'value' => '',
                            'required' => true,
                            'placeholder' => 'Mật khẩu',
                            'value' => old('cashier_password')
                        ]) ?>
                    </div>
                </div>
                <h2>Thông tin cá nhân:</h2>
                <div class="cashieradd-fields">
                    <div class="cashieradd-field">
                        Họ và tên
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'cashier_name',
                            'required' => true,
                            'placeholder' => 'Họ tên thu ngân',
                            'value' => old('cashier_name')
                        ]) ?>
                    </div>
                    <div class="cashieradd-field">
                        Email
                        <?= view('components/input', [
                            'type' => 'email',
                            'name' => 'cashier_email',
                            'required' => true,
                            'placeholder' => 'Email',
                            'value' => old('cashier_email'),
                        ]) ?>
                    </div>
                </div>
                <div class="cashieradd-fields">
                    <div class="cashieradd-field">
                        Số điện thoại
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'cashier_phone',
                            'required' => true,
                            'placeholder' => 'Số điện thoại',
                            'value' => old('cashier_phone')
                        ]) ?>
                    </div>
                    <div class="cashieradd-field">
                        Địa chỉ
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'cashier_address',
                            'required' => true,
                            'placeholder' => 'Địa chỉ',
                            'value' => old('cashier_address')
                        ]) ?>
                    </div>
                </div>
                <div class="cashieradd-fields">
                    <div class="cashieradd-specials">
                        <div class="cashieradd-special">
                            Giới tính
                            <?= view('components/dropdown', [
                                'options' => ['Nữ', 'Nam'],
                                'dropdown_id' => 'gender-dropdown',
                                'name' => 'cashier_gender',
                                'selected_text' => 'Giới tính',
                                'required' => true,
                                'value' => old('cashier_gender')
                            ]) ?>
                        </div>
                        <div class="cashieradd-special">
                            Ngày sinh
                            <?= view('components/datepicker', [
                                'datepicker_id' => 'birthday',
                                'name' => 'cashier_birthday',
                                'required' => true,
                                'value' => old('cashier_birthday')
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
                        <?php foreach (session()->getFlashdata('errors') as $field => $message): ?>
                            <p><?= $message ?><p>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <div class="cashieradd-btns">
                    <a style="text-decoration: none" href="/sms/public/director/employee/cashier/list">
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

    .cashieradd {
        display: flex;
        width: 100%;
        height: 100%;
        flex-direction: column;
        align-items: flex-start;
        background: #FFF;
    }

    .cashieradd-heading {
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

    .cashieradd-fields {
        display: flex;
        width: 100%;
        justify-content: space-between;
        align-items: center;
    }

    .cashieradd-field {
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

    .cashieradd-btns {
        display: flex;
        width: 100%;
        justify-content: flex-end;
        align-items: center;
        gap: 20px;
    }

    .cashieradd-specials {
        display: flex;
        width: 45%;
        justify-content: space-between;
        align-items: flex-start;
    }

    .cashieradd-special {
        display: flex;
        width: 45%;
        flex-direction: column;
        align-items: flex-start;
        gap: 20px;
        flex-shrink: 0;
    }
</style>