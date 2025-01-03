<?php if (!empty($Conduct) && is_array($Conduct)): ?>
<div id="table-container">
    <table id="studentConduct">
        <thead>
            <tr>
                <th>Mã giám thị</th>
                <th>Tên giám thị</th>
                <th>Lỗi</th>
                <th>Điểm trừ</th>
                <th>Ngày vi phạm</th>
                <th> </th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($Conduct as $index => $conduct): ?>
                <tr>
                    <td><?= $conduct['MaGT'] ?></td>
                    <td><?= $conduct['TenGT'] ?></td>
                    <td><?= $conduct['TenLVP'] ?></td>
                    <td><?= $conduct['DiemTru'] ?></td>
                    <td><?= $conduct['NgayVP'] ?></td>
                </tr>
        <?php endforeach; ?>
            <tr>
                <td colspan="4"></td> 
                <td>Điểm tổng kết: <?= $Point ?></td>
                <?php if ($Point < 50): ?>
                <td style="color: red; font-weight: bold;">Bị cảnh báo</td>
                <?php endif; ?>
            </tr> 
        </tbody>
    </table>
    <div id="pagination-container"></div>
</div>
<?php else: ?>
    <p>Không có dữ liệu hạnh kiểm.</p>
    <td>Điểm tổng kết: 100</td>

<?php endif; ?>


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