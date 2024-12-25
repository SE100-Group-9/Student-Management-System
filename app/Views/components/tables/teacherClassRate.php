<div id="table-container">
    <table id="teacherClassRate">
        <thead>
            <tr>
                <th>Mã học sinh</th>
                <th>Họ tên</th>
                <th>Lớp</th>
                <th>Điểm trung bình</th>
                <th>Nhận xét</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>HS0001</td>
                <td>Nguyễn Văn A</td>
                <td>11A1</td>
                <td>9</td>
                <td><input type="text" name="comment" value="Chăm"></td>
            </tr>
            <tr>
                <td>HS0001</td>
                <td>Nguyễn Văn A</td>
                <td>11A1</td>
                <td>9</td>
                <td><input type="text" name="comment" value="Chăm"></td>
            </tr>
            <tr>
                <td>HS0001</td>
                <td>Nguyễn Văn A</td>
                <td>11A1</td>
                <td>9</td>
                <td><input type="text" name="comment" value="Chăm"></td>
            </tr>
            <tr>
                <td>HS0001</td>
                <td>Nguyễn Văn A</td>
                <td>11A1</td>
                <td>9</td>
                <td><input type="text" name="comment" value="Chăm"></td>
            </tr>
            <tr>
                <td>HS0001</td>
                <td>Nguyễn Văn A</td>
                <td>11A1</td>
                <td>9</td>
                <td><input type="text" name="comment" value="Chăm"></td>
            </tr>
            <tr>
                <td>HS0001</td>
                <td>Nguyễn Văn A</td>
                <td>11A1</td>
                <td>9</td>
                <td><input type="text" name="comment" value="Chăm"></td>
            </tr>
            <tr>
                <td>HS0001</td>
                <td>Nguyễn Văn A</td>
                <td>11A1</td>
                <td>9</td>
                <td><input type="text" name="comment" value="Chăm"></td>
            </tr>
            <tr>
                <td>HS0001</td>
                <td>Nguyễn Văn A</td>
                <td>11A1</td>
                <td>9</td>
                <td><input type="text" name="comment" value="Chăm"></td>
            </tr>
            <tr>
                <td>HS0001</td>
                <td>Nguyễn Văn A</td>
                <td>11A1</td>
                <td>9</td>
                <td><input type="text" name="comment" value="Chăm"></td>
            </tr>
            <tr>
                <td>HS0001</td>
                <td>Nguyễn Văn A</td>
                <td>11A1</td>
                <td>9</td>
                <td><input type="text" name="comment" value="Chăm"></td>
            </tr>
            <tr>
                <td>HS0001</td>
                <td>Nguyễn Văn A</td>
                <td>11A1</td>
                <td>9</td>
                <td><input type="text" name="comment" value="Chăm"></td>
            </tr>
            <tr>
                <td>HS0001</td>
                <td>Nguyễn Văn A</td>
                <td>11A1</td>
                <td>9</td>
                <td><input type="text" name="comment" value="Chăm"></td>
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

    #teacherClassRate {
        width: 100%;
        font-family: "Inter";
        border-collapse: collapse;
        color: black;
    }

    #teacherClassRate th {
        padding: 10px;
        text-align: left;
        background-color: rgba(185, 185, 185, 0.50);
        color: black;
    }

    #teacherClassRate td {
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
    const tableElement = document.getElementById('teacherClassRate');
    const paginationContainer = document.getElementById('pagination-container');

    initializeTablePagination({
        tableElement,
        paginationContainer,
        rowsPerPage: 10,
    });
});
</script>