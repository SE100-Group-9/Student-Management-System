<link rel="stylesheet" href="<?= base_url(relativePath: 'assets/css/style.css') ?>">

<div class="payment-add">
    <div class="payment-add-heading">
        <?= view('components/heading') ?>
    </div>
    <div class="body">
        <div class="body-left">
            <?= view('components/sidebar_cashier') ?>
        </div>
        <div class="body-right">
            Học phí / Quản lý học phí / Danh sách
            <h1>Thêm thanh toán:</h1>
            <form method="POST" action="/sms/public/cashier/payment/add">
                <h2>Thông tin thanh toán:</h2>
                <div class="payment-add-fields">
                    <div class="payment-add-field">
                        Mã học sinh 
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'student_id',
                            'readonly' => true,
                            'value' => '01'
                        ]) ?>
                    </div>
                    <div class="payment-add-field">
                        Tên học sinh
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'student_name',
                            'readonly' => true,
                            'value' => 'Nguyễn Văn A'
                        ]) ?>
                    </div>
                </div>
                <div class="payment-add-fields">
                    <div class="payment-add-field">
                        Lớp 
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'student_class',
                            'readonly' => true,
                            'value' => '11A1'
                        ]) ?>
                    </div>
                    <div class="payment-add-field">
                        Năm học
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'student_year',
                            'readonly' => true,
                            'value' => '2024-2025'
                        ]) ?>
                    </div>
                </div>
                <div class="payment-add-fields">
                    <div class="payment-add-field">
                        Tổng tiền
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'student_total',
                            'readonly' => true,
                            'value' => '1,000,000'
                        ]) ?>
                    </div>
                    <div class="payment-add-field">
                        Số tiền đã nhận
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'student_paid',
                            'required' => true,
                            'readonly' => false,
                            'value' => '',
                            'placeholder' => 'Nhập số tiền'
                        ]) ?>
                    </div>
                </div>
                <div class="payment-add-btns">
                    <a href="/sms/public/cashier/payment/list" style="text-decoration: none";>
                        <?= view('components/exit_button') ?>
                    </a>
                    <?= view('components/save_button') ?>
                </div>
            </form>
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

    .payment-add {
        display: flex;
        width: 100%;
        height: 100%;
        flex-direction: column;
        align-items: flex-start;
        background: #FFF;
    }

    .payment-add-heading {
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

    .payment-add-fields {
        display: flex;
        width: 100%;
        justify-content: space-between;
        align-items: center;
    }

    .payment-add-field {
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

    .payment-add-btns {
        display: flex;
        width: 100%;
        justify-content: center;
        align-items: center;
        gap: 20px;
    }
</style>