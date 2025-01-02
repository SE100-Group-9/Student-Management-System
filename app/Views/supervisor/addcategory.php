<link rel="stylesheet" href="<?= base_url(relativePath: 'assets/css/style.css') ?>">

<div class="add-category">
    <div class="add-category-heading">
        <?= view('components/heading') ?>
    </div>
    <div class="body">
        <div class="body-left">
            <?= view('components/sidebar_supervisor') ?>
        </div>
        <div class="body-right">
            <h1>Thêm lỗi vi phạm:</h1>
            <h2>Thông tin lỗi vi phạm:</h2>
            <form method="POST" action="/sms/public/supervisor/addcategory">
            <div class="add-category-fields">
                    <div class="add-category-field">
                        Mã giám thị
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'MaGT',
                            'required' => true,
                            'readonly' => true,
                            'value' => $MaGT
                        ]) ?>
                    </div>
                    <div class="add-category-field">
                        Tên giám thị
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'TenGT',
                            'required' => true,
                            'readonly' => true,
                            'value' => $TenGT
                        ]) ?>
                    </div>
                </div>
                <div class="add-category-fields">
                    <div class="add-category-field">
                        Tên loại vi phạm
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'TenLVP',
                            'required' => true,
                            'readonly' => false,
                            'placeholder' => 'Nhập tên vi phạm',
                            'value' => ''
                        ]) ?>
                    </div>
                    <div class="add-category-field">
                        Điểm trừ
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'DiemTru',
                            'required' => true,
                            'placeholder' => 'Nhập điểm trừ',
                            'value' => ''
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

                <div class="add-category-btns">
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

    .add-category {
        display: flex;
        width: 100%;
        height: 100%;
        flex-direction: column;
        align-items: flex-start;
        background: #FFF;
    }

    .add-category-heading {
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

    .add-category-fields {
        display: flex;
        width: 100%;
        justify-content: space-between;
        align-items: center;
    }

    .add-category-field {
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

    .add-category-btns {
        display: flex;
        width: 100%;
        justify-content: center;
        align-items: center;
        gap: 20px;
    }

</style>

