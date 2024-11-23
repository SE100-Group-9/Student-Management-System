<div class="statics-grade">
    <div class="grade-heading">
        <?= view('components/heading') ?>
    </div>
    <div class="body">
        <div class="body-left">
            <?= view('components/sidebar_director') ?>
        </div>
        <div class="body-right">
            Trung tâm / Thống kê / Học lực
            <!-- Dropdown -->
            <div class="dropdown-edit">
                <?= view('components/dropdown', ['options' => ['2020', '2021', '2022', '2023', '2024']]) ?>
            </div>
            <!-- Cards -->
            <div class="grade-cards">
                <?= view('components/card_increase', [
                    'title' => 'Học lực giỏi',
                    'count' => '5000',
                    'percentage' => '100.00%',
                    'comparison' => 'so với năm 2023'
                ]) ?>
                <?= view('components/card_decrease', [
                    'title' => 'Học lực khá',
                    'count' => '200',
                    'percentage' => '100.00%',
                    'comparison' => 'so với năm 2023'
                ]) ?>
                <?= view('components/card_increase', [
                    'title' => 'Học lực trung bình',
                    'count' => '20.000',
                    'percentage' => '50.00%',
                    'comparison' => 'so với năm 2023'
                ]) ?>
                <?= view('components/card_decrease', [
                    'title' => 'Học lực yếu',
                    'count' => '2000',
                    'percentage' => '50.00%',
                    'comparison' => 'so với năm 2023'
                ]) ?>
            </div>
            <!-- Chart -->
            <div class="grade-chart">
                <div class="charts">
                    <?= view('components/pie_chart') ?>
                </div>
                <div class="grade-statics">
                    Danh sách học sinh đứng đầu khối
                    <?= view('components/tables/directorStaticsGrade') ?>
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
        width: 50%;
    }

    .grade-statics {
        width: 50%;
        display: flex;
        padding: 10px;
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
        flex: 1 0 0;
        align-self: stretch;
        background: #FFF;
        color: #000;
        font-family: Inter;
        font-size: 20px;
        font-style: normal;
        font-weight: 700;
        line-height: normal;
    }

    .dropdown-edit {
        width: 180px;
    }
</style>