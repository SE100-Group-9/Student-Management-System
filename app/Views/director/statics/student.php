<link rel="stylesheet" href="<?= base_url(relativePath: 'assets/css/style.css') ?>">

<div class="statics-student">
    <div class="student-heading">
        <?= view('components/heading') ?>
    </div>
    <div class="body">
        <div class="body-left">
            <?= view('components/sidebar_director') ?>
        </div>
        <div class="body-right">
            Trung tâm / Thống kê / Học sinh
            <!-- Dropdown -->
            <div class="dropdown-edit">
                <?= view('components/dropdown', ['options' => ['2020', '2021', '2022', '2023', '2024']]) ?>
            </div>
            <!-- Cards -->
            <div class="student-cards">
                <?= view('components/card_increase', [
                    'title' => 'Số học sinh nhập học',
                    'count' => '5000',
                    'percentage' => '100.00%',
                    'comparison' => 'so với năm 2023'
                ]) ?>
                <?= view('components/card_decrease', [
                    'title' => 'Số học sinh bảo lưu',
                    'count' => '200',
                    'percentage' => '100.00%',
                    'comparison' => 'so với năm 2023'
                ]) ?>
                <?= view('components/card_increase', [
                    'title' => 'Tổng số học sinh',
                    'count' => '20.000',
                    'percentage' => '50.00%',
                    'comparison' => 'so với năm 2023'
                ]) ?>
                <?= view('components/card_decrease', [
                    'title' => 'Số học sinh bị cảnh báo',
                    'count' => '2000',
                    'percentage' => '50.00%',
                    'comparison' => 'so với năm 2023'
                ]) ?>
            </div>
            <!-- Chart -->
            <div class="student-chart">
                <div class="chart-text">
                    Dữ liệu biểu diễn sự thay đổi của học sinh theo từng năm
                </div>
                <?= view('components/curve_chart') ?>
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

    .statics-student {
        display: flex;
        width: 100%;
        height: 100%;
        flex-direction: column;
        align-items: flex-start;
        background: var(--White, #FFF);
    }

    .student-heading {
        width: 100%;
        height: 60px;
        position: fixed;
    }

    .body {
        display: flex;
        align-items: flex-start;
        flex: 1 0 0;
        margin-top: 60px;
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
        color: #000;
        font-family: Inter;
        font-size: 16px;
        font-style: normal;
        font-weight: 400;
        line-height: normal;
        overflow-y: auto;
    }

    .student-cards {
        display: flex;
        justify-content: space-between;
        align-items: center;
        align-self: stretch;
    }

    .student-chart {
        display: flex;
        padding: 20px;
        flex-direction: column;
        align-items: flex-start;
        gap: 20px;
        flex: 1 0 0;
        align-self: stretch;
        border-radius: 10px;
        background: var(--White, #FFF);
    }

    .chart-text {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        gap: 31px;
        align-self: stretch;
        color: #000;
        font-family: Inter;
        font-size: 20px;
        font-style: normal;
        font-weight: 400;
        line-height: 24px;
        /* 120% */
    }

    .dropdown-edit {
        width: 180px;
    }
</style>