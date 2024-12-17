<div class="table-container">
    <table id="directorStaticsConduct">
        <thead>
            <tr>
                <th>Mã số học sinh</th>
                <th>Họ tên</th>
                <th>Lớp</th>
                <th>Toán</th>
                <th>Lý</th>
                <th>Hóa</th>
                <th>Sinh</th>
                <th>Hạnh kiểm</th>
                <th>Xếp loại</th>
                <th>Nhận xét</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>01</td>
                <td>Lê Nguyễn Hoài Thương</td>
                <td>11A1</td>
                <td>10</td>
                <td>10</td>
                <td>10</td>
                <td>10</td>
                <td>Xuất sắc</td>
                <td>Xuất sắc</td>
                <td>Chăm</td>
            </tr>
            <tr>
                <td>02</td>
                <td>Đoàn Ngọc Hoàng</td>
                <td>11A1</td>
                <td>10</td>
                <td>10</td>
                <td>10</td>
                <td>10</td>
                <td>Xuất sắc</td>
                <td>Xuất sắc</td>
                <td>Chăm</td>
            </tr>
            <tr>
                <td>03</td>
                <td>Vũ Thị Oanh</td>
                <td>11A1</td>
                <td>10</td>
                <td>10</td>
                <td>10</td>
                <td>10</td>
                <td>Xuất sắc</td>
                <td>Xuất sắc</td>
                <td>Chăm</td>
            </tr>
            <tr>
                <td>04</td>
                <td>Phan Huỳnh Thành Khương</td>
                <td>11A1</td>
                <td>10</td>
                <td>10</td>
                <td>10</td>
                <td>10</td>
                <td>Xuất sắc</td>
                <td>Xuất sắc</td>
                <td>Chăm</td>
            </tr>
            <tr>
                <td>05</td>
                <td>Bùi Nhựt Tân</td>
                <td>11A1</td>
                <td>10</td>
                <td>10</td>
                <td>10</td>
                <td>10</td>
                <td>Xuất sắc</td>
                <td>Xuất sắc</td>
                <td>Chăm</td>
            </tr>
            <tr>
                <td>06</td>
                <td>Huỳnh Tuyết Nhi</td>
                <td>11A1</td>
                <td>10</td>
                <td>10</td>
                <td>10</td>
                <td>10</td>
                <td>Xuất sắc</td>
                <td>Xuất sắc</td>
                <td>Chăm</td>
            </tr>
            <tr>
                <td>07</td>
                <td>Hà Cẩm Tú</td>
                <td>11A1</td>
                <td>10</td>
                <td>10</td>
                <td>10</td>
                <td>10</td>
                <td>Xuất sắc</td>
                <td>Xuất sắc</td>
                <td>Chăm</td>
            </tr>
            <tr>
                <td>08</td>
                <td>Nguyễn Lê Trung</td>
                <td>11A1</td>
                <td>10</td>
                <td>10</td>
                <td>10</td>
                <td>10</td>
                <td>Xuất sắc</td>
                <td>Xuất sắc</td>
                <td>Chăm</td>
            </tr>
            <tr>
                <td>09</td>
                <td>Cao Long Nhựt</td>
                <td>11A1</td>
                <td>10</td>
                <td>10</td>
                <td>10</td>
                <td>10</td>
                <td>Xuất sắc</td>
                <td>Xuất sắc</td>
                <td>Chăm</td>
            </tr>
            <tr>
                <td>10</td>
                <td>Bùi Nhựt Tân</td>
                <td>11A1</td>
                <td>10</td>
                <td>10</td>
                <td>10</td>
                <td>10</td>
                <td>Xuất sắc</td>
                <td>Xuất sắc</td>
                <td>Chăm</td>
            </tr>
            <tr>
                <td>11</td>
                <td>Bùi Nhựt Tân</td>
                <td>11A1</td>
                <td>10</td>
                <td>10</td>
                <td>10</td>
                <td>10</td>
                <td>Xuất sắc</td>
                <td>Xuất sắc</td>
                <td>Chăm</td>
            </tr>
        </tbody>
    </table>
    <div id="pagination-container"></div>
</div>

<style>
    .table-container {
        display: block;
        margin: 0 auto;
        overflow-x: auto;
        width: 100%;
        height: 100%;
    }

    #directorStaticsConduct {
        width: 100%;
        font-family: "Inter";
        border-collapse: collapse;
        color: black;
    }

    #directorStaticsConduct th {
        padding: 10px;
        text-align: left;
        background-color: rgba(185, 185, 185, 0.50);
        color: black;
        white-space: nowrap;
    }

    #directorStaticsConduct td {
        padding: 10px;
        text-align: left;
        color: black;
        background-color: white;
        border-top: 1px solid rgba(0, 60, 60, 0.50);
        white-space: nowrap;
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
    const tableElement = document.getElementById('directorStaticsConduct'); 
    const paginationContainer = document.getElementById('pagination-container');

    initializeTablePagination({
        tableElement,
        paginationContainer,
        rowsPerPage: 10, 
    });
});
</script>