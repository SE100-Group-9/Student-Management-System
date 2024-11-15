<div class="cashier-payment">
    <?= view('components/heading'); ?>
    <div class="body">
        <?= view('components/sidebar_cashier'); ?>
        <div class="payment-container">
            <p>Học phí / Quản lý học phí / Danh sách</p>
            <div class="payment-tool">
                <div class="payment-filter">
                    <?= view('components/filter'); ?>
                    <?= view('components/searchbar'); ?>
                    <?= view('components/add'); ?>
                </div>
                <div class="payment-tool-2">
                    <?= view('components/excel_export'); ?>
                    <?= view('components/upload'); ?>
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

.cashier-payment {
    display: flex;
    flex-direction: column; 
    width: 100%;
    height: 100%;
    overflow: auto;
    
}

.body {
    display: flex; 
    flex-direction: row; 
    align-items: flex-start;
    flex: 1 0 0;
    align-self: stretch;
    background: #F0F2F5;
    height: 100%;
}

.heading {
    padding: 20px;
    width: 100%;
    box-sizing: border-box;
}

.payment-container {
    display: flex;
    padding: 20px;
    flex-direction: column;
    align-items: flex-start;
    gap: 20px;
    flex: 1 0 0;
    align-self: stretch;
}

.payment-container p {
    color: #000;
    font-family: Inter;
    font-size: 16px;
    font-style: normal;
    font-weight: 400;
    line-height: normal;
}

.payment-tool {
    display: flex;
    padding: 15px;
    align-items: flex-start;
    align-self: stretch;
    justify-content: space-between;
    align-self: stretch;
    border-radius: 10px;
    background: var(--White, #FFF);
}

.payment-filter {
    display: flex;   
    align-items: flex-start;
    gap: 10px;
}

.payment-tool-2 {
    display: flex;
align-items: center;
gap: 5px;
}
</style>
