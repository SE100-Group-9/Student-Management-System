<div class="employee-teacher-lists">
    <div class="lists-heading">
        <?= view('components/heading') ?>
    </div>
    <div class="body">
        <div class="body-left">
            <?= view('components/sidebar_director') ?>
        </div>
        <div class="body-right">
            Quản lý / Quản lý nhân viên / Giáo viên
            <div class="employee-teacherlist-tool">
                <div class="tool-search">
                    <?= view('components/filter') ?>
                    <?= view('components/searchbar') ?>
                    <a href="/sms/public/director/employee/teacher/add" style="text-decoration: none";>
                        <?= view('components/add', ['button_text' => 'Thêm giáo viên']) ?>
                    </a>
                </div>
                <div class="tool-add">
                    <?= view('components/excel_export') ?>
                    <?= view('components/upload') ?>
                </div>
            </div>
            <div class="tabless">
                <?= view('components/tables/directorEmployeeTeacher', ['tableId' => 'directorEmployeeTeacher']) ?>
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

    .employee-teacherlist-tool {
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