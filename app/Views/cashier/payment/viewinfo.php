<div class="cashier-view-info">
    <?= view('components/heading'); ?>
    <div class="body">
        <?= view('components/sidebar_cashier'); ?>
        <div class="body-right">
            <p>Học phí / Quản lý học phí / Danh sách / Thông tin</p>
            <div class="content">
                <div class="cashier-info">
                    <div class="group">
                        <label for="total">Tổng tiền</label>
                        <?= view('components/input', [
                            'id' => 'total',
                            'value' => '1,000,000',
                            'readonly' => true
                        ]); ?>
                    </div>
                    <div class="group">
                        <label for="paid">Đã thanh toán</label>
                        <?= view('components/input', [
                            'id' =>'paid',
                            'value' => '1,000,000',
                            'readonly' => true
                        ]); ?>
                    </div>
                </div>
                <div class="cashier-info">
                    <div class="group">
                        <label for="not-paid">Chưa thanh toán</label>
                        <?= view('components/input', [
                            'id' => 'not-paid',
                            'value' => ' ',
                            'readonly' => true
                        ]); ?>
                    </div>
                    <div class="group">
                        <label for="method">Phương thức thanh toán</label>
                        <?= view('components/input', [
                            'id' =>'method',
                            'value' => 'Chuyển khoản',
                            'readonly' => true
                        ]); ?>
                    </div>
                </div>
                <div class="cashier-info">
                    <div class="group">
                        <label for="name">Người thanh toán</label>
                        <?= view('components/input', [
                            'id' => 'name',
                            'value' => 'Nguyễn Văn A',
                            'readonly' => true
                        ]); ?>
                    </div>
                    <div class="group">
                        <label for="id">Mã số sinh viên</label>
                        <?= view('components/input', [
                            'id' =>'id',
                            'value' => '22520857',
                            'readonly' => true
                        ]); ?>
                    </div>
                </div>
                <div class="cashier-info">
                    <div class="group">
                        <label for="payment-date">Ngày thanh toán</label>
                        <?= view('components/input', [
                            'id' => 'payment-date',
                            'value' => '01-01-2024',
                            'readonly' => true
                        ]); ?>
                    </div>
                    <div class="group">
                        <label for="payment-date-next">Ngày thanh toán kế tiếp</label>
                        <?= view('components/input', [
                            'id' =>'payment-date-next',
                            'value' => ' ',
                            'readonly' => true
                        ]); ?>
                    </div>
                </div>
                <div class="cashier-info">
                    <div class="group">
                        <label for="note">Nội dung</label>
                        <?= view('components/input', [
                            'id' => 'note',
                            'value' => 'Thanh toán học phí',
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

    .cashier-view-info {
        display: flex;
        flex-direction: column;
        width: 100%;
        height: 100%;
        overflow: auto;
    }

    .body {
        display: flex;
        flex-direction: row;
        height: 100%;
        background: var(--light-grey, #F9FAFB);
    }

    .body-right {
        display: flex;
        padding: 20px;
        flex-direction: column;
        align-items: flex-start;
        gap: 30px;
        flex: 1 0 0;
        align-self: stretch;
    }

    .body-right p {
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
        /* align-self: stretch; */
        align-items: flex-start;
        gap: 20px;
        border-radius: 10px;
        background: var(--White, #FFF);
    }

    .cashier-info {
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

    .group label {
        color: #000;
        font-family: Inter;
        font-size: 14px;
        font-style: normal;
        font-weight: 500;
        line-height: normal;
    }
</style>