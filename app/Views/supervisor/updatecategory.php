<link rel="stylesheet" href="<?= base_url(relativePath: 'assets/css/style.css') ?>">

<div class="supervisor-update-category">
    <?= view('components/heading'); ?>
    <div class="body">
        <?= view('components/sidebar_supervisor'); ?>
        <div class="update-category-container">
            <h1>Hạnh kiểm / Quản lý hạnh kiểm / Danh mục / Cập nhật lỗi vi phạm</h1>
            <form method="POST" action=" ">
                <div class="content">
                    <div class="add-info">
                        <div class="group">
                            <label for="category-id">Mã vi phạm</label>
                            <?= view('components/input', [
                                'id' => 'category-id',
                                'value' => '01',
                                'readonly' => true
                            ]); ?>
                        </div>
                    </div> 
                    <div class="add-info">
                        <div class="group">
                            <label for="category-name">Tên vi phạm</label>
                            <?= view('components/input', [
                                'id' => 'category-name',
                                'value' => 'Đi trễ',
                                'readonly' => false
                            ]); ?>
                        </div>
                        <div class="group">
                            <label for="minus-point">Điểm trừ</label>
                            <?= view('components/input', [
                                'id' => 'minus-point',
                                'value' => '3',
                                'readonly' => false
                            ]); ?>
                            <small id="error" style="color: red; display: none;">Vui lòng chỉ nhập số.</small>
                        </div>
                    </div> 
                </div>
            </form>
            <div class="add-button">
                <a href="/sms/public/supervisor/category" style="text-decoration: none";>
                    <?= view('components/exit_button') ?>
                </a>
                <?= view('components/save_button') ?>
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

.supervisor-update-category {
    display: flex;
    flex-direction: column;
    width: 100%;
    height: 100vh;
}

.body {
    display: flex;
    flex: 1; /* Chiếm toàn bộ không gian còn lại */
    flex-direction: row;
    align-self: stretch;
    background: var(--light-grey, #F9FAFB);
    overflow: hidden; /* Ngăn xuất hiện thanh cuộn không mong muốn */
}

.update-category-container {
    display: flex;
    flex: 1; /* Cho phép giãn toàn bộ không gian */
    flex-direction: column;
    align-items: flex-start;
    gap: 20px;
    padding: 20px;
    box-sizing: border-box; /* Đảm bảo padding không tăng kích thước */
    overflow-y: auto; /* Cuộn nội dung nếu vượt quá không gian */
    max-height: 100%;
}

.update-category-container h1 {
    color: #000;
    font-family: Inter;
    font-size: 16px;
    font-style: normal;
    font-weight: 400;
    line-height: normal;
}

    .content {
        display: flex;
        padding: 20px;
        flex-direction: column;
        align-items: flex-start;
        gap: 20px;
        border-radius: 10px;
    }

    .add-info{
        display: flex;
        align-items: flex-start;
        justify-content: flex-start;
        gap: 20px;
        width: 100%; 
    }

    .group {
        display: flex;
        width: 500px;
        max-width: 500px;
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
    }

    .group label {
        color: #000;
        font-family: Inter;
        font-size: 14px;
        font-style: normal;
        font-weight: 500;
        line-height: normal;
    }

    .add-button {
        display: flex;
        width: 100%;
        justify-content: center;
        align-items: center;
        gap: 20px;
    }
</style>

<script>
    document.getElementById('minus-point').addEventListener('input', function (e) {
        const errorMessage = document.getElementById('error');
        // Kiểm tra nếu người dùng nhập ký tự không hợp lệ
        if (/[^0-9]/.test(this.value)) {
            errorMessage.style.display = 'block'; // Hiển thị thông báo lỗi
        } else {
            errorMessage.style.display = 'none'; // Ẩn thông báo lỗi
        }
        // Chỉ giữ lại các ký tự số
        this.value = this.value.replace(/[^0-9]/g, '');
    });
</script>