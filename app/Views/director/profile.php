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
            <form method="POST" action="/sms/public/director/profile">
                <div class="director-profile-fields">
                    <input type="hidden" name="MaBGH" value="<?= $director['MaBGH'] ?? '' ?>">
                    <input type="hidden" name="MaTK" value="<?= $director['MaBGH'] ?? '' ?>">

                    <div class="director-profile-field">
                        Mã Ban Giám Hiệu
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'director_id',
                            'readonly' => true,
                            'value' => $director['MaBGH'],
                        ]) ?>
                    </div>
                    <div class="director-profile-field">
                        Họ tên
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'director_name',
                            'readonly' => true,
                            'value' => $director['HoTen'],
                        ]) ?>
                    </div>
                </div>
                <div class="director-profile-fields">
                    <div class="director-profile-field">
                        Giới tính
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'director_gender',
                            'readonly' => true,
                            'value' => $director['GioiTinh'],
                        ]) ?>
                    </div>
                    <div class="director-profile-field">
                        Ngày sinh
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'director_birthday',
                            'readonly' => true,
                            'value' => date('d/m/Y', strtotime($director['NgaySinh'])),
                        ]) ?>
                    </div>
                </div>
                <div class="director-profile-fields">
                    <div class="director-profile-field">
                        Địa chỉ
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'director_address',
                            'readonly' => false,
                            'required' => true,
                            'value' => $director['DiaChi'],
                        ]) ?>
                    </div>
                    <div class="director-profile-field">
                        Số điện thoại
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'director_phone',
                            'required' => true,
                            'readonly' => false,
                            'value' => $director['SoDienThoai'],
                        ]) ?>
                    </div>
                </div>
                <div class="director-profile-fields">
                    <div class="director-profile-field">
                        Email
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'director_email',
                            'readonly' => false,
                            'required' => true,
                            'value' => $director['Email'],
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

                <div class="directoradd-btns">
                    <a style="text-decoration: none" href="/sms/public/director/title/list">
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

    .directoradd-btns {
        display: flex;
        width: 100%;
        justify-content: flex-end;
        align-items: center;
        gap: 20px;
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