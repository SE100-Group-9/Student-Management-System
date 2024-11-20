<div class="cashier-add-extense">
    <?= view('components/heading'); ?>
    <div class="body">
        <?= view('components/sidebar_cashier'); ?>
        <div class="add-extense-container">
            <p>Học phí / Quản lý học phí / Danh sách / Tạo phiên gia hạn</p>
            <div class="content">
                <div class="add-extense-info">
                    <div class="group">
                        <label for="id_pay">Mã thanh toán</label>
                        <?= view('components/input', [
                            'id' => 'id_pay',
                            'value' => 'HD001',
                            'readonly' => true
                        ]); ?>
                    </div>
                    <div class="group">
                        <label for="id">Mã học sinh</label>
                        <?= view('components/input', [
                            'id' =>'id',
                            'value' => '22520xxx',
                            'readonly' => true
                        ]); ?>
                    </div>                   
                </div>
                <div class="add-extense-info">
                    <div class="group">
                        <label for="name">Tên hoc sinh</label>
                        <?= view('components/input', [
                            'id' => 'name',
                            'value' => 'Nguyễn Văn A',
                            'readonly' => true
                        ]); ?>
                    </div>                
                </div>
                <div class="add-extense-info">
                    <div class="group">
                        <label for="amount">Số tiền</label>
                        <?= view('components/input', [
                            'id' => 'amount',
                            'value' => '',
                            'readonly' => false,
                            'placeholder' => 'Nhập số tiền' 
                        ]); ?> 
                    </div>
                    <div class="group">
                        <label for="date-expired">Ngày hết hạn</label>
                        <?= view('components/datepicker'); ?>
                    </div>                    
                </div>
                <div class="extense-button">
                    <?= view('components/exit_button'); ?>
                    <?= view('components/save_button'); ?>
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

.cashier-add-extense {
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

.add-extense-container {
    display: flex;
    padding: 20px;
    flex-direction: column;
    align-items: flex-start;
    gap: 20px;
    flex: 1 0 0;
    align-self: stretch;
}

.add-extense-container p {
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
        align-items: flex-start;
        gap: 20px;
        align-self: stretch;
        border-radius: 10px;
        background: var(--White, #FFF);
    }

    .add-extense-info{
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

    .extense-button {
        display: flex;
justify-content: center;
align-items: center;
gap: 20px;
align-self: stretch;
    }
</style>