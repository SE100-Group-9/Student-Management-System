<div class="supervisor-fault">
    <?= view('components/heading'); ?>
    <div class="body">
        <?= view('components/sidebar_supervisor'); ?>
        <div class="fault-container">
            <p>Quản lý / Quản lý hạnh kiểm / Thông tin vi phạm</p>
            <div class="fault-tool">
                <div class="fault-filter">
                    <?= view('components/filter'); ?>
                    <?= view('components/searchbar'); ?>
                </div>
                <?= view('components/add'); ?>
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

.supervisor-fault {
    display: flex;
    flex-direction: column; 
    width: 100%;
    height: 100%;
    overflow: auto;
    height: 100%;
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

.fault-container {
    display: flex;
    padding: 20px;
    flex-direction: column;
    align-items: flex-start;
    gap: 20px;
    flex: 1 0 0;
    align-self: stretch;
}

.fault-container p {
    color: #000;
    font-family: Inter;
    font-size: 16px;
    font-style: normal;
    font-weight: 400;
    line-height: normal;
}

.fault-tool {
    display: flex;
    padding: 15px;
    align-items: center;
    justify-content: space-between;
    align-self: stretch;
    border-radius: 10px;
    background: var(--White, #FFF);
}

.fault-filter {
    display: flex;
    align-items: center;
}

</style>
