<link rel="stylesheet" href="<?= base_url(relativePath: 'assets/css/style.css') ?>">

<div class="studentadd">
    <div class="studentadd-heading">
        <?= view('components/heading') ?>
    </div>
    <div class="body">
        <div class="body-left">
            <?= view('components/sidebar_director') ?>
        </div>
        <div class="body-right">
            Học tập / Học sinh / Danh sách học sinh
            <h1>Tạo hồ sơ:</h1>
            <form method="POST" action=" ">
                <h2>Thông tin tài khoản:</h2>
                <div class="studentadd-fields">
                    <div class="studentadd-field">
                        Tài khoản
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'student_account',
                            'required' => true,
                            'placeholder' => 'NgocMinh'
                        ]) ?>
                    </div>
                    <div class="studentadd-field">
                        Mật khẩu
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'student_password',
                            'required' => true,
                            'placeholder' => 'Minh'
                        ]) ?>
                    </div>
                </div>
                <h2>Thông tin cá nhân:</h2>
                <div class="studentadd-fields">
                    <div class="studentadd-field">
                        Họ và tên
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'student_name',
                            'required' => true,
                            'placeholder' => 'Đặng Thị Ngọc Minh'
                        ]) ?>
                    </div>
                    <div class="studentadd-field">
                        Email
                        <?= view('components/input', [
                            'type' => 'email',
                            'name' => 'student_email',
                            'required' => true,
                            'placeholder' => 'minh123@gmail.com'
                        ]) ?>
                    </div>
                </div>
                <div class="studentadd-fields">
                    <div class="studentadd-field">
                        Số điện thoại
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'student_phone',
                            'required' => true,
                            'placeholder' => '0123456789'
                        ]) ?>
                    </div>
                    <div class="studentadd-field">
                        Địa chỉ
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'student_address',
                            'required' => true,
                            'placeholder' => '123 Thủ Đức'
                        ]) ?>
                    </div>
                </div>
                <div class="studentadd-fields">
                    <div class="studentadd-specials">
                        <div class="studentadd-special">
                            Giới tính
                            <?= view('components/dropdown', [
                                'options' => ['Nữ', 'Nam', 'Khác'],
                                'dropdown_id' => 'gender-dropdown',
                                'name' => 'student_gender',
                                'selected_text' => 'Giới tính',
                            ]) ?>
                        </div>
                        <div class="studentadd-special">
                            Ngày sinh
                            <?= view('components/datepicker', [
                                'datepicker_id' => 'birthday',
                                'name' => 'student_birthday',
                            ]) ?>
                        </div>


                    </div>
                    <div class="studentadd-onces">
                        <div class="studentadd-once">
                            Dân tộc
                            <?= view('components/input', [
                                'type' => 'text',
                                'name' => 'student_nation',
                                'required' => true,
                                'placeholder' => 'Hoa'
                            ]) ?>
                        </div>
                        <div class="studentadd-once">
                            Nơi sinh
                            <?= view('components/input', [
                                'type' => 'text',
                                'name' => 'student_country',
                                'required' => true,
                                'placeholder' => 'TPHCM'
                            ]) ?>
                        </div>
                    </div>
                </div>
                <h2>Tình trạng học</h2>
                <div class="studentadd-fields">
                    <div class="studentadd-specials">
                        <div class="studentadd-special">
                            Lớp học
                            <?= view('components/dropdown', [
                                'options' => ['11A1', '11A2', '11A3'],
                                'dropdown_id' => 'class-dropdown',
                                'name' => 'student_class',
                                'selected_text' => 'Lớp học',
                            ]) ?> </div>
                    </div>
                </div>
                <div class="studentadd-btns">
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

    .studentadd {
        display: flex;
        width: 100%;
        height: 100%;
        flex-direction: column;
        align-items: flex-start;
        background: #FFF;
    }

    .studentadd-heading {
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

    .studentadd-fields {
        display: flex;
        width: 100%;
        justify-content: space-between;
        align-items: center;
    }

    .studentadd-field {
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

    .studentadd-btns {
        display: flex;
        width: 100%;
        justify-content: flex-end;
        align-items: center;
        gap: 20px;
    }

    .studentadd-specials {
        display: flex;
        width: 45%;
        justify-content: space-between;
        align-items: flex-start;
    }

    .studentadd-special {
        display: flex;
        width: 45%;
        flex-direction: column;
        align-items: flex-start;
        gap: 20px;
        flex-shrink: 0;
    }

    .studentadd-once {
        display: flex;
        width: 45%;
        flex-direction: column;
        align-items: flex-start;
        gap: 20px;
        flex-shrink: 0;
    }

    .studentadd-onces {
        display: flex;
        width: 45%;
        justify-content: space-between;
        align-items: center;
    }
</style>