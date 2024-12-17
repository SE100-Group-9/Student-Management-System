<link rel="stylesheet" href="<?= base_url(relativePath: 'assets/css/style.css') ?>">

<div class="teacherupdate">
    <div class="teacherupdate-heading">
        <?= view('components/heading') ?>
    </div>
    <div class="body">
        <div class="body-left">
            <?= view('components/sidebar_director') ?>
        </div>
        <div class="body-right">
            Quản lý / Quản lý nhân viên / Giáo viên
            <h1>Cập nhật hồ sơ:</h1>
            <form method="POST" action=" ">
                <h2>Thông tin tài khoản:</h2>
                <div class="teacherupdate-fields">
                    <div class="teacherupdate-field">
                        Tài khoản
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'teacher_account',
                            'required' => true,
                            'value' => '01',
                        ]) ?>
                    </div>
                    <div class="teacherupdate-field">
                        Mật khẩu
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'teacher_password',
                            'required' => true,
                            'value' => '123abc',
                        ]) ?>
                    </div>
                </div>
                <h2>Thông tin cá nhân:</h2>
                <div class="teacherupdate-fields">
                    <div class="teacherupdate-field">
                        Họ và tên
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'teacher_name',
                            'required' => true,
                            'value' => 'Lê Nguyễn Hoài Thương',
                        ]) ?>
                    </div>
                    <div class="teacherupdate-field">
                        Email
                        <?= view('components/input', [
                            'type' => 'email',
                            'name' => 'teacher_email',
                            'required' => true,
                            'value' => 'a@gmail.com',
                        ]) ?>
                    </div>
                </div>
                <div class="teacherupdate-fields">
                    <div class="teacherupdate-field">
                        Số điện thoại
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'teacher_phone',
                            'required' => true,
                            'value' => '0123456789',
                        ]) ?>
                    </div>
                    <div class="teacherupdate-field">
                        Địa chỉ
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'teacher_updateress',
                            'required' => true,
                            'value' => '123 TPHCM',
                        ]) ?>
                    </div>
                </div>
                <div class="teacherupdate-fields">
                    <div class="teacherupdate-specials">
                        <div class="teacherupdate-special">
                            Giới tính
                            <?= view('components/dropdown', [
                                'options' => ['Nữ', 'Nam'],
                                'dropdown_id' => 'gender-dropdown',
                                'name' => 'teacher_gender',
                                'selected_text' => 'Giới tính',
                                'value' => 'Nữ',
                            ]) ?>
                        </div>
                        <div class="teacherupdate-special">
                            Chức vụ
                            <?= view('components/dropdown', [
                                'options' => ['Tổ trưởng', 'Tổ phó', 'Giáo viên'],
                                'dropdown_id' => 'role-dropdown',
                                'name' => 'teacher_role',
                                'selected_text' => 'Chức vụ',
                                'value' => 'Tổ trưởng',
                            ]) ?>
                        </div>
                        <div class="hidden-dropdown">
                            <?= view('components/dropdown', [
                                'options' => ['Tổ trưởng', 'Tổ phó', 'Giáo viên'],
                                'dropdown_id' => 'roles-dropdown',
                                'name' => 'teacher_roles',
                                'selected_text' => 'Chức vụ',
                            ]) ?>
                        </div>
                    </div>
                </div>
                <div class="teacherupdate-btns">
                    <a href="/sms/public/director/employee/teacher/list" style="text-decoration: none;">
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

    .teacherupdate {
        display: flex;
        width: 100%;
        height: 100%;
        flex-direction: column;
        align-items: flex-start;
        background: #FFF;
    }

    .hidden-dropdown {
        display: none;
    }

    .teacherupdate-heading {
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

    .teacherupdate-fields {
        display: flex;
        width: 100%;
        justify-content: space-between;
        align-items: center;
    }

    .teacherupdate-field {
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

    .teacherupdate-btns {
        display: flex;
        width: 100%;
        justify-content: flex-end;
        align-items: center;
        gap: 20px;
    }

    .teacherupdate-specials {
        display: flex;
        width: 45%;
        justify-content: space-between;
        align-items: flex-start;
    }

    .teacherupdate-special {
        display: flex;
        width: 45%;
        flex-direction: column;
        align-items: flex-start;
        gap: 20px;
        flex-shrink: 0;
    }
</style>