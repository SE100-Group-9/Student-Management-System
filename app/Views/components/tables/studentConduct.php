<div id="table-container">
    <table id="studentConduct">
        <thead>
            <tr>
                <th>Mã giám thị</th>
                <th>Tên giám thị</th>
                <th>Ngày tạo</th>
                <th>Lỗi</th>
                <th>Điểm trừ</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>GT001</td>
                <td>Trần Thị B</td>
                <td>01-01-2024</td>
                <td>Đi trễ</td>
                <td>3</td>
            </tr>
            <tr>
                <td>GT001</td>
                <td>Trần Thị B</td>
                <td>01-01-2024</td>
                <td>Đi trễ</td>
                <td>3</td>
            </tr>
            <tr>
                <td>GT001</td>
                <td>Trần Thị B</td>
                <td>01-01-2024</td>
                <td>Đi trễ</td>
                <td>3</td>
            </tr>
            <tr>
                <td>GT001</td>
                <td>Trần Thị B</td>
                <td>01-01-2024</td>
                <td>Đi trễ</td>
                <td>3</td>
            </tr>
            <tr>
                <td>GT001</td>
                <td>Trần Thị B</td>
                <td>01-01-2024</td>
                <td>Đi trễ</td>
                <td>3</td>
            </tr>
            <tr>
                <td>GT001</td>
                <td>Trần Thị B</td>
                <td>01-01-2024</td>
                <td>Đi trễ</td>
                <td>3</td>
            </tr>
            <tr>
                <td>GT001</td>
                <td>Trần Thị B</td>
                <td>01-01-2024</td>
                <td>Đi trễ</td>
                <td>3</td>
            </tr>
            <tr>
                <td>GT001</td>
                <td>Trần Thị B</td>
                <td>01-01-2024</td>
                <td>Đi trễ</td>
                <td>3</td>
            </tr>
            <tr>
                <td>GT001</td>
                <td>Trần Thị B</td>
                <td>01-01-2024</td>
                <td>Đi trễ</td>
                <td>3</td>
            </tr>
            <tr>
                <td>GT001</td>
                <td>Trần Thị B</td>
                <td>01-01-2024</td>
                <td>Đi trễ</td>
                <td>3</td>
            </tr>
            <tr>
                <td>GT001</td>
                <td>Trần Thị B</td>
                <td>01-01-2024</td>
                <td>Đi trễ</td>
                <td>3</td>
            </tr>
            <tr>
                <td colspan="4"></td> 
                <td>Điểm tổng kết: 97</td>
            </tr>
        </tbody>
    </table>
    <div id="pagination-container"></div>
</div>

<style>

    #table-container {
        width: 100%;
        max-width: 100%;
        overflow-x: auto;
        margin: 0 auto;
    }

    #studentConduct {
        width: 100%;
        font-family: "Inter";
        border-collapse: collapse;
        color: black;
    }

    #studentConduct th {
        padding: 10px;
        text-align: left;
        background-color: rgba(185, 185, 185, 0.50);
        color: black;
    }

    #studentConduct td {
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
    const tableElement = document.getElementById('studentConduct');
    const paginationContainer = document.getElementById('pagination-container');

    initializeTablePagination({
        tableElement,
        paginationContainer,
        rowsPerPage: 10, 
    });
});
</script>