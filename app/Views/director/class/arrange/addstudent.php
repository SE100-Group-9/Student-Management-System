<link rel="stylesheet" href="<?= base_url(relativePath: 'assets/css/style.css') ?>">

<div class="arrangestudentadd">
    <div class="arrangestudentadd-heading">
        <?= view('components/heading') ?>
    </div>
    <div class="body">
        <div class="body-left">
            <?= view('components/sidebar_director') ?>
        </div>
        <div class="body-right">
        Học tập / Lớp học / Lớp <?= esc($TenLop) ?> / Học sinh / Thêm học sinh
            <h2>Thêm học sinh</h2>
            <form method="POST" action="/sms/public/director/class/arrange/addstudent">
                <div class="arrangestudentadd-fields">
                    <div class="arrangestudentadd-field">
                        Năm học
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'student_year',
                            'readonly' => true,
                            'value' => $selectedYear ?? '',
                        ]) ?>
                    </div>
                    <div class="arrangestudentadd-field">
                        Tên lớp
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'student_classname',
                            'readonly' => true,
                            'value' => $TenLop ?? '',
                        ]) ?>
                    </div>
                </div>
                <div class="arrangestudentadd-fields">
                    <div class="arrangestudentadd-field">
                        Thông tin Học sinh
                        <?= view('components/dropdown', [
                            'options' => $studentOptions ?? [],
                            'dropdown_id' => 'studentid-dropdown',
                            'name' => 'student_studentInfo',
                            'selected_text' => 'Mã học sinh - Họ tên - Ngày sinh',
                            'value' => old('student_studentid'),
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
                        <?php foreach (session()->getFlashdata('errors') as $field => $error): ?>
                            <p><?= $error ?>
                            <p>
                            <?php endforeach; ?>
                    </div>
                <?php endif; ?>


                <div class="arrangestudentadd-btns">
                    <a style="text-decoration: none" href="/sms/public/director/class/arrange/student/<?= $MaLop ?>">
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

    .arrangestudentadd {
        display: flex;
        width: 100%;
        height: 100%;
        flex-direction: column;
        align-items: flex-start;
        background: #FFF;
    }

    .arrangestudentadd-heading {
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

    .arrangestudentadd-fields {
        display: flex;
        width: 100%;
        justify-content: space-between;
        align-items: center;
    }

    .arrangestudentadd-field {
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

    .arrangestudentadd-btns {
        display: flex;
        width: 100%;
        justify-content: flex-end;
        align-items: center;
        gap: 20px;
    }
</style>