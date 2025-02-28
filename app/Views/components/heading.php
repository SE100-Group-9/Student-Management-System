<div class="heading">
    <div class="left">
        <div class="logo">
            <img src="<?= base_url('assets/image/banner_uit.png'); ?>" alt="Banner Image">
        </div>
    </div>
    <div class="right">
        <div class="info">
            <img src="<?= base_url('assets/image/ava.png') ?>" alt="avatar">
            <div class="name">
                <?= session()->get('HoTen') ?>
                <p><?= session()->get('TenVT') ?></p>
            </div>
            <svg id="dropdown-toggle" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <path d="M19 9L12 16L5 9" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </div>
    </div>

</div>
<div id="dropdown-heading" class="dropdown-heading">
    <a style="text-decoration: none; background: none; color: inherit;" href="<?= getProfileUrl(session()->get('MaVT')) ?>">
        <div class="personal">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <path d="M17.2166 19.3323C15.9349 17.9008 14.0727 17 12 17C9.92734 17 8.06492 17.9008 6.7832 19.3323M12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12C21 16.9706 16.9706 21 12 21ZM12 14C10.3431 14 9 12.6569 9 11C9 9.34315 10.3431 8 12 8C13.6569 8 15 9.34315 15 11C15 12.6569 13.6569 14 12 14Z" stroke="#01B3EF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
            Thông tin
        </div>
    </a>
    <a style="text-decoration: none; background: none; color: inherit;" href="<?= getChangePasswordUrl(session()->get('MaVT')) ?>">
        <div class="personal">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <path d="M15 9L11 13L9 11M20 6.19995V10.1648C20 16.7331 15.0319 19.6778 12.9258 20.6312C12.7025 20.7322 12.5916 20.7828 12.3389 20.8262C12.1795 20.8536 11.8213 20.8536 11.6619 20.8262C11.4092 20.7828 11.2972 20.7322 11.074 20.6312C8.9678 19.6778 4 16.7331 4 10.1648V6.19995C4 5.07985 4 4.51986 4.21799 4.09204C4.40973 3.71572 4.71547 3.40973 5.0918 3.21799C5.51962 3 6.08009 3 7.2002 3H16.8002C17.9203 3 18.48 3 18.9078 3.21799C19.2841 3.40973 19.5905 3.71572 19.7822 4.09204C20.0002 4.51986 20 5.07985 20 6.19995Z" stroke="#E14177" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
            Đổi mật khẩu
        </div>
    </a>
    <div class="personal" onclick="logout()">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
            <path d="M12 15L15 12M15 12L12 9M15 12L4 12M4 17C4 17.9319 4 18.3978 4.15224 18.7654C4.35523 19.2554 4.74481 19.6448 5.23486 19.8478C5.6024 20 6.06812 20 7 20H16.8C17.9201 20 18.48 20 18.9078 19.782C19.2841 19.5902 19.5905 19.2844 19.7822 18.908C20.0002 18.4802 20 17.9201 20 16.8V7.19995C20 6.07985 20.0002 5.51986 19.7822 5.09204C19.5905 4.71572 19.2841 4.40973 18.9078 4.21799C18.48 4 17.9201 4 16.8 4H7C6.06812 4 5.60241 4 5.23486 4.15224C4.74481 4.35523 4.35523 4.74456 4.15224 5.23462C4 5.60216 4 6.0681 4 6.99999" stroke="#01B3EF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
        Đăng xuất
    </div>
</div>

<?php
// Hàm trả về URL của trang "Thông tin" dựa trên vai trò
function getProfileUrl($MaVT)
{
    switch ($MaVT) {
        case '1':
            return base_url('/director/profile');
        case '2':
            return base_url('/teacher/profile');
        case '3':
            return base_url('/student/profile');
        case '4':
            return base_url('/cashier/profile');
        case '5':
            return base_url('/supervisor/profile');
        default:
            return base_url('/');
    }
}
// Hàm trả về URL của trang "Đổi mật khẩu" dựa trên vai trò
function getChangePasswordUrl($MaVT)
{
    switch ($MaVT) {
        case '1':
            return base_url('/director/changepw');
        case '2':
            return base_url('/teacher/changepw');
        case '3':
            return base_url('/student/changepw');
        case '4':
            return base_url('/cashier/changepw');
        case '5':
            return base_url('/supervisor/changepw');
        default:
            return base_url('/');
    }
}
?>

