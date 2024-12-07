<link rel="stylesheet" href="<?= base_url(relativePath: 'assets/css/style.css') ?>">

<div class="director-profile">
    <div class="director-profile-heading">
        <?= view('components/heading') ?>
    </div>
    <div class="body">
        <div class="body-left">
            <?= view('components/sidebar_director') ?>
        </div>
        <div class="body-right">
            <h2>Thông tin cá nhân:</h2>
            <form method="POST" action=" ">
                <div class="director-profile-fields">
                    <div class="director-profile-field">
                        Mã nhân viên
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'director_id',
                            'readonly' => true,
                            'value' => 'GT0001'
                        ]) ?>
                    </div>
                    <div class="director-profile-field">
                        Họ tên
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'director_name',
                            'readonly' => true,
                            'value' => 'Nguyễn Văn A'
                        ]) ?>
                    </div>
                </div>
                <div class="director-profile-fields">
                    <div class="director-profile-field">
                        Giới tính
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'director_sex',
                            'readonly' => true,
                            'value' => 'Nam'
                        ]) ?>
                    </div>
                    <div class="director-profile-field">
                        Ngày sinh
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'director_date-of-birth',
                            'readonly' => true,
                            'value' => '01-01-2000'
                        ]) ?>
                    </div>
                </div>
                <div class="director-profile-fields">
                    <div class="director-profile-field">
                        Địa chỉ
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'director_address',
                            'readonly' => true,
                            'value' => 'TPHCM'
                        ]) ?>
                    </div>
                    <div class="director-profile-field">
                        Số điện thoại
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'director_phone',
                            'readonly' => true,
                            'value' => '0123456789'
                        ]) ?>
                    </div>
                </div>
                <div class="director-profile-fields">
                    <div class="director-profile-field">
                        Email
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'director_email',
                            'readonly' => true,
                            'value' => 'hieutruong@gmail.com'
                        ]) ?>
                    </div>
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

    .director-profile {
        display: flex;
        width: 100%;
        height: 100%;
        flex-direction: column;
        align-items: flex-start;
        background: #FFF;
    }

    .director-profile-heading {
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

    .director-profile-fields {
        display: flex;
        width: 100%;
        justify-content: space-between;
        align-items: center;
    }

    .director-profile-field {
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