<div class="payment-list">
    <?= view('components/heading'); ?>
    <div class="body">
        <?= view('components/sidebar_cashier'); ?>
        <div class="list-container">
            <p>Học phí / Quản lý học phí / Danh sách</p>
            <div class="list-tool">
                <div class="list-filter">
                    <?= view('components/filter'); ?>
                    <?= view('components/searchbar'); ?>
                    <?= view('components/add'); ?>
                </div>
                <div class="list-tool-2">                   
                    <?= view('components/excel_export'); ?>
                    <?= view('components/upload'); ?>                    
                </div>
            </div>
            <?= view('components/tables/cashierPaymentList') ?>
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

.payment-list {
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

.list-container {
    display: flex;
    padding: 20px;
    flex-direction: column;
    align-items: flex-start;
    gap: 20px;
    flex: 1 0 0;
    align-self: stretch;
}

.list-container p {
    color: #000;
    font-family: Inter;
    font-size: 16px;
    font-style: normal;
    font-weight: 400;
    line-height: normal;
}

.list-tool {
    display: flex;
    padding: 10px;
    align-items: flex-start;
    align-self: stretch;
    justify-content: space-between;
    border-radius: 10px;
    background: var(--White, #FFF);
}

.list-filter {
    display: flex;   
    align-items:flex-start;
    gap: 10px;
}

.list-tool-2 {
    display: flex;
    align-items: center;
    gap: 10px;gap: 10px;
}
</style>
