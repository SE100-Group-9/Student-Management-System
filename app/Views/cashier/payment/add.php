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
            Học phí / Quản lý học phí / Danh sách hóa đơn / Thêm thanh toán
            <h1>Thêm thanh toán:</h1>
            <form method="POST" action="/sms/public/cashier/payment/add/<?= $infor['MaHD'] ?>">
                <h2>Thông tin phiếu thanh toán:</h2>
                <div class="payment-add-fields">
                    <div class="payment-add-field">
                        Mã hóa đơn
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'MaHD',
                            'readonly' => true,
                            'value' => $infor['MaHD']
                        ]) ?>
                    </div>
                    <div class="payment-add-field">
                        Mã học sinh
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'MaHS',
                            'readonly' => true,
                            'value' => $infor['MaHS']
                        ]) ?>
                    </div>
                </div>
                    <div class="payment-add-fields">
                    <div class="payment-add-field">
                        Tên học sinh
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'TenHS',
                            'readonly' => true,
                            'value' => $infor['HoTenHocSinh']
                        ]) ?>
                    </div>
                    <div class="payment-add-field">
                        Tên lớp
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'TenLop',
                            'readonly' => true,
                            'value' => $infor['TenLop']
                        ]) ?>
                    </div>
                    </div>
                <div class="payment-add-fields">
                    <div class="payment-add-field">
                        Mã Thu ngân 
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'MaTN',
                            'readonly' => true,
                            'value' => $infor['MaTN']
                        ]) ?>
                    </div>
                    <div class="payment-add-field">
                        Tên Thu ngân 
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'TenTN',
                            'readonly' => true,
                            'value' => $infor['HoTenThuNgan']
                        ]) ?>
                    </div>
                </div>
                    <div class="payment-add-field">
                        Số tiển đóng
                        <?= view('components/input', [
                            'type' => 'text',
                            'name' => 'paid',
                            'required' => true,
                            'readonly' => false,
                            'value' => '',
                            'placeholder' => 'Nhập số tiền'
                        ]) ?>
                    </div>
                <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success">
                        <?= session()->getFlashdata('success') ?>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('errors')): ?>
                    <div class="alert alert-danger">
                        <?= session()->getFlashdata('error') ?>
                        <?php foreach (session()->getFlashdata('errors') as $error): ?>
                            <p><?= $error ?><p>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

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