<link rel="stylesheet" href="<?= base_url(relativePath: 'assets/css/style.css') ?>">

<div class="classupdate">
    <div class="classupdate-heading">
        <?= view('components/heading') ?>
    </div>
    <div class="body">
        <div class="body-left">
            <?= view('components/sidebar_director') ?>
        </div>
        <div class="body-right">
            Học tập / Lớp học / Danh sách
            <h1>Tạo hồ sơ:</h1>
            <form method="POST" action="/sms/public/director/class/add">
                <h2>Thông tin lớp học:</h2>
                <div class="classupdate-fields">
                    <div class="classupdate-field">
                        Tên lớp
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'class_name',
                            'required' => true,
                            'placeholder' => '11A1'
                        ]) ?>
                    </div>
                    <div class="classupdate-field">
                        Tên giáo viên chủ nhiệm
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'class_teacher',
                            'required' => true,
                            'placeholder' => 'Nguyễn Khánh Huy'
                        ]) ?>
                    </div>
                </div>
                <div class="classupdate-fields">
                    <div class="classupdate-specials">
                        <div class="classupdate-special">
                            Khối
                            <?= view('components/dropdown', [
                                'options' => ['10', '11', '12'],
                                'dropdown_id' => 'grade-dropdown',
                                'name' => 'class-grade',
                                'selected_text' => 'Khối',
                            ]) ?>
                        </div>
                    </div>

                </div>
                <div class="classupdate-btns">
                    <a style="text-decoration: none" href="/sms/public/director/class/list">
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

    .classupdate {
        display: flex;
        width: 100%;
        height: 100%;
        flex-direction: column;
        align-items: flex-start;
        background: #FFF;
    }

    .classupdate-heading {
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

    .classupdate-fields {
        display: flex;
        width: 100%;
        justify-content: space-between;
        align-items: center;
    }

    .classupdate-field {
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

    .classupdate-btns {
        display: flex;
        width: 100%;
        justify-content: flex-end;
        align-items: center;
        gap: 20px;
    }

    .classupdate-specials {
        display: flex;
        width: 45%;
        justify-content: space-between;
        align-items: flex-start;
    }

    .classupdate-special {
        display: flex;
        width: 45%;
        flex-direction: column;
        align-items: flex-start;
        gap: 20px;
        flex-shrink: 0;
    }

    .classupdate-once {
        display: flex;
        width: 45%;
        flex-direction: column;
        align-items: flex-start;
        gap: 20px;
        flex-shrink: 0;
    }

    .classupdate-onces {
        display: flex;
        width: 45%;
        justify-content: space-between;
        align-items: center;
    }
</style>