<link rel="stylesheet" href="<?= base_url(relativePath: 'assets/css/style.css') ?>">

<div class="arrangeteacheradd">
    <div class="arrangeteacheradd-heading">
        <?= view('components/heading') ?>
    </div>
    <div class="body">
        <div class="body-left">
            <?= view('components/sidebar_director') ?>
        </div>
        <div class="body-right">
            Học tập / Lớp học / Xếp lớp
            <h1>Thêm giáo viên:</h1>
            <h2>Thông tin giáo viên:</h2>
            <form method="POST" action="/sms/public/director/arrangeteacher/add">
                <div class="arrangeteacheradd-fields">
                    <div class="arrangeteacheradd-field">
                        Mã phân công
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'assignment',
                            'required' => true,
                            'value' => 'PC0001',
                        ]) ?>
                    </div>
                    <div class="arrangeteacheradd-field">
                        Mã giáo viên
                        <?= view('components/dropdown', [
                            'options' => ['GV0001', 'GV0002','GV0003'],
                            'dropdown_id' => 'teacheid-dropdown',
                            'name' => 'teacher_teacheid',
                            'selected_text' => 'Mã giáo viên',
                            'value' => old('teacher_teacheid'),
                        ]) ?>
                    </div>
                </div>
                <div class="arrangeteacheradd-fields">
                    <div class="arrangeteacheradd-field">
                        Mã lớp
                        <?= view('components/dropdown', [
                            'options' => ['11A1', '11A2','11A3'],
                            'dropdown_id' => 'class-dropdown',
                            'name' => 'teacher_class',
                            'selected_text' => 'Mã lớp',
                            'value' => old('teacher_class'),
                        ]) ?>
                    </div>
                    <div class="arrangeteacheradd-field">
                        Học kỳ
                        <?= view('components/dropdown', [
                            'options' => ['Học kỳ I', 'Học kỳ II'],
                            'dropdown_id' => 'semester-dropdown',
                            'selected_text' => 'Học kỳ',
                        ]) ?>
                    </div>
                </div>
                <div class="arrangeteacheradd-fields">
                    <div class="arrangeteacheradd-field">
                        Năm học
                        <?= view('components/dropdown', [
                            'options' => ['2023-2024', '2022-2023', '2021-2022'],
                            'dropdown_id' => 'year-dropdown',
                            'selected_text' => 'Năm học',
                        ]) ?>
                    </div>
                    <div class="arrangeteacheradd-field">
                        Vai trò
                        <?= view('components/dropdown', [
                            'options' => ['Tổ trưởng', 'Tổ phó', 'Giáo viên'],
                            'dropdown_id' => 'role-dropdown',
                            'selected_text' => 'Vai trò',
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


                <div class="arrangeteacheradd-btns">
                    <a style="text-decoration: none" href="/sms/public/director/class/arrange/teacher">
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

    .arrangeteacheradd {
        display: flex;
        width: 100%;
        height: 100%;
        flex-direction: column;
        align-items: flex-start;
        background: #FFF;
    }

    .arrangeteacheradd-heading {
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

    .arrangeteacheradd-fields {
        display: flex;
        width: 100%;
        justify-content: space-between;
        align-items: center;
    }

    .arrangeteacheradd-field {
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

    .arrangeteacheradd-btns {
        display: flex;
        width: 100%;
        justify-content: center;
        align-items: center;
        gap: 20px;
    }
</style>