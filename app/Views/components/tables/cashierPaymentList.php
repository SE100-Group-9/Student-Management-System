<?php if (!empty($paymentList) && is_array($paymentList)): ?>
<div id="table-container">
    <table id="cashierPaymentList">
        <thead>
            <tr>
                <th>Mã PTT</th>
                <th>Mã hóa đơn</th>
                <th>Mã Thu Ngân</th>
                <th>Họ tên</th>
                <th>Đã thanh toán</th>
                <th>Ngày thanh toán</th>         
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($paymentList as $index => $payment): ?>
                <tr>
                    <td><?= $payment['MaPTT'] ?></td>
                    <td><?= $payment['MaHD'] ?></td>
                    <td><?= $payment['MaTN'] ?></td>
                    <td><?= $payment['HoTen'] ?></td>
                    <td><?= $payment['DaThanhToan'] ?></td>
                    <td><?= $payment['NgayThanhToan']?></td>
                    <td>
                        <a href="/sms/public/cashier/payment/delete/<?= $payment['MaPTT'] ?>" title="Xóa thanh toán"  onclick="return confirm('Bạn có chắc chắn muốn xóa thanh toán này?')">
                        <svg fill="#FF0000" width="24" height="24" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMinYMin" class="jam jam-trash"><path d='M6 2V1a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v1h4a2 2 0 0 1 2 2v1a2 2 0 0 1-2 2h-.133l-.68 10.2a3 3 0 0 1-2.993 2.8H5.826a3 3 0 0 1-2.993-2.796L2.137 7H2a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h4zm10 2H2v1h14V4zM4.141 7l.687 10.068a1 1 0 0 0 .998.932h6.368a1 1 0 0 0 .998-.934L13.862 7h-9.72zM7 8a1 1 0 0 1 1 1v7a1 1 0 0 1-2 0V9a1 1 0 0 1 1-1zm4 0a1 1 0 0 1 1 1v7a1 1 0 0 1-2 0V9a1 1 0 0 1 1-1z'/></svg>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div id="pagination-container"></div>
</div>
<?php else: ?>
    <p>Không có dữ liệu thanh toán.</p>
<?php endif; ?>

<style>
    #table-container {
        width: 100%;
        max-width: 100%;
        overflow-x: auto;
        margin: 0 auto;
    }

    #cashierPaymentList {
        width: 100%;
        table-layout: auto;
        font-family: "Inter";
        border-collapse: collapse;
        color: black;
    }

    #cashierPaymentList th {
        padding: 10px;
        text-align: left;
        background-color: rgba(185, 185, 185, 0.50);
        color: black;
        white-space: nowrap;
    }

    #cashierPaymentList td {
        padding: 10px;
        text-align: left;
        color: black;
        background-color: white;
        border-top: 1px solid rgba(0, 60, 60, 0.50);
        white-space: nowrap;
    }

    #cashierPaymentList a {
        text-decoration: none;
        background-color: transparent;
    }

    #cashierPaymentList svg:hover {
        cursor: pointer;
    }

    #pagination-container {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        margin-top: 10px;
        width: 100%;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const tableElement = document.getElementById('cashierPaymentList');
        const paginationContainer = document.getElementById('pagination-container');

        initializeTablePagination({
            tableElement,
            paginationContainer,
            rowsPerPage: 10,
        });
    });
</script>