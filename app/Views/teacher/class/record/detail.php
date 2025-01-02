<link rel="stylesheet" href="<?= base_url(relativePath: 'assets/css/style.css') ?>">

<div class="classlists">
    <div class="classlists-heading">
        <?= view('components/heading') ?>
    </div>
    <div class="body">
        <div class="body-left">
            <?= view('components/sidebar_teacher') ?>
        </div>
        <div class="body-right">
            Học tập / Lớp học / Báo cáo học lực lớp
            <div class="classlists-tools">
                <div class="tool-add">
                    <?= view('components/excel_export') ?>
                </div>
            </div>
            <h1>Báo cáo học lực lớp</h1>
            <h1>Năm học: <?= esc($NamHoc) ?></h1>
            <h1>Học kỳ: <?= esc($HocKy) ?></h1>
            <h1>Lớp: <?= esc($TenLop) ?></h1>
            <h1>Môn học: <?= esc($TenMH) ?></h1>
            <h1>Bài kiểm tra: <?= esc($TenBaiKT) ?></h1>
            <h1>Loại Giỏi</h1>
            <div class="tabless">
                <?= view('components/tables/teacherRecordExcellent', ['studentList' => $studentList]) ?>
            </div>
            <h1>Loại Khá</h1>
            <div class="tabless">
                <?= view('components/tables/teacherRecordGood', ['studentList' => $studentList]) ?>
            </div>
            <h1>Loại Trung Bình</h1>
            <div class="tabless">
                <?= view('components/tables/teacherRecordMedium', ['studentList' => $studentList]) ?>
            </div>
            <h1>Loại Yếu</h1>
            <div class="tabless">
                <?= view('components/tables/teacherRecordBad', ['studentList' => $studentList]) ?>
            </div>
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

    .body-right h1 {
        color: #000;
        font-family: Inter;
        font-size: 16px;
        font-style: normal;
        font-weight: 700;
        line-height: normal;
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
        width: 50%;
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