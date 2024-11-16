<div class="student-profile">
    <?= view('components/heading'); ?>
    <div class="body">
        <?= view('components/sidebar_student'); ?>
        <div class="body-right">
            <div class="content">
                <p>Thông tin cá nhân</p>
                <div class="student-info">
                    <div class="group">
                        <label for="id">Mã học sinh</label>
                        <?= view('components/input', [
                            'id' => 'id',
                            'value' => '22520857',
                            'readonly' => true
                        ]); ?>
                    </div>
                    <div class="group">
                        <label for="name">Họ tên</label>
                        <?= view('components/input', [
                            'id' => 'name',
                            'value' => 'Nguyễn Văn A',
                            'readonly' => true
                        ]); ?>
                    </div>
                </div>
                <div class="student-info">
                    <div class="group">
                        <label for="email">Email</label>
                        <?= view('components/input', [
                            'id' => 'email',
                            'value' => 'a@gmail.com',
                            'readonly' => true
                        ]); ?>
                    </div>
                    <div class="group">
                        <label for="phone">Số điện thoại</label>
                        <?= view('components/input', [
                            'id' => 'phone',
                            'value' => '0123456789',
                            'readonly' => true
                        ]); ?>
                    </div>
                </div>
                <div class="student-info">
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
                            'id' => 'date-of-birth',
                            'value' => '01-01-2004',
                            'readonly' => true
                        ]); ?>
                    </div>
                </div>
                <div class="student-info">
                    <div class="group">
                        <label for="place-of-birth">Nơi sinh</label>
                        <?= view('components/input', [
                            'id' => 'place-of-birth',
                            'value' => 'TPHCM',
                            'readonly' => true
                        ]); ?>
                    </div>
                    <div class="group">
                        <label for="ethnicity">Dân tộc</label>
                        <?= view('components/input', [
                            'id' => 'ethnicity',
                            'value' => 'Kinh',
                            'readonly' => true
                        ]); ?>
                    </div>
                </div>
                <div class="student-info">
                    <div class="group">
                        <label for="address">Địa chỉ</label>
                        <?= view('components/input', [
                            'id'=> "address",
                            'value' => 'Thủ Đức',
                            'readonly' => true
                        ]); ?>
                    </div>
                </div>
                <p>Học tập</p>
                <div class="student-info">
                    <div class="group">
                        <label for="class">Lớp học</label>
                        <?= view('components/input', [
                            'id' => 'class',
                            'value' => '12A1',
                            'readonly' => true
                        ]); ?>
                    </div>
                    <div class="group">
                        <label for="status">Tình trạng học</label>
                        <?= view('components/input', [
                            'id' => 'ethnicity',
                            'value' => 'Đang học',
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

.student-profile {
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
    /* border: 1px solid var(--Silver, #AFAFAF); */
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

.student-info{
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