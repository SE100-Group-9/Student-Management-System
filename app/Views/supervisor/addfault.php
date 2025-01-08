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
            <h1>Thêm vi phạm</h1>
            <h2>Thông tin vi phạm</h2>
            <form method="POST" action="/sms/public/supervisor/addfault/<?= $HanhKiem['MaHK'] ?>">
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
                            'value' =>  $HanhKiem['MaHS']
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
                            'value' => $HanhKiem['TenHS']
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
                            'value' => $HanhKiem['Lop']
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
                                'value' => $TenGT
                            ]) ?>
                    </div>
                </div>                
                <div class="add-fault-fields">
                <div class="add-fault-field">
                        Học kì
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'HocKi',
                            'id' => 'student-name',
                            'required' => true,
                            'readonly' => true,
                            'placeholder' => 'Tên học sinh',
                            'value' => $HanhKiem['HocKy']
                        ]) ?>
                    </div>
                    <div class="add-fault-field">
                        Năm học
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'NamHoc',
                            'id' => 'student-name',
                            'required' => true,
                            'readonly' => true,
                            'placeholder' => 'Tên học sinh',
                            'value' => $HanhKiem['NamHoc'],
                        ]) ?>
                    </div>
                </div>
                 <div class="add-fault-fields">
                   
                        <div class="add-fault-field">
                                    Lỗi vi phạm
                                <?= view('components/dropdown', [
                                    'options' => $LVP ?? '',
                                    'dropdown_id' => 'fault-dropdown',
                                    'name' => 'Loi',
                                    'value' => '',
                                ]) ?>
                        </div>                
                </div>

                <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success">
                        <?= session()->getFlashdata('success') ?>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('errors')): ?>
                    <div class="alert alert-danger">
                        <?= session()->getFlashdata('error') ?>
                        <?php foreach (session()->getFlashdata('errors') as $error): ?>
                            <p><?= $error ?><p>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                <div class="add-button">
                    <a href="/sms/public/supervisor/conduct" style="text-decoration: none";>
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
        justify-content: right;
        align-items: right;
        gap: 20px;
    }


    #student-id:focus {
        outline: none;
        box-shadow: none;
    }
   


</style>
