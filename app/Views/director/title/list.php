<link rel="stylesheet" href="<?= base_url(relativePath: 'assets/css/style.css') ?>">

<div class="titlelist">
    <div class="titlelist-heading">
        <?= view('components/heading') ?>
    </div>
    <div class="body">
        <div class="body-left">
            <?= view('components/sidebar_director') ?>
        </div>
        <div class="body-right">
            <div class="titlelist-tools">
                <div class="tools">
                    <?= view('components/searchbar') ?>
                </div>
                <a style="text-decoration: none" href="/sms/public/director/title/add">
                    <?= view('components/add', ['button_text' => 'Thêm danh hiệu']) ?>
                </a>
            </div>
            <?= view('components/tables/directorTitleList', ['titleList' => $titleList]) ?>
            <form method="POST" action="/sms/public/director/title/list">
                <h2>Cập nhật quy định:</h2>
                <div class="rule-update-fields">
                    <div class="rule-update-field">
                        Mức học phí năm học (VNĐ)
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'student_fee',
                            'readonly' => false,
                            'required' => true,
                            'placeholder' => '3000000',
                            'value' => $HocPhi,
                        ]) ?>
                    </div>
                    <div class="rule-update-field">
                        Số học sinh tối đa trong một lớp
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'student_quantity',
                            'readonly' => false,
                            'required' => true,
                            'placeholder' => '35',
                            'value' => $SiSoLopToiDa,
                        ]) ?>
                    </div>
                </div>

                <?php if (session()->getFlashdata('success')) : ?>
                    <div style="color: green;"><?= session()->getFlashdata('success') ?></div>
                <?php endif; ?>
                <?php if (session()->getFlashdata('error')) : ?>
                    <div style="color: red;"><?= session()->getFlashdata('error') ?></div>
                <?php endif; ?>

                <div class="rule-update-btns">
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

    .titlelist {
        display: flex;
        width: 100%;
        height: 100%;
        flex-direction: column;
        align-items: flex-start;
        background: #FFF;
    }

    .titlelist-heading {
        height: 60px;
        width: 100%;
    }

    .body {
        display: flex;
        align-items: flex-start;
        gap: 20px;
        flex: 1 0 0;
        align-self: stretch;
        background: #F9FAFB;
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
        color: #000;
        font-family: Inter;
        font-size: 16px;
        font-style: normal;
        font-weight: 400;
        line-height: normal;
        overflow-y: auto;
    }

    .body-right h2 {
        color: var(--Cerulean, #01B3EF);
        font-family: Inter;
        font-size: 16px;
        font-style: normal;
        font-weight: 700;
        line-height: normal;
    }

    .titlelist-tools {
        display: flex;
        padding: 10px;
        align-items: flex-start;
        gap: 10px;
        align-self: stretch;
        border-radius: 10px;
        background: #FFF;
    }

    .rule-update-fields {
        display: flex;
        width: 100%;
        justify-content: space-between;
        align-items: center;
    }

    .rule-update-field {
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

    .tools {
        width: 50%;
        display: flex;
        gap: 10px;
    }

    .rule-update-btns {
        display: flex;
        width: 100%;
        justify-content: flex-end;
        align-items: center;
        gap: 20px;
    }
</style>