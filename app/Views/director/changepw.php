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
            <form method="POST" action="/sms/public/director/changepw">
                <div class="changepw-fields">
                    <div class="changepw-field">
                        <div class="changepw-label">
                            Mật khẩu cũ
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path d="M4 17.8V12.2C4 11.0798 4 10.5199 4.21799 10.092C4.40973 9.71572 4.71547 9.40973 5.0918 9.21799C5.51962 9 6.08009 9 7.2002 9H16.8002C17.9203 9 18.48 9 18.9078 9.21799C19.2841 9.40973 19.5905 9.71572 19.7822 10.092C20.0002 10.5199 20 11.0798 20 12.2V17.8C20 18.9201 20.0002 19.4802 19.7822 19.908C19.5905 20.2844 19.2841 20.5902 18.9078 20.782C18.48 21 17.9203 21 16.8002 21H7.2002C6.08009 21 5.51962 21 5.0918 20.782C4.71547 20.5902 4.40973 20.2844 4.21799 19.908C4 19.4802 4 18.9201 4 17.8ZM9 8.76923V6C9 4.34315 10.3431 3 12 3C13.6569 3 15 4.34315 15 6V8.76923C15 8.89668 14.8964 9 14.7689 9H9.23047C9.10302 9 9 8.89668 9 8.76923Z" stroke="#E14177" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </div>
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'old_pw',
                            'required' => true,
                            'placeholder' => 'Nhập mật khẩu cũ',
                            'value' => old('old_pw'),
                        ]) ?>
                    </div>
                    <div class="changepw-field">
                        <div class="changepw-label">
                            Mật khẩu mới
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path d="M4 17.8V12.2C4 11.0798 4 10.5199 4.21799 10.092C4.40973 9.71572 4.71547 9.40973 5.0918 9.21799C5.51962 9 6.08009 9 7.2002 9H16.8002C17.9203 9 18.48 9 18.9078 9.21799C19.2841 9.40973 19.5905 9.71572 19.7822 10.092C20.0002 10.5199 20 11.0798 20 12.2V17.8C20 18.9201 20.0002 19.4802 19.7822 19.908C19.5905 20.2844 19.2841 20.5902 18.9078 20.782C18.48 21 17.9203 21 16.8002 21H7.2002C6.08009 21 5.51962 21 5.0918 20.782C4.71547 20.5902 4.40973 20.2844 4.21799 19.908C4 19.4802 4 18.9201 4 17.8ZM9 8.76923V6C9 4.34315 10.3431 3 12 3C13.6569 3 15 4.34315 15 6V8.76923C15 8.89668 14.8964 9 14.7689 9H9.23047C9.10302 9 9 8.89668 9 8.76923Z" stroke="#E14177" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </div>
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'new_pw',
                            'required' => true,
                            'placeholder' => 'Nhập mật khẩu mới',
                            'value' => old('new_pw'),
                        ]) ?>
                    </div>
                </div>
                <div class="changepw-fields">
                    <div class="changepw-field">
                        <div class="changepw-label">
                            Xác nhận mật khẩu
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path d="M4 17.8V12.2C4 11.0798 4 10.5199 4.21799 10.092C4.40973 9.71572 4.71547 9.40973 5.0918 9.21799C5.51962 9 6.08009 9 7.2002 9H16.8002C17.9203 9 18.48 9 18.9078 9.21799C19.2841 9.40973 19.5905 9.71572 19.7822 10.092C20.0002 10.5199 20 11.0798 20 12.2V17.8C20 18.9201 20.0002 19.4802 19.7822 19.908C19.5905 20.2844 19.2841 20.5902 18.9078 20.782C18.48 21 17.9203 21 16.8002 21H7.2002C6.08009 21 5.51962 21 5.0918 20.782C4.71547 20.5902 4.40973 20.2844 4.21799 19.908C4 19.4802 4 18.9201 4 17.8ZM9 8.76923V6C9 4.34315 10.3431 3 12 3C13.6569 3 15 4.34315 15 6V8.76923C15 8.89668 14.8964 9 14.7689 9H9.23047C9.10302 9 9 8.89668 9 8.76923Z" stroke="#E14177" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </div>
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'confirm_pw',
                            'required' => true,
                            'placeholder' => 'Nhập lại mật khẩu mới',
                            'value' => old('confirm_pw'),
                        ]) ?>
                    </div>
                </div>
                <div class="changepw-fields">
                    <?php if (session()->getFlashdata('success')): ?>
                        <div class="alert alert-success">
                            <?= session()->getFlashdata('success') ?>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('errors')): ?>
                        <div class="alert alert-danger">
                            <?= session()->getFlashdata('error') ?>
                            <?php foreach (session()->getFlashdata('errors') as $error): ?>
                                <p><?= $error ?>
                                <p>
                                <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="changepw-btns">
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
        justify-content: center;
        align-items: center;
        flex-direction: column;
        width: 100%;
        gap: 20px;
    }

    .changepw-field {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        text-align: left;
        width: 50%;
        gap: 10px;
    }

    .changepw-fields input {
        width: 100%;
        max-width: 300px;
    }

    .changepw-label {
        display: flex;
        align-items: flex-end;
        gap: 5px;
    }

    .changepw-btns {
        display: flex;
        width: 100%;
        justify-content: center;
        align-items: center;
        gap: 20px;
    }
</style>