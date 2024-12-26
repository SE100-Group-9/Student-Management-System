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
            Học tập / Lớp học / Lớp <?= esc($TenLop) ?> / Giáo viên / Thêm giáo viên
            <h1>Thêm giáo viên</h1>
            <h2>Thông tin lớp học</h2>
            <form method="POST" action="/sms/public/director/class/arrange/addteacher">
                <div class="arrangeteacheradd-fields">
                    <div class="arrangeteacheradd-specials">
                        <div class="arrangeteacheradd-special">
                            Năm học
                            <?= view('components/input', [
                                'type' => 'text',
                                'name' => 'teacher_year',
                                'readonly' => true,
                                'value' => $selectedYear ?? '',
                            ]) ?>
                        </div>
                        <div class="arrangeteacheradd-special">
                            Học kỳ
                            <?= view('components/dropdown', [
                                'options' => ['Học kỳ 1', 'Học kỳ 2'],
                                'dropdown_id' => 'semester-dropdown',
                                'selected_text' => 'Chọn học kỳ',
                                'name' => 'teacher_semester',
                                'value' => $selectedSemester ?? ''
                            ]) ?>
                        </div>
                    </div>
                    <div class="arrangeteacheradd-specials">
                        <div class="arrangeteacheradd-special">
                            Tên lớp
                            <?= view('components/input', [
                                'type' => 'text',
                                'name' => 'teacher_classname',
                                'readonly' => true,
                                'value' => $TenLop ?? '',
                            ]) ?>
                        </div>
                    </div>
                </div>
                <h2>Thông tin giáo viên</h2>
                <div class="arrangeteacheradd-fields">
                    <div class="arrangeteacheradd-field">
                        Giáo viên
                        <?= view('components/dropdown', [
                            'options' => $teacherOptions ?? [],
                            'dropdown_id' => 'teacherid-dropdown',
                            'name' => 'teacher_teacherInfo',
                            'selected_text' => 'Mã giáo viên - Họ tên',
                            'value' => old('teacher_teacherInfo'),
                        ]) ?>
                    </div>
                    <div class="arrangeteacheradd-specials">
                        <div class="arrangeteacheradd-special">
                            Môn học
                            <?= view('components/dropdown', [
                                'options' => $subjectList ?? [],
                                'dropdown_id' => 'subject-dropdown',
                                'selected_text' => 'Môn học',
                                'name' => 'teacher_subject',
                                'value' => old('teacher_subject'),
                            ]) ?>
                        </div>
                    </div>
                </div>

                <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success">
                        <?= session()->getFlashdata('success') ?>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('errors')): ?>
                    <div class="alert alert-danger">
                        <?php foreach (session()->getFlashdata('errors') as $field => $error): ?>
                            <p><?= $error ?>
                            <p>
                            <?php endforeach; ?>
                    </div>
                <?php endif; ?>


                <div class="arrangeteacheradd-btns">
                    <a style="text-decoration: none" href="/sms/public/director/class/arrange/teacher/<?= $MaLop ?>">
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

    .arrangeteacheradd-specials {
        display: flex;
        width: 45%;
        justify-content: space-between;
        align-items: flex-start;
    }

    .arrangeteacheradd-special {
        display: flex;
        width: 45%;
        flex-direction: column;
        align-items: flex-start;
        gap: 20px;
        flex-shrink: 0;
    }

    .arrangeteacheradd-btns {
        display: flex;
        width: 100%;
        justify-content: flex-end;
        align-items: center;
        gap: 20px;
    }
</style>