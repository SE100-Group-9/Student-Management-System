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
                        <label>Khối</label>
                        <?= view('components/dropdown', ['options' => ['Khối 10', 'Khối 11', 'Khối 12'], 'dropdown_id' => 'grade-dropdown']) ?>
                        <label>Lớp</label>
                        <?= view('components/dropdown', ['options' => ['10A1', '10A2', '10A3'], 'dropdown_id' => 'class-dropdown']) ?>
                    </div>
                    <div class="add-fault-field">
                            <label>Mã học sinh</label>
                            <?= view('components/dropdown', ['options' => ['HS001', 'HS002', 'HS003', 'HS004', 'HS005', 'HS006'], 'dropdown_id' => 'id-dropdown']) ?> 
                            <label>Tên học sinh</label>
                            <?= view('components/dropdown', ['options' => ['Nguyễn Văn A', 'Trần Thị B', 'Lê Văn C', 'Trần Văn D', 'Lê Thị E', 'Nguyễn Thị G'], 'dropdown_id' => 'name-dropdown']) ?> 
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