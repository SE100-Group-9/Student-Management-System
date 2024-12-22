<link rel="stylesheet" href="<?= base_url(relativePath: 'assets/css/style.css') ?>">

<div class="supervisor-add-fault">
    <div class="add-category-heading">
        <?= view('components/heading') ?>
    </div>
    <div class="body">
        <div class="body-left">
            <?= view('components/sidebar_supervisor') ?>
        </div>
        <div class="body-right">
            <h1>Thêm vi phạm</h1>
            <h2>Thông tin vi phạm</h2>
            <form method="POST" action=" ">
                <div class="add-fault-fields">
                    <div class="add-fault-field">
                        Mã học sinh
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'student-id',
                            'required' => true,
                            'value' => old('student-id'),
                        ]) ?>
                    </div>
                    <div class="add-fault-field">
                        Tên học sinh
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'student-name',
                            'required' => true,
                            'readonly'=> true,
                            'value' => 'Nguyễn Văn A',
                        ]) ?>
                    </div>
                </div>
                <div class="add-fault-fields">
                    <div class="add-fault-field">
                        Khối
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'grade',
                            'readonly' => true,
                            'value' => '11',
                        ]) ?>
                    </div>
                    <div class="add-fault-field">
                        Lớp
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'class',
                            'readonly' => true,
                            'value' => '11A1',
                        ]) ?>
                    </div>
                </div>
                <div class="add-fault-fields">
                    <div class="add-fault-field">
                        Học kỳ
                        <?= view('components/dropdown', [
                            'options' => ['Học kỳ I', 'Học kỳ II'],
                            'dropdown_id' => 'semester-dropdown',
                            'name' => 'semester',
                            'selected_text' => 'Học kỳ',
                            'value' => old('semester'),
                        ]) ?>
                    </div>
                    <div class="add-fault-field">
                        Lỗi vi phạm
                        <?= view('components/dropdown', [
                            'options' => ['1 - Đi trễ', '2 - Không mang phù hiệu', '3 - Không thuộc bài'],
                            'dropdown_id' => 'category-dropdown',
                            'name' => 'student_category',
                            'selected_text' => 'Lỗi vi phạm',
                            'value' => old('student_category'),
                        ]) ?>
                    </div>
                    <div class="hidden-dropdown">
                        <?= view('components/dropdown', ['options' => ['11A1', '11A2'], 'dropdown_id' => 'class-dropdown'])?>
                    </div>
                </div>
                <div class="add-button">
                    <a href="/sms/public/supervisor/fault" style="text-decoration: none";>
                        <?= view('components/exit_button') ?>
                    </a>
                    <?= view('components/save_button') ?>
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

    .supervisor-add-fault {
        display: flex;
        flex-direction: column; 
        width: 100%;
        height: 100%;
        overflow: auto; 
    }

    .add-category-heading {
        width: 100%;
        height: 60px;
    }

    .body {
        display: flex;
        align-items: flex-start;
        flex: 1 0 0;
        align-self: stretch;
        background: #FFF;
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
        font-weight: 700;
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

    .add-fault-fields {
        display: flex;
        width: 100%;
        justify-content: space-between;
        align-items: center;
    }

    .add-fault-field {
        display: flex;
        width: 45%;
        flex-direction: column;
        align-items: flex-start;
        gap: 20px;
        flex-shrink: 0;
        color: #000;
        font-family: Inter;
        font-size: 14px;
        font-style: normal;
        font-weight: 500;
        line-height: normal;
    }

    .add-button {
        display: flex;
        width: 100%;
        justify-content: center;
        align-items: center;
        gap: 20px;
    }

    .hidden-dropdown {
        display: none;
    }
</style>