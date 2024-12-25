<div id="table-container">
    <table id="teacherEnterScore">
        <thead>
            <tr>
                <th>MSHS</th>
                <th>Tên học sinh</th>
                <th>15p (1)</th>
                <th>15p (2)</th>
                <th>45p (1)</th>
                <th>45p (2)</th>
                <th>Cuối kỳ</th>
                <th>Điểm trung bình</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>HS0001</td>
                <td>Nguyễn Văn A</td>
                <td><input type="text" name="score1" value="10"></td>
                <td><input type="text" name="score2" value=" "></td>
                <td><input type="text" name="score3" value="10"></td>
                <td><input type="text" name="score4" value="10"></td>
                <td><input type="text" name="score5" value=" "></td>
                <td><input type="text" name="score6" value=" "></td>
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

    #teacherEnterScore {
        width: 100%;
        font-family: "Inter";
        border-collapse: collapse;
        color: black;
        table-layout: auto;
    }

    #teacherEnterScore th {
        padding: 10px;
        text-align: left;
        background-color: rgba(185, 185, 185, 0.50);
        color: black;
        white-space: nowrap;
    }

    #teacherEnterScore td {
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
    const tableElement = document.getElementById('teacherEnterScore');
    const paginationContainer = document.getElementById('pagination-container');

    initializeTablePagination({
        tableElement,
        paginationContainer,
        rowsPerPage: 10,
    });
});
</script>