<div class="student-final">
    <?= view('components/heading'); ?>
    <div class="body">
        <?= view('components/sidebar_student'); ?>
        <div class="final-container">
            <h1>Học tập / Học tập / Xem điểm</h1>
            <div class="content">
                <div class="final-tool">
                    <div class="final-dropdown">
                        <div class="final-dropdown">
                            <h2>Năm học:</h2>
                            <?= view('components/dropdown', ['options' => ['2023-2024', '2022-2023', '2021-2022'], 'dropdown_id' => 'year-dropdown']) ?>
                        </div>
                        <div class="final-dropdown">
                            <h2>Học kì:</h2>
                            <?= view('components/dropdown', ['options' => ['Học kỳ I', 'Học kỳ II'], 'dropdown_id' => 'semester-dropdown']) ?>
                        </div>
                        <?= view('components/view_button'); ?>
                    </div>                   
                </div>
                <div class="table-container" style="display: none;">
                    <?= view('components/tables/studentFinalResult', ['tableId' => 'studentFinalResult']) ?>
                    <?= view('components/pagination'); ?> 
                </div>
                <h3>Điểm trung bình</h3>
                <div class="final-info">
                    <div class="group">
                        <label for="score-1">Học kì 1</label>
                        <?= view('components/input', [
                            'id' => 'score-1',
                            'value' => '10',
                            'readonly' => true
                        ]); ?>
                    </div>
                    <div class="group">
                        <label for="score-2">Học kì 2</label>
                        <?= view('components/input', [
                            'id' => 'score-2',
                            'value' => '10',
                            'readonly' => true
                        ]); ?>
                    </div>
                </div>
                <h3>Học lực</h3>
                <div class="final-info">
                    <div class="group">
                        <label for="perform-1">Học kì 1</label>
                        <?= view('components/input', [
                            'id' => 'perform-1',
                            'value' => 'Giỏi',
                            'readonly' => true
                        ]); ?>
                    </div>
                    <div class="group">
                        <label for="perform-2">Học kì 2</label>
                        <?= view('components/input', [
                            'id' => 'perform-2',
                            'value' => 'Giỏi',
                            'readonly' => true
                        ]); ?>
                    </div>
                </div>
                <h3>Hạnh kiểm</h3>
                <div class="final-info">
                    <div class="group">
                        <label for="conduct-1">Học kì 1</label>
                        <?= view('components/input', [
                            'id' => 'first',
                            'value' => 'Tốt',
                            'readonly' => true
                        ]); ?>
                    </div>
                    <div class="group">
                        <label for="conduct-2">Học kì 2</label>
                        <?= view('components/input', [
                            'id' => 'second',
                            'value' => 'Tốt',
                            'readonly' => true
                        ]); ?>
                    </div>
                </div>
                <h3>Danh hiệu</h3>
                <div class="final-info">
                    <div class="group">
                        <?= view('components/input', [
                            'id' => 'title',
                            'value' => 'Học sinh giỏi',
                            'readonly' => true
                        ]); ?>
                    </div>
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

.student-final {
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

.final-container {
    display: flex;
    padding: 20px;
    flex-direction: column;
    align-items: flex-start;
    gap: 20px;
    flex: 1 0 0;
    align-self: stretch;
}

.final-container h1 {
    color: #000;
    font-family: Inter;
    font-size: 16px;
    font-style: normal;
    font-weight: 400;
    line-height: normal;
}

.final-tool {
    display: flex;
    align-items: center;
    flex-wrap: nowrap;
    gap: 20px;
    padding: 10px;
    justify-content: space-between;
    align-self: stretch;
    border-radius: 10px;
    background: var(--White, #FFF);
}

.final-dropdown{
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: nowrap;
}

.final-dropdown h2{
    color: #000;
    font-family: Inter;
    font-size: 14px;
    font-style: normal;
    font-weight: 700;
    line-height: normal;
    white-space: nowrap; /* Ngăn văn bản bị xuống dòng */
    margin: 0;
}

.final-dropdown select {
    min-width: 120px;
    max-width: 200px;
}

.tool-export {
    margin-left: auto; /* Đẩy nút export sang phải */
}

.content {
    display: flex;
    padding: 20px;
    flex-direction: column;
    align-items: flex-start;
    justify-content: space-between;
    align-self: stretch;
    gap: 20px;
    border-radius: 10px;
    background: var(--White, #FFF);
}

.content h3 {
    color: #000;
    font-family: Inter;
    font-size: 14px;
    font-style: normal;
    font-weight: 700;
    line-height: normal;
}

.final-info{
    display: flex;
    align-items: flex-start;
    gap: 20px;
}

.group {
    display: flex;
    width: 500px;
    max-width: 500px;
    flex-direction: column;
    align-items: flex-start;
    gap: 10px;
}

.group label{
    color: #000;
    font-family: Inter;
    font-size: 14px;
    font-style: normal;
    font-weight: 400;
    line-height: normal;
} 

.table-container {
    width: 100%;
    margin-top: 20px; /* Khoảng cách với các thành phần phía trên */
    transition: all 0.3s ease; /* Hiệu ứng mượt khi hiển thị */
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

