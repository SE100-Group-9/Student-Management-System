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
            <form method="POST" action=" ">
                <div class="update-category-fields">
                    <div class="update-category-field">
                        Mã vi phạm 
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'category_id',
                            'readonly' => true,
                            'value' => '01'
                        ]) ?>
                    </div>
                    <div class="update-category-field">
                        Tên vi phạm
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'category_name',
                            'required' => true,
                            'readonly' => false,
                            'value' => 'Đi trễ'
                        ]) ?>
                    </div>
                </div>
                <div class="update-category-fields">
                    <div class="update-category-field">
                        Điểm trừ
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'minus_point',
                            'required' => true,
                            'value' => '1'
                        ]) ?>
                    </div>
                </div>
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