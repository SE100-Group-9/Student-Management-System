<?php foreach ($HoaDon as $index => $hoadon): ?>      
                <h2>Thông tin học phí năm học <?= $hoadon['NamHoc'] ?>: </h2>
                <div class="student-fee-info-fields">
                    <div class="student-fee-info-field">
                        Tổng tiền
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'student_total',
                            'readonly' => true,
                            'value' => $hoadon['TongHocPhi']
                        ]) ?>
                    </div>
                    <div class="student-fee-info-field">
                        Đã thanh toán
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'student_paid',
                            'readonly' => true,
                            'value' => $hoadon['DaThanhToan']
                        ]) ?>
                    </div>
                </div>
                <div class="student-fee-info-fields">
                    <div class="student-fee-info-field">
                        Chưa thanh toán
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'student_notpaid',
                            'readonly' => true,
                            'value' => $hoadon['ConNo']
                        ]) ?>
                    </div>
                    <div class="student-fee-info-field">
                        Ngày thanh toán
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'day_paid',
                            'readonly' => true,
                            'value' => $hoadon['NgayThanhToan'],
                            'placeholder' => '' 
                        ]) ?>
                    </div>
                </div>
                <div class="student-fee-info-fields">
                    <div class="student-fee-info-field">
                        Trạng thái
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'student_state',
                            'readonly' => true,
                            'value' => $hoadon['TrangThai']
                        ]) ?>
                    </div>
                </div>
                
                <?php endforeach; ?>
<style>
    *,
    *::before,
    *::after {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    .student-fee-info {
        display: flex;
        width: 100%;
        height: 100%;
        flex-direction: column;
        align-items: flex-start;
        background: #FFF;
    }

    .student-fee-info-heading {
        width: 100%;
        height: 60px;
    }

    .body {
        display: flex;
        align-items: flex-start;
        flex: 1 0 0;
        align-self: stretch;
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
        overflow-y: auto;
        color: #000;
        font-family: Inter;
        font-size: 16px;
        font-style: normal;
        font-weight: 400;
        line-height: normal;
    }

    .body-right h1 {
        color: #000;
        font-family: Inter;
        font-size: 16px;
        font-style: normal;
        font-weight: 700;
        line-height: normal;
    }

    .body-right h2 {
        color: var(--Cerulean, #01B3EF);
        font-family: Inter;
        font-size: 16px;
        font-style: normal;
        font-weight: 700;
        line-height: normal;
    }

    .student-fee-info-fields {
        display: flex;
        width: 100%;
        justify-content: space-between;
        align-items: center;
    }

    .student-fee-info-field {
        display: flex;
        width: 45%;
        flex-direction: column;
        align-items: flex-start;
        gap: 20px;
        flex-shrink: 0;
        color: #000;
        font-family: Inter;
        font-size: 16px;
        font-style: normal;
        font-weight: 400;
        line-height: normal;
    }
</style>
