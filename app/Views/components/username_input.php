<div class="input-container">
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
        <path d="M17.2166 19.3323C15.9349 17.9008 14.0727 17 12 17C9.92734 17 8.06492 17.9008 6.7832 19.3323M12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12C21 16.9706 16.9706 21 12 21ZM12 14C10.3431 14 9 12.6569 9 11C9 9.34315 10.3431 8 12 8C13.6569 8 15 9.34315 15 11C15 12.6569 13.6569 14 12 14Z" stroke="#6C6C6C" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
    </svg>
    <input class="input" type="text" placeholder="Tên tài khoản">
</div>

<style>
    .input-container {
        position: relative;
        width: 100%;
        display: flex;
        align-items: center;
    }

    .input {
        width: 100%;
        height: 40px;
        padding-left: 40px;
        /* Tạo khoảng cách giữa placeholder và SVG */
        box-sizing: border-box;
        border-radius: 10px;
        border: 1px solid rgba(0, 60, 60, 0.20);
        background: var(--White, #FFF);
        color: var(--Dark-Grey, #6C6C6C);
        font-family: Inter;
        font-size: 16px;
        font-style: normal;
        font-weight: 400;
        line-height: normal;
    }

    svg {
        position: absolute;
        top: 50%;
        left: 10px;
        /* Đảm bảo SVG nằm cách bên trái 10px */
        transform: translateY(-50%);
        /* Căn giữa theo chiều dọc */
        pointer-events: none;
        /* Đảm bảo SVG không gây trở ngại khi nhập liệu */
    }
</style>