<div id="table-container">
    <table id="studentSemesterResult">
        <thead>
            <tr>
                <th>Môn</th>
                <th colspan="2">Kiểm tra thường xuyên</th>
                <th colspan="2">Kiểm tra giữa kì</th>
                <th>Kiểm tra cuối kì</th>
                <th>Điểm trung bình học kì</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Giáo dục công dân</td>
                <td>10</td>
                <td>10</td>
                <td>10</td>
                <td>10</td>
                <td>10</td>
                <td>10</td>
            </tr>
            <tr>
                <td>Giáo dục công dân</td>
                <td>10</td>
                <td>10</td>
                <td>10</td>
                <td>10</td>
                <td>10</td>
                <td>10</td>
            </tr>
            <tr>
                <td>Giáo dục công dân</td>
                <td>10</td>
                <td>10</td>
                <td>10</td>
                <td>10</td>
                <td>10</td>
                <td>10</td>
            </tr>
            <tr>
                <td>Giáo dục công dân</td>
                <td>10</td>
                <td>10</td>
                <td>10</td>
                <td>10</td>
                <td>10</td>
                <td>10</td>
            </tr>
            <tr>
                <td>Giáo dục công dân</td>
                <td>10</td>
                <td>10</td>
                <td>10</td>
                <td>10</td>
                <td>10</td>
                <td>10</td>
            </tr>
            <tr>
                <td>Giáo dục công dân</td>
                <td>10</td>
                <td>10</td>
                <td>10</td>
                <td>10</td>
                <td>10</td>
                <td>10</td>
            </tr>
            <tr>
                <td>Giáo dục công dân</td>
                <td>10</td>
                <td>10</td>
                <td>10</td>
                <td>10</td>
                <td>10</td>
                <td>10</td>
            </tr>
            <tr>
                <td>Giáo dục công dân</td>
                <td>10</td>
                <td>10</td>
                <td>10</td>
                <td>10</td>
                <td>10</td>
                <td>10</td>
            </tr>
            <tr>
                <td>Giáo dục công dân</td>
                <td>10</td>
                <td>10</td>
                <td>10</td>
                <td>10</td>
                <td>10</td>
                <td>10</td>
            </tr>
            <tr>
                <td>Giáo dục công dân</td>
                <td>10</td>
                <td>10</td>
                <td>10</td>
                <td>10</td>
                <td>10</td>
                <td>10</td>
            </tr>
            <tr>
                <td>Toán</td>
                <td>10</td>
                <td>10</td>
                <td>10</td>
                <td>10</td>
                <td>10</td>
                <td>10</td>
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

    #studentSemesterResult {
        width: 100%;
        table-layout: auto;
        font-family: "Inter";
        border-collapse: collapse;
        color: black;
    }

    #studentSemesterResult th {
        padding: 10px;
        text-align: left;
        background-color: rgba(185, 185, 185, 0.50);
        color: black;
    }

    #studentSemesterResult td {
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
    const tableElement = document.getElementById('studentSemesterResult');
    const paginationContainer = document.getElementById('pagination-container');

    initializeTablePagination({
        tableElement,
        paginationContainer,
        rowsPerPage: 10, 
    });
});
</script>
