<link rel="stylesheet" href="<?= base_url(relativePath: 'assets/css/style.css') ?>">

<div class="supervisor-add-fault">
    <div class="add-fault-heading">
        <?= view('components/heading') ?>
    </div>
    <div class="body">
        <div class="body-left">
            <?= view('components/sidebar_supervisor') ?>
        </div>
        <div class="body-right">
            <h1>Quản lý / Quản lý hạnh kiểm / Thông tin vi phạm / Chi tiết vi phạm</h1>
            <h2>Thông tin vi phạm</h2>
            <form method="GET" action="/sms/public/supervisor/faultDetail/<?= $viPham['MaVP'] ?>">
                <div class="add-fault-fields">
                    <div class="add-fault-field">
                        Mã học sinh
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'MaHS',
                            'id' => 'student-id', 
                            'required' => true,
                            'readonly' => true,
                            'placeholder' => 'Nhập mã học sinh',
                            'value' => $viPham['MaHS']
                        ]) ?>
                    </div>
                    <div class="add-fault-field">
                        Tên học sinh
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'TenHS',
                            'id' => 'student-name',
                            'required' => true,
                            'readonly' => true,
                            'placeholder' => 'Tên học sinh',
                            'value' => $viPham['TenHS'],
                        ]) ?>
                    </div>
                </div>
                <div class="add-fault-fields">
                    <div class="add-fault-field">
                        Lớp
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'Lop',
                            'id' => 'class', 
                            'required' => true,
                            'readonly' => true,
                            'placeholder' => 'Lớp',
                            'value' => $viPham['TenLop'],
                        ]) ?>
                    </div>
                    <div class="add-fault-field">
                            Người tạo
                            <?= view('components/input', [
                                'type' => 'text',
                                'name' => 'TenGT',
                                'id' => 'student-name',
                                'required' => true,
                                'readonly' => true,
                                'value' => $viPham['TenGT'],
                            ]) ?>
                    </div>
                </div>                
                <div class="add-fault-fields">
                    <div class="add-fault-field">
                            Học kì
                            <?= view('components/input', [
                                'type' => 'text',
                                'name' => 'TenGT',
                                'id' => 'student-name',
                                'required' => true,
                                'readonly' => true,
                                'value' => $viPham['HocKi']
                            ]) ?>
                    </div>
                    <div class="add-fault-field">
                            Năm học
                            <?= view('components/input', [
                                'type' => 'text',
                                'name' => 'TenGT',
                                'id' => 'student-name',
                                'required' => true,
                                'readonly' => true,
                                'value' => $viPham['NamHoc'],
                            ]) ?>
                    </div>
                </div>
                 <div class="add-fault-fields">
                    <div class="add-fault-field">
                                Lỗi vi phạm
                                <?= view('components/input', [
                                    'type' => 'text',
                                    'name' => 'TenGT',
                                    'id' => 'student-name',
                                    'required' => true,
                                    'readonly' => true,
                                    'value' => $viPham['TenLVP'],
                                ]) ?>
                        </div> 
                        <div class="add-fault-field">
                                Ngày vi phạm 
                                <?= view('components/input', [
                                    'type' => 'text',
                                    'name' => 'NgayVP',
                                    'id' => 'student-name',
                                    'required' => true,
                                    'readonly' => true,
                                    'value' => $viPham['NgayVP'],
                                ]) ?>
                        </div>               
                </div>

                <div class="add-button">
                    <a href="/sms/public/supervisor/fault" style="text-decoration: none";>
                        <?= view('components/exit_button') ?>
                    </a>
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

    .add-fault-heading {
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


    #student-id:focus {
        outline: none;
        box-shadow: none;
    }
   


</style>
