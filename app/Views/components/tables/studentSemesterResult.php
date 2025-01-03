<?php if (!empty($Score) && is_array($Score)): ?>
<div id="table-container">
    <table id="studentSemesterResult">
        <thead>
            <tr>
                <th>Môn</th>
                <th>Điểm 15' đợt 1</th>
                <th>Điểm 15' đợt 2</th>
                <th>Điểm GK đợt 1</th>
                <th>Điểm GK đợt 2</th>
                <th>Điểm CK </th>
                <th>Điểm trung bình học kì</th>
                <th>Nhận xét</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($Score as $index => $score): ?>
                <tr>
                    <td><?= $score['TenMH'] ?></td>
                    <td><?= $score['Diem15P_1'] ?></td>
                    <td><?= $score['Diem15P_2'] ?></td>
                    <td><?= $score['Diem1Tiet_1'] ?></td>
                    <td><?= $score['Diem1Tiet_2'] ?></td>
                    <td><?= $score['DiemCK'] ?></td>
                    <td><?= $score['DiemTBHK'] ?></td>
                    <td><?= $score['NhanXet'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div id="pagination-container"></div>
</div>
<?php else: ?>
    <p>Không có dữ liệu điểm.</p>
<?php endif; ?>

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
