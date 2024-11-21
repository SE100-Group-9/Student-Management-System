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
            <h2>Thông tin tài khoản:</h2>
            <div class="studentadd-fields">
                <div class="studentadd-field">
                    Tài khoản
                    <?= view('components/input') ?>
                </div>
                <div class="studentadd-field">
                    Mật khẩu
                    <?= view('components/input') ?>
                </div>
            </div>
            <h2>Thông tin cá nhân:</h2>
            <div class="studentadd-fields">
                <div class="studentadd-field">
                    Họ và tên
                    <?= view('components/input') ?>
                </div>
                <div class="studentadd-field">
                    Email
                    <?= view('components/input') ?>
                </div>
            </div>
            <div class="studentadd-fields">
                <div class="studentadd-field">
                    Số điện thoại
                    <?= view('components/input') ?>
                </div>
                <div class="studentadd-field">
                    Địa chỉ
                    <?= view('components/input') ?>
                </div>
            </div>
            <div class="studentadd-fields">
                <div class="studentadd-specials">
                    <div class="studentadd-special">
                        Giới tính
                        <?= view('components/dropdown', ['options' => ['Nữ', 'Nam', 'Khác'], 'dropdown_id' => 'gender-dropdown']) ?>
                    </div>
                    <div class="studentadd-special">
                        Ngày sinh
                        <?= view('components/datepicker') ?>
                    </div>


                </div>
                <div class="studentadd-onces">
                    <div class="studentadd-once">
                        Dân tộc
                        <?= view('components/input') ?>
                    </div>
                    <div class="studentadd-once">
                        Nơi sinh
                        <?= view('components/input') ?>
                    </div>
                </div>
            </div>
            <h2>Tình trạng học</h2>
            <div class="studentadd-fields">
                <div class="studentadd-specials">
                    <div class="studentadd-special">
                        Lớp học
                        <?= view('components/dropdown', ['options' => ['11A1', '11A2', '11A3'], 'dropdown_id' => 'class-dropdown']) ?>
                    </div>
                </div>
            </div>
            <div class="studentadd-btns">
                <?= view('components/exit_button') ?>
                <?= view('components/save_button') ?>
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