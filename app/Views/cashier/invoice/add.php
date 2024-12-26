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
            <h1>Thêm hóa đơn:</h1>
            <form method="POST" action="/sms/public/cashier/invoice/add">
                <h2>Thông tin hóa đơn:</h2>
                <div class="payment-add-fields">
                    <div class="payment-add-field">
                        Mã học sinh 
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'student_id',
                            'required' => true,
                            'readonly' => false,
                            'value' => 'HS001',
                            'placeholder' => 'Nhập mã hs'
                        ]) ?>
                    </div>

                    <div class="payment-add-field">
                        Đợt
                        <?= view('components/dropdown', [
                            'name' => 'phase_dropdown'
                            'options' => 
                            [
                                'Học kì 1, năm học 2022 - 2023', 
                                'Học kì 2, năm học 2022 - 2023', 
                                'Học kì 1, năm học 2023 - 2024', 
                                'Học kì 2, năm học 2023 - 2024',              
                            ], 
                            'dropdown_id' => 'pay-dropdown',
                            'value' => '',
                            'required' => true,
                        ]) ?>
                    </div>
                </div>

                <div class="payment-add-fields">
                    <div class="payment-add-field">
                        Tổng tiền
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'student_total',
                            'required' => true,
                            'readonly' => true,
                            'value' => '16.000.000',
                        ]) ?>
                    </div>
                </div>
                <div class="payment-add-fields">
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

                <div class="payment-add-fields">
                    <div class="payment-add-field">
                        Thời gian đóng
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'student_time',
                            'required' => true,
                            'readonly' => false,
                            'value' => '',
                            'placeholder' => 'Nhập ngày thanh toán'
                        ]) ?>
                    </div>
                </div>

               
               
                <div class="payment-add-btns">
                    <a href="/sms/public/cashier/invoice/list" style="text-decoration: none";>
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