<link rel="stylesheet" href="<?= base_url(relativePath: 'assets/css/style.css') ?>">

<div class="teacheradd">
    <div class="teacheradd-heading">
        <?= view('components/heading') ?>
    </div>
    <div class="body">
        <div class="body-left">
            <?= view('components/sidebar_director') ?>
        </div>
        <div class="body-right">
            Quản lý / Quản lý nhân viên / Giáo viên
            <h1>Tạo hồ sơ:</h1>
            <form method="POST" action="/sms/public/director/employee/teacher/add">
                <h2>Thông tin tài khoản:</h2>
                <div class="teacheradd-fields">
                    <div class="teacheradd-field">
                        Tài khoản
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'teacher_account',
                            'value' => $newMaGV ?? '',
                            'readonly' => true,
                            'placeholder' => 'Tên tài khoản',
                        ]) ?>
                    </div>
                    <div class="teacheradd-field">
                        Mật khẩu
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'teacher_password',
                            'readonly' => false,
                            'required' => true,
                            'placeholder' => 'Mật khẩu',
                            'value' => old('teacher_password'),
                        ]) ?>
                    </div>
                </div>
                <h2>Thông tin cá nhân:</h2>
                <div class="teacheradd-fields">
                    <div class="teacheradd-field">
                        Họ và tên
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'teacher_name',
                            'required' => true,
                            'placeholder' => 'Họ tên giáo viên',
                            'value' => old('teacher_name'),
                        ]) ?>
                    </div>
                    <div class="teacheradd-field">
                        Email
                        <?= view('components/input', [
                            'type' => 'email',
                            'name' => 'teacher_email',
                            'required' => true,
                            'placeholder' => 'Email',
                            'value' => old('teacher_email'),
                        ]) ?>
                    </div>
                </div>
                <div class="teacheradd-fields">
                    <div class="teacheradd-field">
                        Số điện thoại
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'teacher_phone',
                            'required' => true,
                            'placeholder' => 'Số điện thoại',
                            'value' => old('teacher_phone'),
                        ]) ?>
                    </div>
                    <div class="teacheradd-field">
                        Địa chỉ
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'teacher_address',
                            'required' => true,
                            'placeholder' => 'Địa chỉ',
                            'value' => old('teacher_address'),
                        ]) ?>
                    </div>
                </div>
                <div class="teacheradd-fields">
                    <div class="teacheradd-specials">
                        <div class="teacheradd-special">
                            Giới tính
                            <?= view('components/dropdown', [
                                'options' => ['Nữ', 'Nam'],
                                'dropdown_id' => 'gender-dropdown',
                                'name' => 'teacher_gender',
                                'selected_text' => 'Giới tính',
                                'value' => old('teacher_gender'),
                            ]) ?>
                        </div>
                        <div class="teacheradd-special">
                            Ngày sinh
                            <?= view('components/datepicker', [
                                'datepicker_id' => 'birthday',
                                'name' => 'teacher_birthday',
                                'value' => old('teacher_birthday'),
                            ]) ?>
                        </div>
                    </div>
                    <div class="teacheradd-special">
                        <div class="teacheradd-special">
                            Chức vụ
                            <?= view('components/dropdown', [
                                'options' => ['Tổ trưởng', 'Tổ phó', 'Giáo viên'],
                                'dropdown_id' => 'role-dropdown',
                                'name' => 'teacher_role',
                                'selected_text' => 'Chức vụ',
                                'value' => old('teacher_role'),
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
                        <?php foreach (session()->getFlashdata('errors') as $field => $error): ?>
                            <p><?= $error ?>
                            <p>
                            <?php endforeach; ?>
                    </div>
                <?php endif; ?>


                <div class="teacheradd-btns">
                    <a style="text-decoration: none" href="/sms/public/director/employee/teacher/list">
                        <?= view('components/exit_button') ?>
                    </a>
                    <?= view('components/save_button') ?>
                </div>
            </form>
            <!-- Đừng đụng vào cái này -->
            <div class="supervisoradd-special" style="display:none">
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

    .teacheradd {
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

    .teacheradd-heading {
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

    .teacheradd-fields {
        display: flex;
        width: 100%;
        justify-content: space-between;
        align-items: center;
    }

    .teacheradd-field {
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

    .teacheradd-specials {
        display: flex;
        width: 45%;
        justify-content: space-between;
        align-items: flex-start;
    }

    .teacheradd-special {
        display: flex;
        width: 45%;
        flex-direction: column;
        align-items: flex-start;
        gap: 20px;
        flex-shrink: 0;
    }
</style>