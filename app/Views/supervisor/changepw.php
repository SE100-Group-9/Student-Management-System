<link rel="stylesheet" href="<?= base_url(relativePath: 'assets/css/style.css') ?>">

<div class="change-pw">
    <?= view('components/heading'); ?>
    <div class="body">
        <?= view('components/sidebar_supervisor'); ?>
        <div class="change-pw-container">
            <form method="POST" action=" ">
                <div class="content">
                    <div class="add-wrap">
                        <h1>Thay đổi mật khẩu</h1>
                        <div class="add-info">
                            <div class="group">
                                <label for="old-pw">Mật khẩu cũ</label>
                                <?= view('components/input', [
                                    'id' => 'old-pw',
                                    'readonly' => false
                                ]); ?>
                            </div>
                        </div>
                        <div class="add-info">
                            <div class="group">
                                <label for="new-pw">Mật khẩu mới</label>
                                <?= view('components/input', [
                                    'id' => 'new-pw',
                                    'readonly' => false
                                ]); ?>
                            </div>
                        </div> 
                        <div class="add-info">
                            <div class="group">
                                <label for="confirm-pw">Nhập lại mật khẩu mới</label>
                                <?= view('components/input', [
                                    'id' => 'confirm-pw',
                                    'readonly' => false
                                ]); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <div class="add-button">
                <a href="/sms/public/supervisor/dashboard" style="text-decoration: none";>
                    <?= view('components/exit_button') ?>
                </a>
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

    .change-pw {
        display: flex;
        flex-direction: column;
        width: 100%;
        height: 100%;
        overflow: auto;
        align-items: flex-start;
    }

    .body {
        display: flex;
        align-items: flex-start;
        gap: 20px;
        flex: 1 0 0;
        align-self: stretch;
        background: var(--light-grey, #F9FAFB);
    }

    .change-pw-container {
        display: flex;
        padding: 0px 20px;
        flex-direction: column;
        align-items: center;
        gap: 30px;
        flex: 1 0 0;
        align-self: stretch;
    }

    .change-pw-container h1{
        color: #000;
        font-family: Inter;
        font-size: 16px;
        font-style: normal;
        font-weight: 600;
        line-height: normal;
    }

    .content {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        border-radius: 10px;
    }

    .add-wrap {
        display: flex; 
        flex-direction: column; 
        padding: 20px;
        width: 100%;
        max-width: 600px; 
        background: #fff;
        border-radius: 10px;
        gap: 30px;
    }

    .add-info{
        display: flex;
        align-items: flex-start;
        gap: 20px;
    }

    .group {
        display: flex;
        width: 500px;
        max-width: 500px;
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
    }

    .group label{
        color: #000;
        font-family: Inter;
        font-size: 14px;
        font-style: normal;
        font-weight: 500;
        line-height: normal;
    }

    .add-button {
        display: flex;
        width: 100%;
        justify-content: center;
        align-items: center;
        gap: 20px;
    }
</style>