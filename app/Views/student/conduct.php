<div class="student-conduct">
    <?= view('components/heading'); ?>
    <div class="body">
        <?= view('components/sidebar_student'); ?>
        <div class="conduct-container">
            <h1>Học tập / Học tập / Xem hạnh kiểm</h1>
            <div class="conduct-tool">
                <div class="conduct-dropdown">
                    <div class="conduct-dropdown">
                        <h2>Năm học:</h2>
                        <?= view('components/dropdown', ['options' => ['2020', '2021', '2022', '2023', '2024']]) ?>
                    </div>
                    <div class="conduct-dropdown-semester">
                        <h2>Học kì:</h2>
                        <?= view('components/dropdown_2', ['options' => ['Học kì 1', 'Học kì 2', 'Cả năm']]) ?> 
                    </div>
                </div>
                <div class="tool-export">
                    <?= view('components/excel_export') ?>
                </div>
            </div>
            <?= view('components/tables/studentConduct') ?>
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

.student-conduct {
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

.conduct-container {
    display: flex;
    padding: 20px;
    flex-direction: column;
    align-items: flex-start;
    gap: 20px;
    flex: 1 0 0;
    align-self: stretch;
}

.conduct-container h1 {
    color: #000;
    font-family: Inter;
    font-size: 16px;
    font-style: normal;
    font-weight: 400;
    line-height: normal;
}

.conduct-container table {
    width: 100%;
    margin-bottom: 20px;
}

.conduct-tool {
    display: flex;
    padding: 10px;
    align-items: flex-start;
    justify-content: space-between;
    align-self: stretch;
    border-radius: 10px;
    background: var(--White, #FFF);
}

.conduct-dropdown {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    border-radius: 10px;
}

.conduct-dropdown, .conduct-dropdown-semester{
    display: flex;
    align-items: center;
    gap: 10px;
}

.conduct-dropdown h2, .conduct-dropdown-semester h2 {
    color: #000;
    font-family: Inter;
    font-size: 14px;
    font-style: normal;
    font-weight: 700;
    line-height: normal;
}
</style>
