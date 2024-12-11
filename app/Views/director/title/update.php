<link rel="stylesheet" href="<?= base_url(relativePath: 'assets/css/style.css') ?>">

<div class="titleupdate">
    <div class="titleupdate-heading">
        <?= view('components/heading') ?>
    </div>
    <div class="body">
        <div class="body-left">
            <?= view('components/sidebar_director') ?>
        </div>
        <div class="body-right">
            Trung tâm / Quy định / Danh hiệu
            <h1>Cập nhật danh hiệu:</h1>
            <h2>Thông tin danh hiệu:</h2>
            <form method="POST" action="/sms/public/director/title/update">
                <input type="hidden" name="id" value="<?= $title['MaDH'] ?>">
                <div class="titleupdate-fields">
                    <div class="titleupdate-field">
                        Tên danh hiệu
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'title_name',
                            'required' => true,
                            'placeholder' => 'Học sinh Giỏi',
                            'value' => $title['TenDH']
                        ]) ?>
                    </div>
                    <div class="titleupdate-field">
                        Điểm TB tối thiểu
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'min_grade',
                            'required' => true,
                            'placeholder' => '9.0',
                            'value' => $title['DiemTBToiThieu']
                        ]) ?>
                    </div>
                </div>
                <div class="titleupdate-fields">
                    <div class="titleupdate-field">
                        Hạnh kiểm tối thiểu
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'min_conduct',
                            'required' => true,
                            'placeholder' => '90',
                            'value' => $title['DiemHanhKiemToiThieu']
                        ]) ?>
                    </div>
                </div>

                <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success">
                        <?= session()->getFlashdata('success') ?>
                </div>
                <?php elseif (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger">
                        <?= session()->getFlashdata('error') ?>
                    </div>
                <?php endif; ?>

                <div class="titleupdate-btns">
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

    .titleupdate {
        display: flex;
        width: 100%;
        height: 100%;
        flex-direction: column;
        align-items: flex-start;
        background: #FFF;
    }

    .titleupdate-heading {
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

    .titleupdate-fields {
        display: flex;
        width: 100%;
        justify-content: space-between;
        align-items: center;
    }

    .titleupdate-field {
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

    .titleupdate-btns {
        display: flex;
        width: 100%;
        justify-content: flex-end;
        align-items: center;
        gap: 20px;
    }
</style>