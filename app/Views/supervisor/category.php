<link rel="stylesheet" href="<?= base_url(relativePath: 'assets/css/style.css') ?>">

<div class="supervisor-category">
    <?= view('components/heading'); ?>
    <div class="body">
        <?= view('components/sidebar_supervisor'); ?>
        <div class="category-container">
            <p>Hạnh kiểm / Quản lý hạnh kiểm / Danh mục</p>
            <div class="categorylist-tool">
                <form method="GET" action="/sms/public/supervisor/category">
                    <div class="tool-search">
                        <div>
                            <?= view('components/searchbar', ['placeholder' => 'Nhập tên vi phạm'])?>
                        </div>
                    </div>
                </form>
                <div class="tool-add">
                        <a style="text-decoration: none" href="/sms/public/supervisor/addcategory">
                            <?= view('components/add', ['button_text' => 'Thêm loại vi phạm']) ?>
                        </a>
                </div>
            </div>
            <div class="tabless">
                <?= view('components/tables/supervisorCategory', ['LoaiViPham' => $LoaiViPham]) ?>
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

.supervisor-category {
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

.category-container {
    display: flex;
    padding: 20px;
    flex-direction: column;
    align-items: flex-start;
    gap: 20px;
    flex: 1 0 0;
    align-self: stretch;
    width: 100%; 
}

.category-container p {
    color: #000;
    font-family: Inter;
    font-size: 16px;
    font-style: normal;
    font-weight: 400;
    line-height: normal;
}

.category-container table {
    width: 100%;
    margin-bottom: 20px; /* Khoảng cách giữa table và pagination */
}

.categorylist-tool {
        display: flex;
        padding: 10px;
        justify-content: space-between;
        align-items: flex-start;
        align-self: stretch;
        border-radius: 10px;
        background: #FFF;
    }

    
.tool-add {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .tool-search {
        display: flex;
        align-items: center;
        gap: 10px;
    }

.category-filter {
    display: flex;
    align-items: center;
    gap: 10px;
}

.tabless {
        width: 100%;
        height: 100%;
    }

</style>