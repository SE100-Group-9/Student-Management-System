<link rel="stylesheet" href="<?= base_url(relativePath: 'assets/css/style.css') ?>">

<div class="studentupdate">
    <div class="studentupdate-heading">
        <?= view('components/heading') ?>
    </div>
    <div class="body">
        <div class="body-left">
            <?= view('components/sidebar_director') ?>
        </div>
        <div class="body-right">
            Học tập / Học sinh / Danh sách học sinh
            <h1>Tạo hồ sơ:</h1>
            <form method="POST" action="/sms/public/director/student/updateStudent">
                <h2>Thông tin tài khoản:</h2>
                <div class="studentupdate-fields">
                    <input type="hidden" name="MaHS" value="<?= $student['MaHS'] ?? '' ?>">
                    <input type="hidden" name="MaTK" value="<?= $student['MaTK'] ?? '' ?>">
                    <div class="studentupdate-field">
                        Tài khoản
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'student_account',
                            'required' => true,
                            'placeholder' => 'Tên tài khoản',
                            'value' => $student['TenTK'] ?? '',
                            'readonly' => true
                        ]) ?>
                    </div>
                    <div class="studentupdate-field">
                        Mật khẩu
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'student_password',
                            'required' => true,
                            'placeholder' => 'Mật khẩu',
                            'value' => $student['MatKhau'] ?? '',
                            'readonly' => false
                        ]) ?>
                    </div>
                </div>
                <h2>Thông tin cá nhân:</h2>
                <div class="studentupdate-fields">
                    <div class="studentupdate-field">
                        Họ và tên
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'student_name',
                            'required' => true,
                            'placeholder' => 'Họ tên học sinh',
                            'value' => $student['HoTen'] ?? ''
                        ]) ?>
                    </div>
                    <div class="studentupdate-field">
                        Email
                        <?= view('components/input', [
                            'type' => 'email',
                            'name' => 'student_email',
                            'required' => true,
                            'placeholder' => 'Email',
                            'value' => $student['Email'] ?? ''
                        ]) ?>
                    </div>
                </div>
                <div class="studentupdate-fields">
                    <div class="studentupdate-field">
                        Số điện thoại
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'student_phone',
                            'required' => true,
                            'placeholder' => 'Số điện thoại',
                            'value' => $student['SoDienThoai'] ?? ''
                        ]) ?>
                    </div>
                    <div class="studentupdate-field">
                        Địa chỉ
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'student_address',
                            'required' => true,
                            'placeholder' => 'Địa chỉ',
                            'value' => $student['DiaChi'] ?? ''
                        ]) ?>
                    </div>
                </div>
                <div class="studentupdate-fields">
                    <div class="studentupdate-specials">
                        <div class="studentupdate-special">
                            Giới tính
                            <?= view('components/dropdown', [
                                'options' => ['Nữ', 'Nam'],
                                'dropdown_id' => 'gender-dropdown',
                                'name' => 'student_gender',
                                'selected_text' => 'Giới tính',
                                'value' => $student['GioiTinh'] ?? ''
                            ]) ?>
                        </div>
                        <div class="studentupdate-special">
                            Ngày sinh
                            <?= view('components/datepicker', [
                                'datepicker_id' => 'birthday',
                                'name' => 'student_birthday',
                                'value' => $student['NgaySinh'] ?? ''
                            ]) ?>
                        </div>

                    </div>
                    <div class="studentupdate-onces">
                        <div class="studentupdate-once">
                            Dân tộc
                            <?= view('components/input', [
                                'type' => 'text',
                                'name' => 'student_nation',
                                'required' => true,
                                'placeholder' => 'Dân tộc',
                                'value' => $student['DanToc'] ?? ''
                            ]) ?>
                        </div>
                        <div class="studentupdate-once">
                            Nơi sinh
                            <?= view('components/input', [
                                'type' => 'text',
                                'name' => 'student_country',
                                'required' => true,
                                'placeholder' => 'Nơi sinh',
                                'value' => $student['NoiSinh'] ?? ''
                            ]) ?>
                        </div>
                    </div>
                </div>
                <h2>Tình trạng học</h2>
                <div class="studentupdate-fields">
                    <div class="studentupdate-specials">
                        <div class="studentupdate-special">
                            Lớp học
                            <?= view('components/dropdown', [
                                'options' => ['11A1', '11A2', '11A3'],
                                'dropdown_id' => 'class-dropdown',
                                'name' => 'student_class',
                                'selected_text' => 'Lớp học',
                            ]) ?>
                        </div>
                        <div class="studentupdate-special">
                            Tình trạng hiện tại
                            <?= view('components/dropdown', [
                                'options' => ['Đang học', 'Đã nghỉ học', 'Đã tốt nghiệp'],
                                'dropdown_id' => 'class-dropdown',
                                'name' => 'student_status',
                                'selected_text' => 'Tình trạng hiện tại',
                                'value' => $student['TinhTrang'] ?? ''
                            ]) ?>

                        </div>
                    </div>
                </div>
                <div class="studentupdate-btns">
                    <a style="text-decoration: none" href="/sms/public/director/student/list">
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

    .studentupdate {
        display: flex;
        width: 100%;
        height: 100%;
        flex-direction: column;
        align-items: flex-start;
        background: #FFF;
    }

    .studentupdate-heading {
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

    .studentupdate-fields {
        display: flex;
        width: 100%;
        justify-content: space-between;
        align-items: center;
    }

    .studentupdate-field {
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

    .studentupdate-btns {
        display: flex;
        width: 100%;
        justify-content: flex-end;
        align-items: center;
        gap: 20px;
    }

    .studentupdate-specials {
        display: flex;
        width: 45%;
        justify-content: space-between;
        align-items: flex-start;
    }

    .studentupdate-special {
        display: flex;
        width: 45%;
        flex-direction: column;
        align-items: flex-start;
        gap: 20px;
        flex-shrink: 0;
    }

    .studentupdate-once {
        display: flex;
        width: 45%;
        flex-direction: column;
        align-items: flex-start;
        gap: 20px;
        flex-shrink: 0;
    }

    .studentupdate-onces {
        display: flex;
        width: 45%;
        justify-content: space-between;
        align-items: center;
    }
</style>