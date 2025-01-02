<link rel="stylesheet" href="<?= base_url(relativePath: 'assets/css/style.css') ?>">

<div class="update-category">
    <div class="update-category-heading">
        <?= view('components/heading') ?>
    </div>
    <div class="body">
        <div class="body-left">
            <?= view('components/sidebar_supervisor') ?>
        </div>
        <div class="body-right">
            <h1>Cập nhật lỗi vi phạm:</h1>
            <h2>Thông tin lỗi vi phạm:</h2>
            <form method="POST" action="/sms/public/supervisor/updatecategory/<?= $loaivipham['MaLVP']?>">
                <div class="update-category-fields">
                    <div class="update-category-field">
                        Mã vi phạm 
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'MaLVP',
                            'readonly' => true,
                            'value' => $loaivipham['MaLVP']
                        ]) ?>
                    </div>
                    <div class="update-category-field">
                        Tên vi phạm
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'TenLVP',
                            'required' => true,
                            'readonly' => false,
                            'value' => $loaivipham['TenLVP']
                        ]) ?>
                    </div>
                </div>
                <div class="update-category-fields">
                    <div class="update-category-field">
                        Điểm trừ
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'DiemTru',
                            'required' => true,
                            'readonly' => false,
                            'value' => $loaivipham['DiemTru']
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
                
                <div class="update-category-btns">
                    <a href="/sms/public/supervisor/category" style="text-decoration: none";>
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

    .update-category {
        display: flex;
        width: 100%;
        height: 100%;
        flex-direction: column;
        align-items: flex-start;
        background: #FFF;
    }

    .update-category-heading {
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

    .update-category-fields {
        display: flex;
        width: 100%;
        justify-content: space-between;
        align-items: center;
    }

    .update-category-field {
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

    .update-category-btns {
        display: flex;
        width: 100%;
        justify-content: center;
        align-items: center;
        gap: 20px;
    }
</style>