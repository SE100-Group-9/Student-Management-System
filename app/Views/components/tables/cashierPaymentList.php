<div id="table-container">
    <table id="cashierPaymentList">
        <thead>
            <tr>
                <th>Mã thanh toán</th>
                <th>Mã học sinh</th>
                <th>Tên học sinh</th>
                <th>Tổng tiền</th>
                <th>Đã thanh toán</th>
                <th>Còn nợ</th>
                <th>Ngày thanh toán</th>
                <th>Kỳ tiếp</th>
                <th>Nội dung</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>HD001</td>
                <td>22520xxx</td>
                <td>Nguyễn Văn A</td>
                <td>1,000,000</td>
                <td>500,000</td>
                <td>500,000</td>
                <td>01-01-2024</td>
                <td>01-03-2024</td>
                <td>Thanh toán học phí</td>
                <td>
                    <?= view('components/viewmore_button'); ?>
                </td>
            </tr>
        </tbody>
    </table>
    <div id="pagination-container"></div>
</div>

<style>
    #table-container {
        width: 100%;
        max-width: 100%;
        overflow: auto;
        margin: 0 auto;
        max-height: 400px;
    }

    #cashierPaymentList {
        width: 100%;
        font-family: "Inter";
        border-collapse: collapse;
        color: black;
    }

    #cashierPaymentList th {
        padding: 10px;
        text-align: left;
        background-color: rgba(185, 185, 185, 0.50);
        color: black;
    }

    #cashierPaymentList td {
        padding: 10px;
        text-align: left;
        color: black;
        background-color: white;
        border-top: 1px solid rgba(0, 60, 60, 0.50);
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
    
    // Cập nhật sự kiện cho nút dropdown
    document.getElementById('button-viewmore').addEventListener('click', function() {
        var dropdown = document.getElementById('dropdown-button');
        dropdown.classList.toggle('show');
    });
});
</script>