<div class="login">
    <?= view('components/footer') ?>
    <div class="above">
        <div class="picture">
            <img src="assets/image/login.jpg" alt=" Sample Image">
        </div>
        <form action="login/authenticate" method="POST">
            <div class="right">
                <img src="/sms/public/assets/image/banner_uit.png" alt=" Logo">
                <h1>Xin chào quay lại!</h1>
                <div class="account">
                    Tài khoản
                    <?= view('components/username_input') ?>
                </div>
                <div class="account">
                    Mật khẩu
                    <?= view('components/password_input') ?>
                </div>
                <?php if (session()->getFlashdata('error')): ?>
                    <div class="error"><?= session()->getFlashdata('error') ?></div>
                <?php endif; ?>
                <p>Quên mật khẩu?</p>
                <div class="button">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="25" viewBox="0 0 24 25" fill="none">
                        <path d="M12 15.5L15 12.5M15 12.5L12 9.5M15 12.5L4 12.5M4 17.5C4 18.4319 4 18.8978 4.15224 19.2654C4.35523 19.7554 4.74481 20.1448 5.23486 20.3478C5.6024 20.5 6.06812 20.5 7 20.5H16.8C17.9201 20.5 18.48 20.5 18.9078 20.282C19.2841 20.0902 19.5905 19.7844 19.7822 19.408C20.0002 18.9802 20 18.4201 20 17.3V7.69995C20 6.57985 20.0002 6.01986 19.7822 5.59204C19.5905 5.21572 19.2841 4.90973 18.9078 4.71799C18.48 4.5 17.9201 4.5 16.8 4.5H7C6.06812 4.5 5.60241 4.5 5.23486 4.65224C4.74481 4.85523 4.35523 5.24456 4.15224 5.73462C4 6.10216 4 6.5681 4 7.49999" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <button type="submit" class="login_button">Đăng nhập</button>
                </div>
            </div>
        </form>
    </div>
    <div class="portfolio">
        <div class="portfolio-inner">
            <h1>What about this web?</h1>
            <p><strong>Phần mềm quản lý học sinh (SMS)</strong> với chức năng quản lý thông tin học sinh, quản lý điểm, hạnh kiểm, học bạ và hoạt động trên nền tảng web. Thay thế việc quản lý học sinh trong nhà trường một cách thủ công bằng các tính năng tự động hóa việc thêm, xóa, cập nhật các thông tin liên quan của học sinh.
            </p>
            <p>Một số chức năng chính:</p>
            <li><strong>Ban Giám Hiệu:</strong> Thêm, xóa, sửa tài khoản người dùng, nhập, xóa, sửa thông tin học sinh, thống kê số lượng nhập học, quản lý học bạ, thống kê hạnh kiểm, cập nhật quy định về học sinh, điểm số, hạnh kiểm.</li>
            <li><strong>Giáo viên:</strong> Báo cáo học lực lớp, nhập, sửa, xóa điểm, nhận xét, đánh giá kết quả học tập, thống kê kết quả học tập của học sinh.</li>
            <li><strong>Thu Ngân:</strong> Thu học phí, gia hạn học phí, ghi nhận các khoản thanh toán, thống kê học phí.</li>
            <li><strong>Giám Thị:</strong> Tạo các báo cáo vi phạm, quản lý hạnh kiểm.</li>
            <li><strong>Học Sinh:</strong> Xem thông tin học sinh, xem điểm, thanh toán học phí, xem kết quả học tập, xem hạnh kiểm.</li>
        </div>
    </div>
    <div class="founders">
        Founders
        <div class="founder-pic">
            <div class="founder">
                <img src="assets/image/MinhKhoi.jpg" alt="Minh Khôi">
                <p>Minh Khôi</p>
            </div>
            <div class="founder">
                <img src="assets/image/NgocMinh.jpg" alt="Ngọc Minh">
                <p>Ngọc Minh</p>
            </div>
            <div class="founder">
                <img src="assets/image/PhuongLinhh.jpg" alt="Phương Linh">
                <p>Phương Linh</p>
            </div>
            <div class="founder">
                <img src="assets/image/KhanhHuy.png" alt="Khánh Huy">
                <p>Khánh Huy</p>
            </div>
        </div>
    </div>
    <div class="contact">
        Contact
        <div class="info-contact">
            22520703@gm.uit.edu.vn
        </div>
        <div class="info-contact">
            22520857@gm.uit.edu.vn
        </div>
        <div class="info-contact">
            22520778@gm.uit.edu.vn
        </div>
        <div class="info-contact">
            22520560@gm.uit.edu.vn
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

    .login {
        display: flex;
        width: 100%;
        flex-direction: column;
        align-items: flex-start;
        gap: 20px;
        background: var(--White, #FFF);
    }

    .above {
        display: flex;
        width: 100%;
        height: auto;
        align-items: flex-start;
        align-self: stretch;
    }

    .picture {
        display: flex;
        width: 60%;
        height: 600px;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    .picture img {
        max-width: 100%;
        height: auto;
    }

    form {
        width: 40%;
        /* Chiều rộng tối đa */
        display: flex;
        /* Sử dụng flexbox để dễ dàng căn chỉnh nội dung */
        flex-direction: column;
        /* Sắp xếp các thành phần trong form theo chiều dọc */
        align-items: center;
        /* Căn giữa nội dung theo chiều ngang */
        justify-content: center;
        /* Căn giữa nội dung theo chiều dọc nếu cần */
        padding: 20px;
        /* Thêm khoảng cách bên trong */
        gap: 20px;
        /* Khoảng cách giữa các phần tử */
    }


    .right {
        width: 100%;
        display: flex;
        padding: 0px 20px;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        gap: 20px;
        flex: 1 0 0;
        align-self: stretch;
    }

    .right h1 {
        color: var(--Cerulean, #01B3EF);
        font-family: Inter;
        font-size: 24px;
        font-style: normal;
        font-weight: 700;
        line-height: normal;
    }

    .right p {
        color: var(--Cerulean, #01B3EF);
        text-align: center;
        font-family: Inter;
        font-size: 16px;
        font-style: normal;
        font-weight: 400;
        line-height: normal;
    }

    .account {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        gap: 15px;
        align-self: stretch;
        color: #000;
        font-family: Inter;
        font-size: 16px;
        font-style: normal;
        font-weight: 400;
        line-height: normal;
    }

    .button {
        display: flex;
        width: 100%;
    }

    .login_button {
        display: flex;
        height: 40px;
        width: 100%;
        padding: 0px 20px;
        justify-content: center;
        align-items: center;
        gap: 20px;
        align-self: stretch;
        border-radius: 10px;
        border: 1px solid rgba(0, 60, 60, 0.20);
        background: var(--Cerulean, #01B3EF);
        color: var(--White, #FFF);
        font-family: Inter;
        font-size: 20px;
        font-style: normal;
        font-weight: 700;
        line-height: normal;
        cursor: pointer;
    }

    .login_button:hover {
        background-color: #6DCFFB;
    }

    .portfolio {
        height: auto;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        gap: 10px;
        align-self: stretch;
    }

    .portfolio-inner {
        display: flex;
        width: 85%;
        height: 390px;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        gap: 20px;
        color: #000;
        font-family: Inter;
        font-size: 20px;
        font-style: normal;
        font-weight: 700;
        line-height: normal;
    }

    .portfolio-inner h1 {
        color: var(--Cerulean, #01B3EF);
        font-family: Inter;
        font-size: 24px;
        font-style: normal;
        font-weight: 700;
        line-height: normal;
    }


    .portfolio-inner p {
        align-self: stretch;
        color: #000;
        font-family: Inter;
        font-size: 20px;
        font-style: normal;
        font-weight: 400;
        line-height: normal;
        display: inline;
        /* Hiển thị trên cùng một dòng */
        margin: 0;
    }

    .portfolio-inner li {
        width: 100%;
        align-self: stretch;
        color: #000;
        font-family: Inter;
        font-size: 20px;
        font-style: normal;
        font-weight: 400;
        line-height: normal;
    }

    .founders {
        display: flex;
        padding: 30px 0px;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        gap: 20px;
        align-self: stretch;
        color: var(--Cerulean, #01B3EF);
        font-family: Inter;
        font-size: 24px;
        font-style: normal;
        font-weight: 700;
        line-height: normal;
    }

    .founder {
        display: flex;
        width: 30%;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        gap: 10px;
    }

    .founder p {
        color: #000;
        font-family: Inter;
        font-size: 16px;
        font-style: normal;
        font-weight: 400;
        line-height: normal;
    }

    .founder-pic {
        display: flex;
        justify-content: center;
        align-items: flex-start;
        gap: 10px;
    }

    .founder-pic img {
        width: 30%;
        height: 300px;
    }

    .founder img {
        width: 100%;
    }

    .contact {
        display: flex;
        width: 100%;
        height: 60px;
        padding: 0px 20px;
        justify-content: space-between;
        align-items: center;
        color: var(--light-grey, #F9FAFB);
        font-family: Inter;
        font-size: 20px;
        font-style: normal;
        font-weight: 600;
        line-height: normal;
        background: var(--Cerulean, #01B3EF);
    }

    .info-contact {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 10px;
        color: var(--light-grey, #F9FAFB);
        font-family: Inter;
        font-size: 16px;
        font-style: normal;
        font-weight: 400;
        line-height: normal;
        cursor: pointer;
    }

    .info-contact:hover {
        color: #01427A;
    }
</style>