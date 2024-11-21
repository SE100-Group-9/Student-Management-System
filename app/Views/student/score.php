<div class="student-score">
    <?= view('components/heading'); ?>
    <div class="body">
        <?= view('components/sidebar_student'); ?>
        <div class="score-container">
            <h1>Học tập / Học tập / Xem điểm</h1>
            <div class="score-tool">
                <div class="score-dropdown">
                    <div class="score-dropdown">
                        <h2>Năm học:</h2>
                        <?= view('components/dropdown', ['options' => ['2020', '2021', '2022', '2023', '2024']]) ?>
                    </div>
                    <div class="score-dropdown-semester">
                        <h2>Học kì:</h2>
                        <?= view('components/dropdown_2', ['options' => ['Học kì 1', 'Học kì 2', 'Cả năm']]) ?> 
                    </div>
                </div>
                <div class="tool-export">
                    <?= view('components/excel_export') ?>
                </div>
            </div>
            <?= view('components/tables/studentSemesterResult', ['tableId' => 'studentSemesterResult']) ?>
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

.student-score {
    display: flex;
    flex-direction: column; 
    width: 100%;
    height: 100%;
    overflow: auto;
    
}

.body {
    display: flex; 
    flex-direction: row; 
    background: #F0F2F5;
    height: 100%;
}

.heading {
    padding: 20px;
    width: 100%;
    box-sizing: border-box;
}

.score-container {
    display: flex;
    padding: 20px;
    flex-direction: column;
    align-items: flex-start;
    gap: 20px;
    flex: 1 0 0;
    align-self: stretch;
}

.score-container h1 {
    color: #000;
    font-family: Inter;
    font-size: 16px;
    font-style: normal;
    font-weight: 400;
    line-height: normal;
}

.score-container table {
    width: 100%;
    margin-bottom: 20px; /* Khoảng cách giữa table và pagination */
}

.score-tool {
    display: flex;
    padding: 10px;
    align-items: flex-start;
    justify-content: space-between;
    align-self: stretch;
    border-radius: 10px;
    background: var(--White, #FFF);
}

.score-dropdown {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    border-radius: 10px;
}

.score-dropdown, .score-dropdown-semester{
    display: flex;
    align-items: center;
    gap: 10px;
}

.score-dropdown h2, .score-dropdown-semester h2 {
    color: #000;
    font-family: Inter;
    font-size: 14px;
    font-style: normal;
    font-weight: 700;
    line-height: normal;
}
</style>