<style>
    .heading {
        display: flex;
        width: 100%;
        height: 60px;
        padding: 0px 20px;
        justify-content: space-between;
        background-color: white;
        align-items: center;
        border-top: 1px solid rgba(0, 60, 60, 0.20);
        border-bottom: 1px solid rgba(0, 60, 60, 0.20);
    }

    .left {
        display: flex;
        align-items: center;
        gap: 51px;
    }

    .left svg:hover {
        cursor: pointer;
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
        white-space: nowrap;
    }

    .right svg:hover {
        cursor: pointer;
    }

    .info {
        display: flex;
        width: auto;
        gap: 20px;
        justify-content: space-between;
        align-items: center;
        flex-shrink: 0;
        white-space: nowrap;
    }

    .info img {
        width: auto;
        /* Giữ tỉ lệ ảnh theo chiều rộng tự nhiên */
        height: 50px;
        /* Chiều cao cố định, tùy chỉnh theo ý muốn */
        max-width: 100%;
        /* Đảm bảo ảnh không vượt quá khung chứa */
        object-fit: contain;
        /* Đảm bảo giữ nguyên tỷ lệ ảnh */
    }

    .name {
        display: flex;
        width: auto;
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
        white-space: nowrap;
    }

    .name p {
        color: #000;
        font-family: Inter;
        font-size: 16px;
        font-style: normal;
        font-weight: 400;
        line-height: normal;
        white-space: nowrap;
    }

    .dropdown-heading {
        display: none;
        position: absolute;
        width: 200px;
        padding: 20px;
        flex-direction: column;
        justify-content: flex-start;
        align-items: flex-start;
        gap: 20px;
        /* Đảm bảo gap được áp dụng */
        background-color: #fff;
        border: 1px solid #ddd;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        top: 70px;
        right: 20px;
        z-index: 1000;
        transform: translateY(-10px);
        z-index: 9999;
    }

    /* Khi class 'show' được thêm vào, dropdown sẽ hiển thị */
    .dropdown-heading.show {
        display: flex;
    }

    #dropdown-heading{
        z-index: 999999999;
    }

    .personal {
        display: flex;
        align-items: center;
        gap: 22px;
        color: #000;
        font-family: Inter;
        font-size: 16px;
        font-style: normal;
        font-weight: 400;
        line-height: normal;
        cursor: pointer;
    }
</style>

<script>
    function logout() {
        // Gửi yêu cầu đến URL logout
        fetch('<?= base_url('logout') ?>', {
                method: 'GET',
            })
            .then(response => {
                if (response.ok) {
                    // Chuyển hướng về trang đăng nhập
                    window.location.href = '<?= base_url('/') ?>';
                } else {
                    alert('Đăng xuất thất bại, vui lòng thử lại.');
                }
            })
            .catch(error => {
                console.error('Error during logout:', error);
            });
    }

    document.getElementById('dropdown-toggle').addEventListener('click', function() {
        var dropdown = document.getElementById('dropdown-heading');
        dropdown.classList.toggle('show'); // Toggle class 'show' thay vì dùng display trực tiếp
    });
    function viewProfile() {
        const role = "<?= session()->get('TenVT') ?>"; // Lấy vai trò từ session PHP

        // Điều hướng đến trang profile tương ứng
        switch (role) {
            case "Ban giám hiệu":
                window.location.href = "<?= base_url('director/profile') ?>";
                break;
            case "Giáo viên":
                window.location.href = "<?= base_url('teacher/profile') ?>";
                break;
            case "Học sinh":
                window.location.href = "<?= base_url('student/profile') ?>";
                break;
            case "Thu ngân":
                window.location.href = "<?= base_url('cashier/profile') ?>";
                break;
            case "Giám thị":
                window.location.href = "<?= base_url('supervisor/profile') ?>";
                break;
            default:
                alert("Không thể xác định vai trò của bạn!");
        }
    }
    function changePassword() {
        const role = "<?= session()->get('TenVT') ?>"; // Lấy vai trò từ session PHP

        // Điều hướng đến trang đổi mật khẩu tương ứng
        switch (role) {
            case "Ban giám hiệu":
                window.location.href = "<?= base_url('director/changepw') ?>";
                break;
            case "Giáo viên":
                window.location.href = "<?= base_url('teacher/changepw') ?>";
                break;
            case "Học sinh":
                window.location.href = "<?= base_url('student/changepw') ?>";
                break;
            case "Thu ngân":
                window.location.href = "<?= base_url('cashier/changepw') ?>";
                break;
            case "Giám thị":
                window.location.href = "<?= base_url('supervisor/changepw') ?>";
                break;
            default:
                alert("Không thể xác định vai trò của bạn!");
        }
    }
</script>