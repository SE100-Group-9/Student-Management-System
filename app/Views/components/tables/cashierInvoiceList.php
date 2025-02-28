<?php if (!empty($invoiceList) && is_array($invoiceList)): ?>
<div id="table-container">
    <table id="cashierInvoiceList">
        <thead>
            <tr>
                <th>Mã hóa đơn</th>
                <th>Mã học sinh</th>
                <th>Họ tên</th>
                <th>Tên lớp</th>
                <th>Năm học</th>
                <th>Tổng học phí</th>
                <th>Đã thanh toán</th>
                <th>Còn nợ</th>
                <th>Trạng thái</th>             
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($invoiceList as $index => $invoice): ?>
                <tr>
                    <td><?= $invoice['MaHD'] ?></td>
                    <td><?= $invoice['MaHS'] ?></td>
                    <td><?= $invoice['HoTen'] ?></td>
                    <td><?= $invoice['TenLop'] ?></td>
                    <td><?= $invoice['NamHoc'] ?></td>
                    <td><?= $invoice['TongHocPhi'] ?></td>
                    <td><?= $invoice['DaThanhToan'] ?></td>
                    <td><?= $invoice['ConNo']?></td>
                    <td>
                        <?= view('components/status', ['status' => $invoice['TrangThai']]); ?>
                    </td>
                    <td>
                        <a href="/sms/public/cashier/payment/list/<?= $invoice['MaHD'] ?>" title="Lịch sử thanh toán">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="16" viewBox="0 0 25 16" fill="none" style="vertical-align: middle;">
                                        <path d="M15.3333 8C15.3333 9.654 13.9873 11 12.3333 11C10.6793 11 9.33334 9.654 9.33334 8C9.33334 6.346 10.6793 5 12.3333 5C13.9873 5 15.3333 6.346 15.3333 8ZM24.3333 7.551C24.3333 7.551 20.0813 16 12.3483 16C5.16834 16 0.333344 7.551 0.333344 7.551C0.333344 7.551 4.77934 0 12.3483 0C20.0423 0 24.3333 7.551 24.3333 7.551ZM17.3333 8C17.3333 5.243 15.0903 3 12.3333 3C9.57634 3 7.33334 5.243 7.33334 8C7.33334 10.757 9.57634 13 12.3333 13C15.0903 13 17.3333 10.757 17.3333 8Z" fill="#E14177" />
                                    </svg>
                        <!-- Nếu ConNo = 0 thì ẩn icon bên dưới-->
                        </a>
                        <?php if ($invoice['ConNo'] > 0): ?>
                        <a href="/sms/public/cashier/payment/add/<?= $invoice['MaHD'] ?>" title="Thêm thanh toán">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" style="vertical-align: middle;">
                                <path d="M19.7654 6.15224L20.1481 5.22836V5.22836L19.7654 6.15224ZM20.9999 8.99999V9.99999C21.5522 9.99999 21.9999 9.55227 21.9999 8.99999H20.9999ZM20.8477 7.23462L21.7715 6.85194L20.8477 7.23462ZM3 8.99999H2C2 9.55227 2.44772 9.99999 3 9.99999V8.99999ZM19.7654 17.8478L20.1481 18.7717L19.7654 17.8478ZM20.9999 15H21.9999C21.9999 14.4477 21.5522 14 20.9999 14V15ZM20.8477 16.7654L19.9238 16.3827L20.8477 16.7654ZM3 15L3 14C2.73478 14 2.48043 14.1054 2.29289 14.2929C2.10536 14.4804 2 14.7348 2 15H3ZM3.15224 16.7654L2.22836 17.1481H2.22836L3.15224 16.7654ZM15 6C15 5.44772 14.5523 5 14 5C13.4477 5 13 5.44772 13 6H15ZM13 18C13 18.5523 13.4477 19 14 19C14.5523 19 15 18.5523 15 18H13ZM6 7H18V5H6V7ZM18 7C18.4796 7 18.7893 7.00054 19.0262 7.01671C19.2542 7.03227 19.3411 7.05888 19.3827 7.07612L20.1481 5.22836C19.8221 5.09336 19.4922 5.04385 19.1624 5.02135C18.8415 4.99946 18.4523 5 18 5V7ZM21.9999 8.99999C21.9999 8.54773 22.0004 8.15845 21.9785 7.8376C21.956 7.50778 21.9065 7.17786 21.7715 6.85194L19.9238 7.6173C19.941 7.65892 19.9676 7.74575 19.9832 7.97375C19.9994 8.21073 19.9999 8.52036 19.9999 8.99999H21.9999ZM19.3827 7.07612C19.6276 7.17758 19.8222 7.37219 19.9238 7.6173L21.7715 6.85194C21.4671 6.11693 20.8832 5.53288 20.1481 5.22836L19.3827 7.07612ZM4 8.99999C4 8.52036 4.00054 8.21073 4.01671 7.97375C4.03227 7.74575 4.05888 7.65892 4.07612 7.6173L2.22836 6.85194C2.09336 7.17786 2.04385 7.50777 2.02135 7.8376C1.99946 8.15845 2 8.54773 2 8.99999H4ZM6 5C5.54775 5 5.15852 4.99946 4.83772 5.02135C4.5079 5.04386 4.17807 5.09337 3.85218 5.22836L4.61755 7.07612C4.65919 7.05887 4.74599 7.03226 4.97389 7.01671C5.2108 7.00054 5.52037 7 6 7V5ZM4.07612 7.6173C4.17752 7.3725 4.3723 7.17771 4.61755 7.07612L3.85218 5.22836C3.11732 5.53275 2.53293 6.11663 2.22836 6.85194L4.07612 7.6173ZM6 19H18V17H6V19ZM18 19C18.4522 19 18.8415 19.0005 19.1624 18.9787C19.4922 18.9562 19.8221 18.9067 20.1481 18.7717L19.3827 16.9239C19.3411 16.9411 19.2543 16.9677 19.0263 16.9833C18.7893 16.9995 18.4796 17 18 17V19ZM19.9999 15C19.9999 15.4796 19.9994 15.7893 19.9832 16.0262C19.9676 16.2542 19.941 16.3411 19.9238 16.3827L21.7715 17.1481C21.9065 16.8221 21.956 16.4922 21.9785 16.1624C22.0004 15.8415 21.9999 15.4523 21.9999 15H19.9999ZM20.1481 18.7717C20.8832 18.4671 21.4671 17.883 21.7715 17.1481L19.9238 16.3827C19.8222 16.6278 19.6276 16.8225 19.3827 16.9239L20.1481 18.7717ZM2 15C2 15.4523 1.99946 15.8415 2.02135 16.1624C2.04385 16.4922 2.09336 16.8221 2.22836 17.1481L4.07612 16.3827C4.05888 16.3411 4.03227 16.2542 4.01671 16.0262C4.00054 15.7893 4 15.4796 4 15H2ZM6 17C5.52036 17 5.21079 16.9995 4.97387 16.9833C4.74597 16.9677 4.65918 16.9411 4.61755 16.9239L3.85218 18.7717C4.17809 18.9067 4.50793 18.9562 4.83774 18.9787C5.15853 19.0005 5.54776 19 6 19V17ZM2.22836 17.1481C2.53292 17.8833 3.11729 18.4673 3.85218 18.7717L4.61755 16.9239C4.37233 16.8223 4.17754 16.6275 4.07612 16.3827L2.22836 17.1481ZM20.9999 14C19.8954 14 19 13.1046 19 12H17C17 14.2091 18.7907 16 20.9999 16V14ZM19 12C19 10.8954 19.8954 9.99999 20.9999 9.99999V7.99999C18.7907 7.99999 17 9.79091 17 12H19ZM3 9.99999C4.10456 9.99999 5 10.8954 5 12H7C7 9.79087 5.20915 7.99999 3 7.99999V9.99999ZM5 12C5 13.1046 4.10457 14 3 14L3 16C5.20914 16 7 14.2091 7 12H5ZM13 6V18H15V6H13Z" fill="#01B3EF"/>
                            </svg>
                        </a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div id="pagination-container"></div>
</div>
<?php else: ?>
    <p>Không có dữ liệu hóa đơn.</p>
<?php endif; ?>

<style>
    #table-container {
        width: 100%;
        max-width: 100%;
        overflow-x: auto;
        margin: 0 auto;
    }

    #cashierInvoiceList {
        width: 100%;
        table-layout: auto;
        font-family: "Inter";
        border-collapse: collapse;
        color: black;
    }

    #cashierInvoiceList th {
        padding: 10px;
        text-align: left;
        background-color: rgba(185, 185, 185, 0.50);
        color: black;
        white-space: nowrap;
    }

    #cashierInvoiceList td {
        padding: 10px;
        text-align: left;
        color: black;
        background-color: white;
        border-top: 1px solid rgba(0, 60, 60, 0.50);
        white-space: nowrap;
    }

    #cashierInvoiceList a {
        text-decoration: none;
        background-color: transparent;
    }

    #cashierInvoiceList svg:hover {
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
        const tableElement = document.getElementById('cashierInvoiceList');
        const paginationContainer = document.getElementById('pagination-container');

        initializeTablePagination({
            tableElement,
            paginationContainer,
            rowsPerPage: 10,
        });
    });
</script>