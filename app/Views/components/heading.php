<div class="heading">
    <div class="left">
        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40" fill="none">
            <path d="M33.3334 30H6.66669M33.3334 23.3333H6.66669M33.3334 16.6667H6.66669M33.3334 10H6.66669" stroke="#01427A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
        <div class="logo">
            <img src="<?= base_url('public/image/banner_uit.png'); ?>" alt="Banner Image">
        </div>
    </div>
    <div class="right">
        <div class="info">
            <img src="<?= base_url('public/image/ava.png') ?>" alt="avatar">
            <div class="name">
                Họ và tên
                <p>Role</p>
            </div>
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <path d="M19 9L12 16L5 9" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </div>
    </div>
</div>

<style>
    .heading {
        display: flex;
        width: 100%;
        height: 60px;
        padding: 0px 20px;
        justify-content: space-between;
        align-items: center;
    }

    .left {
        display: flex;
        align-items: center;
        gap: 51px;
    }

    .logo {
        display: flex;
        height: 100%;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    .logo img {
        width: auto;
        /* Giữ tỉ lệ ảnh theo chiều rộng tự nhiên */
        height: 60px;
        /* Chiều cao cố định, tùy chỉnh theo ý muốn */
        max-width: 100%;
        /* Đảm bảo ảnh không vượt quá khung chứa */
        object-fit: contain;
        /* Đảm bảo giữ nguyên tỷ lệ ảnh */
    }

    .right {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: flex-end;
        gap: 38px;
    }

    .info {
        display: flex;
        width: auto;
        gap: 20px;
        justify-content: space-between;
        align-items: center;
        flex-shrink: 0;
    }

    .info img {
        width: auto;
        /* Giữ tỉ lệ ảnh theo chiều rộng tự nhiên */
        height: 60px;
        /* Chiều cao cố định, tùy chỉnh theo ý muốn */
        max-width: 100%;
        /* Đảm bảo ảnh không vượt quá khung chứa */
        object-fit: contain;
        /* Đảm bảo giữ nguyên tỷ lệ ảnh */
    }

    .name {
        display: flex;
        width: 74px;
        padding: 10px 0px;
        flex-direction: column;
        justify-content: space-between;
        align-items: flex-start;
        flex-shrink: 0;
        align-self: stretch;
        color: #000;
        font-family: Inter;
        font-size: 16px;
        font-style: normal;
        font-weight: 700;
        line-height: normal;
    }

    .name p {
        color: #000;
        font-family: Inter;
        font-size: 16px;
        font-style: normal;
        font-weight: 400;
        line-height: normal;
    }
</style>