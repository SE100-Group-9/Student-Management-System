<div class="input-container">
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
        <path d="M4 17.8V12.2C4 11.0798 4 10.5199 4.21799 10.092C4.40973 9.71572 4.71547 9.40973 5.0918 9.21799C5.51962 9 6.08009 9 7.2002 9H16.8002C17.9203 9 18.48 9 18.9078 9.21799C19.2841 9.40973 19.5905 9.71572 19.7822 10.092C20.0002 10.5199 20 11.0798 20 12.2V17.8C20 18.9201 20.0002 19.4802 19.7822 19.908C19.5905 20.2844 19.2841 20.5902 18.9078 20.782C18.48 21 17.9203 21 16.8002 21H7.2002C6.08009 21 5.51962 21 5.0918 20.782C4.71547 20.5902 4.40973 20.2844 4.21799 19.908C4 19.4802 4 18.9201 4 17.8ZM9 8.76923V6C9 4.34315 10.3431 3 12 3C13.6569 3 15 4.34315 15 6V8.76923C15 8.89668 14.8964 9 14.7689 9H9.23047C9.10302 9 9 8.89668 9 8.76923Z" stroke="#6C6C6C" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
    </svg>
    <input class="input" type="password" name="MatKhau" id="MatKhau" placeholder="Mật khẩu">
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