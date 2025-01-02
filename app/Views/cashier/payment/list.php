<link rel="stylesheet" href="<?= base_url(relativePath: 'assets/css/style.css') ?>">

<div class="invoice-lists">
    <div class="lists-heading">
        <?= view('components/heading'); ?>
    </div>
    <div class="body">
        <div class="body-left">
            <?= view('components/sidebar_cashier'); ?>
        </div>
        <div class="body-right">
            Học phí / Quản lý học phí / Danh sách hóa đơn / Lịch sử thanh toán
            <form method="GET" action="/sms/public/cashier/payment/list/<?= $MaHD ?>">
                <div class="tools">
                    <?= view('components/searchbar') ?>
                </div>
                <div class="tabless">
                    <?= view('components/tables/cashierPaymentList', ['paymentList' => $paymentList]) ?>
                </div>
            </form>
            <div style="max-width: 200px; align-items: flex-end">
                <?= view('components/pagination'); ?>
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

    .invoice-lists {
        display: flex;
        width: 100%;
        height: 100%;
        flex-direction: column;
        align-items: flex-start;
        background: var(--White, #FFF);
    }

    .lists-heading {
        width: 100%;
        height: 60px;
        position: fixed;
    }

    .body {
        display: flex;
        align-items: flex-start;
        flex: 1 0 0;
        margin-top: 60px;
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
        color: #000;
        font-family: Inter;
        font-size: 16px;
        font-style: normal;
        font-weight: 400;
        line-height: normal;
        overflow-y: auto;
    }

    .paymentlist-tools {
        display: flex;
        padding: 10px;
        align-items: flex-start;
        gap: 10px;
        align-self: stretch;
        border-radius: 10px;
        background: #FFF;
    }

    .tools {
        width: 50%;
        display: flex;
        gap: 10px;
    }

    .tabless {
        width: 100%;
        height: 100%;
    }
</style>


<script>
    document.getElementById('add-bill-btn').addEventListener('click', function () {
    window.location.href = "<?= base_url('cashier/invoice/add') ?>";;
    });
</script>