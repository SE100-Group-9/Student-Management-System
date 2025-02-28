<link rel="stylesheet" href="<?= base_url(relativePath: 'assets/css/style.css') ?>">

<div class="employee-teacher-lists">
    <div class="lists-heading">
        <?= view('components/heading') ?>
    </div>
    <div class="body">
        <div class="body-left">
            <?= view('components/sidebar_director') ?>
        </div>
        <div class="body-right">
            Quản lý / Quản lý nhân viên / Giám thị
            <div class="employee-supervisorlist-tool">
                <form method="GET" action="/sms/public/director/employee/supervisor/list">
                    <div class="tool-search">
                        <?= view('components/filter') ?>
                        <?= view('components/searchbar', ['searchTerm' => $searchTerm]) ?>
                </form>
            </div>

            <div class="tool-add">
                <a style="text-decoration: none" href="/sms/public/director/employee/supervisor/add">
                    <?= view('components/add', ['button_text' => 'Thêm giám thị']) ?>
                </a>
                <?= view('components/excel_export') ?>
                <?= view('components/upload') ?>
            </div>
        </div>

        <?php if (session()->getFlashdata('success')) : ?>
            <div style="color: green;"><?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')) : ?>
            <div style="color: red;"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>

        <div class="tabless">
            <?= view('components/tables/directorEmployeesupervisor', ['supervisorList' => $supervisorList]) ?>
        </div>
        <?= view('components/pagination') ?>
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

    .employee-teacher-lists {
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

    .employee-supervisorlist-tool {
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