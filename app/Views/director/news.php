<div class="director-news">
    <div class="director-heading">
        <?= view('components/heading') ?>
    </div>
    <div class="body">
        <div class="body-left">
            <?= view('components/sidebar_director') ?>
        </div>
        <div class="body-right">
            Trung tâm / Thông tin chung / Tạo thông báo
            <div class="under">
                Tạo thông báo
                <div class="notification">
                    Chức vụ:
                    <?= view(name: 'components/input') ?>
                </div>
                <div class="notification">
                    Tài khoản:
                    <?= view(name: 'components/input') ?>
                </div>
                <div class="switch-text">
                    <?= view('components/switch') ?>
                    Chọn tất cả
                </div>
                <div class="notification">
                    Tiêu đề
                    <?= view('components/input') ?>
                </div>
                <div class="content-post">
                    Nội dung:
                    <textarea class="text-fill" placeholder="Nhập nội dung"></textarea>
                </div>
                <div class="post-button">
                    <?= view('components/save_button') ?>
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

    .director-news {
        display: flex;
        width: 100%;
        height: 100%;
        flex-direction: column;
        align-items: flex-start;
        background: var(--White, #FFF);
    }

    .director-heading {
        height: 60px;
        width: 100%;
        position: fixed;
        background-color: white;
    }

    .body {
        display: flex;
        align-items: flex-start;
        flex: 1 0 0;
        align-self: stretch;
        margin-top: 60px;
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

    .under {
        display: flex;
        padding: 20px;
        flex-direction: column;
        align-items: flex-start;
        gap: 20px;
        flex: 1 0 0;
        align-self: stretch;
        border-radius: 10px;
        background: var(--White, #FFF);
        color: #000;
        font-family: Inter;
        font-size: 20px;
        font-style: normal;
        font-weight: 700;
        line-height: normal;
    }

    .notification {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        gap: 20px;
        align-self: stretch;
        color: #000;
        font-family: Inter;
        font-size: 16px;
        font-style: normal;
        font-weight: 700;
        line-height: normal;
    }

    .switch-text {
        display: flex;
        align-items: center;
        gap: 10px;
        color: #000;
        font-family: Inter;
        font-size: 16px;
        font-style: normal;
        font-weight: 400;
        line-height: 14px;
        /* 87.5% */
    }

    .content-post {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        gap: 20px;
        flex: 1 0 0;
        align-self: stretch;
        color: #000;
        font-family: Inter;
        font-size: 16px;
        font-style: normal;
        font-weight: 700;
        line-height: normal;
    }

    .text-fill {
        width: 100%;
        height: 300px;
        max-height: 500px;
        border-radius: 10px;
        border: 1px solid rgba(0, 60, 60, 0.20);
        color: #000;
        font-family: Inter;
        font-size: 16px;
        font-style: normal;
        font-weight: 400;
        line-height: normal;
        padding: 10px;
        resize: none;
        overflow-y: hidden;
    }

    .text-fill:focus-within {
        border-color: #6DCFFB;
        outline: none;
    }

    .post-button {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: flex-end;
        gap: 10px;
        align-self: stretch;
    }
</style>