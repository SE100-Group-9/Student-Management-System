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
                        <?= view('components/dropdown', ['options' => ['2023-2024', '2022-2023', '2021-2022'], 'dropdown_id' => 'year-dropdown']) ?>
                    </div>
                    <div class="score-dropdown">
                        <h2>Học kì:</h2>
                        <?= view('components/dropdown', ['options' => ['Học kỳ I', 'Học kỳ II'], 'dropdown_id' => 'semester-dropdown']) ?>
                    </div>
                    <?= view('components/view_button'); ?>
                </div>             
                <div class="tool-export">
                    <?= view('components/excel_export') ?>
                </div>
            </div>
            <div class="table-container" style="display: none;">
                <?= view('components/tables/studentSemesterResult', ['tableId' => 'studentSemesterResult']) ?>
                <?= view('components/pagination'); ?> 
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

.table-container {
    width: 100%;
    margin-bottom: 20px; 
    transition: all 0.3s ease;
}

.score-tool {
    display: flex;
    justify-content: space-between;
    align-self: stretch;
    align-items: center;
    gap: 20px;
    flex-wrap: nowrap;
    padding: 10px;
    background: var(--White, #FFF);
    border-radius: 10px;
}

.score-dropdown {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: nowrap;
}

.score-dropdown h2 {
    color: #000;
    font-family: Inter;
    font-size: 14px;
    font-weight: 700;
    white-space: nowrap; /* Ngăn văn bản bị xuống dòng */
    margin: 0; /* Xóa khoảng cách không cần thiết */
}

.score-dropdown select {
    min-width: 120px;
    max-width: 200px;
}
</style>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const viewButton = document.querySelector('.button-view');
        const tableContainer = document.querySelector('.table-container');

        viewButton.addEventListener('click', () => {
            // Toggle hiển thị bảng
            if (tableContainer.style.display === 'none' || tableContainer.style.display === '') {
                tableContainer.style.display = 'block'; // Hiển thị bảng
            } else {
                tableContainer.style.display = 'none'; // Ẩn bảng
            }
        });
    });
</script>

