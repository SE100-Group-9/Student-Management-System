<link rel="stylesheet" href="<?= base_url(relativePath: 'assets/css/style.css') ?>">

<div class="changepw">
    <div class="changepw-heading">
        <?= view('components/heading') ?>
    </div>
    <div class="body">
        <div class="body-left">
            <?= view('components/sidebar_director') ?>
        </div>
        <div class="body-right">
            <h1>Đổi mật khẩu:</h1>
            <h2>Thông tin mật khẩu:</h2>
            <form method="POST" action=" ">
                <div class="changepw-fields">
                    <div class="changepw-field">
                        Mật khẩu cũ
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'old_pw',
                            'required' => true,
                            'placeholder' => 'Nhập mật khẩu cũ'
                        ]) ?>
                    </div>
                    <div class="changepw-field">
                        Mật khẩu mới
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'new_pw',
                            'required' => true,
                            'placeholder' => 'Nhập mật khẩu mới'
                        ]) ?>
                    </div>
                </div>
                <div class="changepw-fields">
                    <div class="changepw-field">
                        Xác nhận mật khẩu
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'confirm_pw',
                            'required' => true,
                            'placeholder' => 'Nhập lại mật khẩu mới'
                        ]) ?>
                    </div>
                </div>
                <div class="changepw-btns">
                    <a href="/sms/public/director/statics/conduct" style="text-decoration: none";>
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

    .changepw {
        display: flex;
        width: 100%;
        height: 100%;
        flex-direction: column;
        align-items: flex-start;
        background: #FFF;
    }

    .changepw-heading {
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

    .changepw-fields {
        display: flex;
        width: 100%;
        justify-content: space-between;
        align-items: center;
    }

    .changepw-field {
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

    .changepw-btns {
        display: flex;
        width: 100%;
        justify-content: flex-end;
        align-items: center;
        gap: 20px;
    }
</style>