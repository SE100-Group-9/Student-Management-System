<link rel="stylesheet" href="<?= base_url(relativePath: 'assets/css/style.css') ?>">

<div class="fault-lists">
    <div class="lists-heading">
        <?= view('components/heading'); ?>
    </div>
    <div class="body">
    <div class="body-left">
        <?= view('components/sidebar_supervisor'); ?>
        </div>
        <div class="body-right">
        Quản lý / Quản lý hạnh kiểm / Thông tin vi phạm
        <div class="faultlist-tool">
            <form method="GET" action="/sms/public/supervisor/fault">
                <div class="tool-search">
                    <?= view('components/searchbar', ['placeholder' => 'Nhập HS hoặc lớp']); ?>
                    <?= view('components/dropdown', [
                        'options' => ['Chọn học kì','Học kì 1', 'Học kì 2'], 
                        'dropdown_id' => 'status-dropdown',
                        'name' => 'semester',
                        'selected_text' => 'Chọn học kì',
                        ]) ?>
                    <?= view('components/dropdown', [
                        'options' => $yearList, 
                        'dropdown_id' => 'year-dropdown',
                        'name' => 'year',
                        'selected_text' => 'Chọn năm học',
                        ]) ?>
                     <?= view('components/view_button') ?>
                </div>

            </form>
            <div style="display: none">
                    <?= view('components/dropdown', []) ?>
                </div>
                <div class="tool-add">        
                        <a style="text-decoration: none" href="/sms/public/supervisor/addfault">
                            <?= view('components/add', ['button_text' => 'Thêm']) ?>
                        </a>
                </div>     
        </div>
            <div class="tabless">
                <?= view('components/tables/supervisorFault', ['ViPham' => $viPham]) ?>
            </div>
            <div style="max-width: 200px; align-items: flex-end">
                <?= view('components/pagination'); ?>
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

    .hidden {
        display: none;
    }

    .fault-lists {
        display: flex;
        width: 100%;
        height: 100%;
        flex-direction: column;
        align-items: flex-start;
        background: var(--White, #FFF);
    }

    .lists-heading {
        width: 100%;
        height: 60px;
        position: fixed;
    }

    .body {
        display: flex;
        align-items: flex-start;
        flex: 1 0 0;
        margin-top: 60px;
        align-self: stretch;
        background: var(--light-grey, #F9FAFB);
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
        color: #000;
        font-family: Inter;
        font-size: 16px;
        font-style: normal;
        font-weight: 400;
        line-height: normal;
        overflow-y: auto;
    }

    .faultlist-tool {
        display: flex;
        padding: 10px;
        justify-content: space-between;
        align-items: flex-start;
        align-self: stretch;
        border-radius: 10px;
        background: #FFF;
    }

    .tool-search {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .tool-add {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .tabless {
        width: 100%;
        height: 100%;
    }
</style>

