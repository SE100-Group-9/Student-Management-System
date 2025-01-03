<link rel="stylesheet" href="<?= base_url(relativePath: 'assets/css/style.css') ?>">

<div class="classlists">
    <div class="classlists-heading">
        <?= view('components/heading') ?>
    </div>
    <div class="body">
        <div class="body-left">
            <?= view('components/sidebar_director') ?>
        </div>
        <div class="body-right">
            Học tập / Lớp học / Lớp <?= esc($TenLop) ?> / Học sinh
            <div>
                <?= view('components/tab', ['MaLop' => $MaLop, 'activeTab' => 'student']) ?>
            </div>
            <div class="classlists-tools">
                <div class="tools">
                    <a " style=" text-decoration: none;" href="/sms/public/director/class/arrange/addstudent/<?= $MaLop ?>">
                        <?= view('components/add', data: ['button_text' => 'Thêm học sinh']) ?>
                    </a>
                </div>
                <div class="tool-add">
                    <?= view('components/excel_export') ?>
                    <?= view('components/upload') ?>
                </div>
            </div>

            <?php if (session()->getFlashdata('success')) : ?>
                <div style="color: green;"><?= session()->getFlashdata('success') ?></div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('error')) : ?>
                <div style="color: red;"><?= session()->getFlashdata('error') ?></div>
            <?php endif; ?>

            <div class="tabless">
                <?= view('components/tables/directorClassArrangeStudent', [
                    'studentList' => $studentList,
                    'selectedYear' => $selectedYear,
                    'MaLop' => $MaLop
                ]) ?>
            </div>
            <?= view('components/pagination'); ?>
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

    .classlists {
        display: flex;
        width: 100%;
        height: 100%;
        flex-direction: column;
        align-items: flex-start;
        background: #FFF;
    }

    .classlists-heading {
        height: 60px;
        width: 100%;
    }

    .body {
        display: flex;
        align-items: flex-start;
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

    .classlists-tools {
        display: flex;
        padding: 10px;
        justify-content: space-between;
        align-items: flex-start;
        align-self: stretch;
        border-radius: 10px;
        background: #FFF;
    }

    .tools {
        width: 30%;
        display: flex;
        gap: 10px;
    }

    .tool-add {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .tabless {
        width: 100%;
        height: 100%;
    }
</style>