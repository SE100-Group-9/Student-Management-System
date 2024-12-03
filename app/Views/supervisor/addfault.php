<link rel="stylesheet" href="<?= base_url(relativePath: 'assets/css/style.css') ?>">

<div class="supervisor-add-fault">
    <?= view('components/heading'); ?>
    <div class="body">
        <?= view('components/sidebar_supervisor'); ?>
        <div class="add-fault-container">
            <h1>Hạnh kiểm / Quản lý hạnh kiểm / Thông tin vi phạm / Tạo bản hạnh kiểm</h1>
            <form method="POST" action=" ">
                <div class="content">
                    <div class="add-fault-info">
                        <div class="group">
                            <label>Khối</label>
                            <?= view('components/dropdown', ['options' => ['Khối 10', 'Khối 11', 'Khối 12'], 'dropdown_id' => 'grade-dropdown']) ?>
                        </div>
                        <div class="group">
                            <label>Lớp</label>
                            <?= view('components/dropdown', ['options' => ['10A1', '10A2', '10A3'], 'dropdown_id' => 'class-dropdown']) ?>
                        </div>
                    </div>
                    <div class="add-fault-info">
                        <div class="group">
                            <label>Mã học sinh</label>
                            <?= view('components/dropdown', ['options' => ['HS001', 'HS002', 'HS003', 'HS004', 'HS005', 'HS006'], 'dropdown_id' => 'id-dropdown']) ?> 
                        </div>
                        <div class="group">
                            <label>Tên học sinh</label>
                            <?= view('components/dropdown', ['options' => ['Nguyễn Văn A', 'Trần Thị B', 'Lê Văn C', 'Trần Văn D', 'Lê Thị E', 'Nguyễn Thị G'], 'dropdown_id' => 'name-dropdown']) ?> 
                        </div>
                    </div>
                </div>
            </form>
            <div class="add-button">
                <a href="/sms/public/supervisor/fault" style="text-decoration: none";>
                    <?= view('components/exit_button') ?>
                </a>
                <?= view('components/save_button') ?>
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

.supervisor-add-fault {
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

.add-fault-container {
    display: flex;
    padding: 20px;
    flex-direction: column;
    align-items: flex-start;
    gap: 20px;
    flex: 1 0 0;
    align-self: stretch;
}

.add-fault-container h1 {
    color: #000;
    font-family: Inter;
    font-size: 16px;
    font-style: normal;
    font-weight: 400;
    line-height: normal;
}

    .content {
        display: flex;
        padding: 20px;
        flex-direction: column;
        align-items: center;
        gap: 20px;
        border-radius: 10px;
    }

    .add-fault-info{
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

    .group label {
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
</style>