<div class="student-final">
    <?= view('components/heading'); ?>
    <div class="body">
        <?= view('components/sidebar_student'); ?>
        <div class="final-container">
            <h1>Học tập / Học tập / Xem điểm</h1>
            <div class="content">
                <div class="final-tool">
                    <div class="final-dropdown">
                        <h2>Năm học:</h2>
                        <?= view('components/dropdown'); ?>
                    </div>
                    <div class="final-dropdown-semester">
                        <h2>Học kì:</h2>
                        <?= view('components/dropdown_semester'); ?> 
                    </div>
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
    align-items: flex-start;
    gap: 10px;
    border-radius: 10px;
}

.final-dropdown, .final-dropdown-semester{
    display: flex;
    align-items: center;
    gap: 10px;
}

.final-dropdown h2, .final-dropdown-semester h2 {
    color: #000;
    font-family: Inter;
    font-size: 14px;
    font-style: normal;
    font-weight: 700;
    line-height: normal;
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
    /* justify-content: space-between;
    align-self: stretch; */
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
</style>
