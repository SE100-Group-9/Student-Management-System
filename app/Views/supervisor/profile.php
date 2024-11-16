<div class="supervisor-profile">
    <?= view('components/heading'); ?>
    <div class="body">
        <?= view('components/sidebar_supervisor'); ?>
        <div class="body-right">
            <div class="content">
                <p>Thông tin cá nhân</p>
                <div class="supervisor-info">
                    <div class="group">
                        <label for="name">Họ tên</label>
                        <?= view('components/input', [
                            'id' => 'name',
                            'value' => 'Lê Văn B',
                            'readonly' => true
                        ]); ?>
                    </div>
                </div>
                <div class="supervisor-info">
                    <div class="group">
                        <label for="id">Mã công nhân viên</label>
                        <?= view('components/input', [
                            'id' => 'id',
                            'value' => '123',
                            'readonly' => true
                        ]); ?>
                    </div>
                    <div class="group">
                        <label for="email">Email</label>
                        <?= view('components/input', [
                            'id' =>'email',
                            'value' => 'b@gmail.com',
                            'readonly' => true
                        ]); ?>
                    </div>
                </div>
                <div class="supervisor-info">
                    <div class="group">
                        <label for="sex">Giới tính</label>
                        <?= view('components/input', [
                            'id' => 'sex',
                            'value' => 'Nam',
                            'readonly' => true
                        ]); ?>
                    </div>
                    <div class="group">
                        <label for="date-of-birth">Ngày sinh</label>
                        <?= view('components/input', [
                            'id' =>'date-of-birth',
                            'value' => '01-01-2004',
                            'readonly' => true
                        ]); ?>
                    </div>
                </div>
                <p>Công tác</p>
                <div class="supervisor-info">
                    <div class="group">
                        <label for="department">Phòng ban</label>
                        <?= view('components/input', [
                            'id' => 'department',
                            'value' => 'Bộ môn Toán',
                            'readonly' => true
                        ]); ?>
                    </div>
                    <div class="group">
                        <label for="position">Chức vụ</label>
                        <?= view('components/input', [
                            'id' =>'position',
                            'value' => 'Giáo viên',
                            'readonly' => true
                        ]); ?>
                    </div>
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

    .supervisor-profile {
        display: flex;
        flex-direction: column;
        width: 100%;
        height: 100%;
        overflow: auto;
        align-items: flex-start;
    }

    .body {
        display: flex;
        align-items: flex-start;
        gap: 20px;
        flex: 1 0 0;
        align-self: stretch;
        background: var(--light-grey, #F9FAFB);
    }

    .body-right {
        display: flex;
        padding: 0px 20px;
        flex-direction: column;
        align-items: center;
        gap: 30px;
        flex: 1 0 0;
        align-self: stretch;
    }

    .content {
        display: flex;
        padding: 20px;
        flex-direction: column;
        align-items: flex-start;
        gap: 20px;
        border-radius: 10px;
        background: var(--White, #FFF);
    }

    .content p {
        color: #000;
        font-family: Inter;
        font-size: 16px;
        font-style: normal;
        font-weight: 600;
        line-height: normal;
    }
    
    .supervisor-info{
        display: flex;
        align-items: flex-start;
        gap: 20px;
    }

    .group {
        display: flex;
        width: 500px;
        max-width: 500px;
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
    }

    .group label{
        color: #000;
        font-family: Inter;
        font-size: 14px;
        font-style: normal;
        font-weight: 500;
        line-height: normal;
    }
</style>