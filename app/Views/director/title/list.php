<link rel="stylesheet" href="<?= base_url(relativePath: 'assets/css/style.css') ?>">

<div class="titlelist">
    <div class="titlelist-heading">
        <?= view('components/heading') ?>
    </div>
    <div class="body">
        <div class="body-left">
            <?= view('components/sidebar_director') ?>
        </div>
        <div class="body-right">
            <div class="titlelist-tools">
                <div class="tools">
                    <?= view('components/filter') ?>
                    <?= view('components/searchbar') ?>
                    <a style="text-decoration: none" href="/sms/public/director/title/add">
                        <?= view('components/add', ['button_text' => 'Thêm danh hiệu']) ?>
                    </a>
                </div>
            </div>
            <?= view('components/tables/directorTitleList', ['titleList' => $titleList]) ?>
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

    .titlelist {
        display: flex;
        width: 100%;
        height: 100%;
        flex-direction: column;
        align-items: flex-start;
        background: #FFF;
    }

    .titlelist-heading {
        height: 60px;
        width: 100%;
    }

    .body {
        display: flex;
        align-items: flex-start;
        gap: 20px;
        flex: 1 0 0;
        align-self: stretch;
        background: #F9FAFB;
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

    .titlelist-tools {
        display: flex;
        padding: 10px;
        align-items: flex-start;
        gap: 10px;
        align-self: stretch;
        border-radius: 10px;
        background: #FFF;
    }

    .tools {
        width: 50%;
        display: flex;
        gap: 10px;
    }

</style>