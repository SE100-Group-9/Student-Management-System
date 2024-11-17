<div class="payment-add">
    <?= view('components/heading'); ?>
    <div class="body">
        <?= view('components/sidebar_cashier'); ?>
        <div class="add-container">
            <h1>Học phí / Quản lý học phí / Danh sách / Tạo phiên thanh toán</h1>
            <div class="content">
                <?= view('components/view_button'); ?>
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

.payement-add {
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

.add-container {
    display: flex;
    padding: 20px;
    flex-direction: column;
    align-items: flex-start;
    gap: 20px;
    flex: 1 0 0;
    align-self: stretch;
}

.add-container h1 {
    color: #000;
    font-family: Inter;
    font-size: 16px;
    font-style: normal;
    font-weight: 400;
    line-height: normal;
}
</style>