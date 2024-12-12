<link rel="stylesheet" href="<?= base_url(relativePath: 'assets/css/style.css') ?>">

<div class="cashierupdate">
    <div class="cashierupdate-heading">
        <?= view('components/heading') ?>
    </div>
    <div class="body">
        <div class="body-left">
            <?= view('components/sidebar_director') ?>
        </div>
        <div class="body-right">
            Quản lý / Quản lý nhân viên / Thu ngân
            <h1>Tạo hồ sơ:</h1>
            <form method="POST" action="/sms/public/director/employee/cashier/update/<?= $cashier['MaTN'] ?>">
                <h2>Thông tin tài khoản:</h2>
                <div class="cashierupdate-fields">
                    <input type="hidden" name="MaTN" value="<?= $cashier['MaTN'] ?? '' ?>">
                    <input type="hidden" name="MaTK" value="<?= $cashier['MaTK'] ?? '' ?>">
                    <div class="cashierupdate-field">
                        Tài khoản
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'cashier_account',
                            'required' => true,
                            'value' => $cashier['TenTK'],
                            'readonly' => true,
                        ]) ?>
                    </div>
                    <div class="cashierupdate-field">
                        Mật khẩu
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'cashier_password',
                            'required' => true,
                            'value' => $cashier['MatKhau'],
                            'readonly' => false,
                        ]) ?>
                    </div>
                </div>
                <h2>Thông tin cá nhân:</h2>
                <div class="cashierupdate-fields">
                    <div class="cashierupdate-field">
                        Họ và tên
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'cashier_name',
                            'required' => true,
                            'value' => $cashier['HoTen'],
                        ]) ?>
                    </div>
                    <div class="cashierupdate-field">
                        Email
                        <?= view('components/input', [
                            'type' => 'email',
                            'name' => 'cashier_email',
                            'required' => true,
                            'value' => $cashier['Email'],
                        ]) ?>
                    </div>
                </div>
                <div class="cashierupdate-fields">
                    <div class="cashierupdate-field">
                        Số điện thoại
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'cashier_phone',
                            'required' => true,
                            'value' => $cashier['SoDienThoai'],
                        ]) ?>
                    </div>
                    <div class="cashierupdate-field">
                        Địa chỉ
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'cashier_address',
                            'required' => true,
                            'value' => $cashier['DiaChi'],
                        ]) ?>
                    </div>
                </div>
                <div class="cashierupdate-fields">
                    <div class="cashierupdate-specials">
                        <div class="cashierupdate-special">
                            Giới tính
                            <?= view('components/dropdown', [
                                'options' => ['Nữ', 'Nam'],
                                'dropdown_id' => 'gender-dropdown',
                                'name' => 'cashier_gender',
                                'selected_text' => 'Giới tính',
                                'value' => $cashier['GioiTinh'],
                            ]) ?>
                        </div>
                        <div class="cashierupdate-special">
                            Ngày sinh
                            <?= view('components/datepicker', [
                                'datepicker_id' => 'birthday',
                                'name' => 'cashier_birthday',
                                'value' => $cashier['NgaySinh'],
                            ]) ?>
                        </div>
                    </div>
                    <div class="cashierupdate-specials">
                        <div class="cashierupdate-special">
                            Tình trạng
                            <?= view('components/dropdown', [
                                'options' => ['Đang làm việc', 'Đã nghỉ việc'],
                                'dropdown_id' => 'status-dropdown',
                                'name' => 'cashier_status',
                                'selected_text' => 'Tình trạng',
                                'value' => $cashier['TinhTrang'],
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

                <div class="cashierupdate-btns">
                    <a style="text-decoration: none" href="/sms/public/director/employee/cashier/list">
                        <?= view('components/exit_button') ?>
                    </a>
                    <?= view('components/save_button') ?>
                </div>
            </form>
            <!-- Đừng đụng vào cái này -->
            <div class="cashierupdate-special" style="display:none">
                <?= view('components/dropdown', []) ?>
            </div>
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

    .cashierupdate {
        display: flex;
        width: 100%;
        height: 100%;
        flex-direction: column;
        align-items: flex-start;
        background: #FFF;
    }

    .cashierupdate-heading {
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

    .cashierupdate-fields {
        display: flex;
        width: 100%;
        justify-content: space-between;
        align-items: center;
    }

    .cashierupdate-field {
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

    .cashierupdate-btns {
        display: flex;
        width: 100%;
        justify-content: flex-end;
        align-items: center;
        gap: 20px;
    }

    .cashierupdate-specials {
        display: flex;
        width: 45%;
        justify-content: space-between;
        align-items: flex-start;
    }

    .cashierupdate-special {
        display: flex;
        width: 45%;
        flex-direction: column;
        align-items: flex-start;
        gap: 20px;
        flex-shrink: 0;
    }
</style>