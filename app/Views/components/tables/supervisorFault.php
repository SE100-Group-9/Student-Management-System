<div id="table-container"> 
    <table id="supervisorFault">
        <thead>
            <tr>
                <th>Mã học sinh</th>
                <th>Tên học sinh</th>
                <th>Lớp</th>
                <th>Học kì</th>
                <th>Lỗi vi phạm</th>
                <th>Điểm trừ</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>22520xxx</td>
                <td>Nguyễn Văn A</td>
                <td>10A1</td>
                <td>1</td>
                <td>Đi trễ</td>
                <td>3</td>
            </tr>
            <tr>
                <td>22520xxx</td>
                <td>Nguyễn Văn A</td>
                <td>10A1</td>
                <td>1</td>
                <td>Đi trễ</td>
                <td>3</td>
            </tr>
            <tr>
                <td>22520xxx</td>
                <td>Nguyễn Văn A</td>
                <td>10A1</td>
                <td>1</td>
                <td>Đi trễ</td>
                <td>3</td>
            </tr>
            <tr>
                <td>22520xxx</td>
                <td>Nguyễn Văn A</td>
                <td>10A1</td>
                <td>1</td>
                <td>Đi trễ</td>
                <td>3</td>
            </tr>
            <tr>
                <td>22520xxx</td>
                <td>Nguyễn Văn A</td>
                <td>10A1</td>
                <td>1</td>
                <td>Đi trễ</td>
                <td>3</td>
            </tr>
            <tr>
                <td>22520xxx</td>
                <td>Nguyễn Văn A</td>
                <td>10A1</td>
                <td>2</td>
                <td>Đi trễ</td>
                <td>3</td>
            </tr>
            <tr>
                <td>22520xxx</td>
                <td>Nguyễn Văn A</td>
                <td>10A1</td>
                <td>2</td>
                <td>Đi trễ</td>
                <td>3</td>
            </tr>
            <tr>
                <td>22520xxx</td>
                <td>Nguyễn Văn A</td>
                <td>10A1</td>
                <td>2</td>
                <td>Đi trễ</td>
                <td>3</td>
            </tr>
            <tr>
                <td>22520xxx</td>
                <td>Nguyễn Văn A</td>
                <td>10A1</td>
                <td>2</td>
                <td>Đi trễ</td>
                <td>3</td>
            </tr>
            <tr>
                <td>22520xxx</td>
                <td>Nguyễn Văn A</td>
                <td>10A1</td>
                <td>2</td>
                <td>Đi trễ</td>
                <td>3</td>
            </tr>
            <tr>
                <td>22520xxx</td>
                <td>Nguyễn Văn A</td>
                <td>10A1</td>
                <td>1</td>
                <td>Đi trễ</td>
                <td>3</td>
            </tr>
            <tr>
                <td>22520xxx</td>
                <td>Nguyễn Văn A</td>
                <td>10A1</td>
                <td>1</td>
                <td>Đi trễ</td>
                <td>3</td>
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
    }

    #supervisorFault {
        width: 100%;
        font-family: "Inter";
        border-collapse: collapse;
        color: black;
    }

    #supervisorFault th {
        padding: 10px;
        text-align: left;
        background-color: rgba(185, 185, 185, 0.50);
        color: black;
    }

    #supervisorFault td {
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
    const tableElement = document.getElementById('supervisorFault');
    const paginationContainer = document.getElementById('pagination-container');

    initializeTablePagination({
        tableElement,
        paginationContainer,
        rowsPerPage: 10, 
    });
});

</script>