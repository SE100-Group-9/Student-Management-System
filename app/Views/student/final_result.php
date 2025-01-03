<link rel="stylesheet" href="<?= base_url(relativePath: 'assets/css/style.css') ?>">

<div class="student-final-info">
    <div class="student-final-info-heading">
        <?= view('components/heading') ?>
    </div>
    <div class="body">
        <div class="body-left">
            <?= view('components/sidebar_student') ?>
        </div>
        <div class="body-right">
            <h1>Học tập / Xem kết quả tổng kết</h1>
            <div class="final-tool">
            <form method="GET" action="/sms/public/student/final_result">
                <div class="final-dropdown">
                    <div class="final-dropdown">
                        <h2>Năm học:</h2>
                        <?= view('components/dropdown', [
                            'options' => $yearList, 
                            'dropdown_id' => 'year-dropdown', 
                            'name' => 'year',
                            'selected_text' => 'Chọn năm học',
                            'value' => $selectedYear
                        ]) ?>
                    </div>
                    <div class="final-dropdown">
                        <h2>Học kì:</h2>
                            <?= view('components/dropdown', [
                                'options' => ['Học kỳ 1', 'Học kỳ 2', 'Cả năm'], 
                                'dropdown_id' => 'a-dropdown', 
                                'name' => 'semester',
                                'selected_text' =>   'Chọn học kì',
                                'value' => $selectedSemester
                            ]) ?>
                    </div>                  
                    <?= view('components/view_button'); ?>
                    <div style="display: none">
                    
                    <?= view('components/dropdown', []) ?>
                    </div>
                </div>            
                   
            <h3>Điểm trung bình tổng kết:</h3>
            <div class="student-final-fields">
                    <div class="student-final-field">
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'first_score',
                            'readonly' => true,
                            'value' => $DTB
                        ]) ?>
                    </div>
                </div>
                <h3>Học lực</h3>
                <div class="student-final-fields">
                    <div class="student-final-field">
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'first_performance',
                            'readonly' => true,
                            'value' => $HL
                        ]) ?>
                    </div>
                </div>
                <h3>Hạnh kiểm</h3>
                <div class="student-final-fields">
                    <div class="student-final-field">
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'first_conduct',
                            'readonly' => true,
                            'value' => $HK
                        ]) ?>
                    </div>
                </div>
                <h3>Tổng kết</h3>
                <div class="student-final-fields">
                    <div class="student-final-field">
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'title',
                            'readonly' => true,
                            'value' => $DanhHieu
                        ]) ?>
                    </div>
                </div>
                <h3>Xếp hạng</h3>
                <div class="student-final-fields">
                    <div class="student-final-field">
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'title',
                            'readonly' => true,
                            'value' => $Rank
                        ]) ?>
                    </div>
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

    .student-final-info {
        display: flex;
        width: 100%;
        height: 100%;
        flex-direction: column;
        align-items: flex-start;
        background: #FFF;
    }

    .student-final-info-heading {
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
        font-weight: 400;
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

    .body-right h3 {
        color: #000;
        font-family: Inter;
        font-size: 14px;
        font-style: normal;
        font-weight: 700;
        line-height: normal;
    }

    .student-final-fields {
        display: flex;
        width: 100%;
        justify-content: space-between;
        align-items: center;
    }

    .student-final-field {
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

    .table-container {
        width: 100%;
        margin-top: 20px; /* Khoảng cách với các thành phần phía trên */
        transition: all 0.3s ease; /* Hiệu ứng mượt khi hiển thị */
    }

    .hidden-dropdown {
        display: none;
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
            } 
        });
    });
</script>

