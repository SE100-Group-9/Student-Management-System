<link rel="stylesheet" href="<?= base_url(relativePath: 'assets/css/style.css') ?>">

<div class="studentconduct">
    <div class="studentconduct-heading">
        <?= view('components/heading') ?>
    </div>
    <div class="body">
        <div class="body-left">
            <?= view('components/sidebar_student') ?>
        </div>
            <div class="body-right">
                Học tập / Học tập / Xem hạnh kiểm
                <div class="studentconduct-tools">
                    <div class="tool-search">
                        <?= view('components/filter') ?>
                        <?= view('components/searchbar') ?>
                        <?= view('components/dropdown', [
                            'options' => ['2024-2025','2023-2024'],
                            'dropdown_id' => 'year-dropdown',
                            'selected_text' => 'Năm học',
                            ]) ?>
                        <?= view('components/dropdown', [
                            'options' => ['Học kỳ I', 'Học kỳ II'], 
                            'dropdown_id' => 'semester-dropdown',
                            'selected_text' => 'Học kỳ',
                            ]) ?>
                        <div class="hidden-dropdown">
                        <?= view('components/dropdown', ['options' => ['11A1', '11A2'], 'dropdown_id' => 'class-dropdown']) ?>
                        </div>
                    </div>
                    <div class="tool-add">
                        <?= view('components/excel_export') ?>
                    </div>
                </div>
                <?= view('components/tables/StudentConduct') ?>
                <?= view('components/pagination'); ?> 
            </div>
    </div>
</div>

<style>
    *,
    *::before,
    *::after {
        padding: 0;
        margin: 0;
        box-sizing: border-box;
    }

    .studentconduct {
        display: flex;
        width: 100%;
        height: 100%;
        flex-direction: column;
        align-items: flex-start;
        background: #FFF;
    }

    .studentconduct-heading {
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

    .studentconduct-tools {
        display: flex;
        width: 100%;
        padding: 10px;
        justify-content: space-between;
        align-items: flex-start;
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

    .hidden-dropdown {
        display: none;
    }
</style>

