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
            <form method="POST" action=" ">
                <h2>Thông tin tài khoản:</h2>
                <div class="cashierupdate-fields">
                    <div class="cashierupdate-field">
                        Tài khoản
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'teacher_account',
                            'required' => true,
                        ]) ?>
                    </div>
                    <div class="cashierupdate-field">
                        Mật khẩu
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'teacher_password',
                            'required' => true,
                        ]) ?>
                    </div>
                </div>
                <h2>Thông tin cá nhân:</h2>
                <div class="cashierupdate-fields">
                    <div class="cashierupdate-field">
                        Họ và tên
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'teacher_name',
                            'required' => true,
                        ]) ?>
                    </div>
                    <div class="cashierupdate-field">
                        Email
                        <?= view('components/input', [
                            'type' => 'email',
                            'name' => 'teacher_email',
                            'required' => true,
                        ]) ?>
                    </div>
                </div>
                <div class="cashierupdate-fields">
                    <div class="cashierupdate-field">
                        Số điện thoại
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'teacher_phone',
                            'required' => true,
                        ]) ?>
                    </div>
                    <div class="cashierupdate-field">
                        Địa chỉ
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'teacher_address',
                            'required' => true,
                        ]) ?>
                    </div>
                </div>
                <div class="cashierupdate-fields">
                    <div class="cashierupdate-specials">
                        <div class="cashierupdate-special">
                            Giới tính
                            <?= view('components/dropdown', [
                                'options' => ['Nữ', 'Nam', 'Khác'],
                                'dropdown_id' => 'gender-dropdown',
                                'name' => 'teacher_gender',
                                'selected_text' => 'Giới tính',
                            ]) ?>
                        </div>
                        <div class="cashierupdate-special">
                            Ngày sinh
                            <?= view('components/datepicker', [
                                'datepicker_id' => 'birthday',
                                'name' => 'supervisor_birthday',
                            ]) ?>
                        </div>
                    </div>
                    <div class="cashierupdate-specials">
                        <div class="cashierupdate-special">
                            Tình trạng
                            <?= view('components/dropdown', [
                                'options' => ['Đang làm', 'Khóa'],
                                'dropdown_id' => 'status-dropdown',
                                'name' => 'supervisor_status',
                                'selected_text' => 'Tình trạng',
                            ]) ?>
                        </div>
                        <!-- Đừng đụng vào cái này -->
                        <div class="cashierupdate-special" style="display:none">
                            Tình trạng
                            <?= view('components/dropdown', [
                                'options' => ['Nữ', 'Nam', 'Khác'],
                                'dropdown_id' => 'gender-dropdown',
                                'name' => 'teacher_gender',
                                'selected_text' => 'Giới tính',
                            ]) ?>
                        </div>
                    </div>
                </div>
                <div class="cashierupdate-btns">
                    <?= view('components/exit_button') ?>
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