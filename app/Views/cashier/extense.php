<div class="cashier-extense">
    <?= view('components/heading'); ?>
    <div class="body">
        <?= view('components/sidebar_cashier'); ?>
        <div class="extense-container">
            <p>Học phí / Quản lý học phí / Gia hạn</p>
            <div class="extense-tool">
                <div class="extense-filter">
                    <?= view('components/filter'); ?>
                    <?= view('components/searchbar'); ?>
                </div>
                <?= view('components/excel_export'); ?>
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

.cashier-extense {
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

.extense-container {
    display: flex;
    padding: 20px;
    flex-direction: column;
    align-items: flex-start;
    gap: 20px;
    flex: 1 0 0;
    align-self: stretch;
}

.extense-container p {
    color: #000;
    font-family: Inter;
    font-size: 16px;
    font-style: normal;
    font-weight: 400;
    line-height: normal;
}

.extense-tool {
    display: flex;
    padding: 10px;
    align-items: center;
    justify-content: space-between;
    align-self: stretch;
    border-radius: 10px;
    background: var(--White, #FFF);
}

.extense-filter {
    display: flex;
    align-items: center;
    gap: 10px;
}

</style>
