<link rel="stylesheet" href="<?= base_url(relativePath: 'assets/css/style.css') ?>">

<div class="statics-grade">
    <div class="grade-heading">
        <?= view('components/heading') ?>
    </div>
    <div class="body">
        <div class="body-left">
            <?= view('components/sidebar_teacher') ?>
        </div>
        <div class="body-right">
            Trung tâm / Thống kê / Học lực
            <!-- Dropdown -->
            <div class="dropdown-edit">
                <?= view('components/dropdown', ['options' => ['2024-2025', '2023-2024']]) ?>
            </div>
            <!-- Cards -->
            <div class="grade-cards">
                <?= view('components/card_increase', [
                    'title' => 'Học lực giỏi',
                    'count' => '4500',
                    'percentage' => '99.99%',
                    'comparison' => 'so với học kỳ II năm 2023'
                ]) ?>
                <?= view('components/card_decrease', [
                    'title' => 'Học lực khá',
                    'count' => '200',
                    'percentage' => '99.99%',
                    'comparison' => 'so với học kỳ II năm 2023'
                ]) ?>
                <?= view('components/card_increase', [
                    'title' => 'Học lực trung bình',
                    'count' => '20.000',
                    'percentage' => '99.99%',
                    'comparison' => 'so với học kỳ II năm 2023'
                ]) ?>
                <?= view('components/card_decrease', [
                    'title' => 'Học lực yếu',
                    'count' => '2000',
                    'percentage' => '99.99%',
                    'comparison' => 'so với học kỳ II năm 2023'
                ]) ?>
            </div>
            <!-- Chart -->
            <div class="grade-chart">
                <div class="charts">
                    Dữ liệu biểu diễn sự thay đổi của học lực theo từng học kỳ
                    <?= view('components/line_chart') ?>
                </div>
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

    .statics-grade {
        display: flex;
        width: 100%;
        height: 100%;
        flex-direction: column;
        align-items: flex-start;
        background: var(--White, #FFF);
    }

    .grade-heading {
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

    .grade-cards {
        display: flex;
        justify-content: space-between;
        align-items: center;
        align-self: stretch;
    }

    .grade-chart {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        align-self: stretch;
    }

    .charts {
        width: 100%;
    }

    .dropdown-edit {
        width: 180px;
    }
</style>