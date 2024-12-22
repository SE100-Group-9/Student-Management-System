<?php if (!empty($studentList) && is_array($studentList)): ?>
    <div class="table-container">
        <table id="directorStaticsConduct">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Mã HS</th>
                    <th>Họ tên</th>
                    <th>Lớp</th>
                    <th>Toán học</th>
                    <th>Vật lý</th>
                    <th>Hóa học</th>
                    <th>Sinh học</th>
                    <th>Điểm trung bình</th>
                    <th>Học lực</th>
                    <th>Hạnh kiểm</th>
                    <th>Danh hiệu</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach (array_values($studentList) as $index => $student): ?>
                    <tr>
                        <td><?= $index + 1 ?></td>
                        <td><?= $student['MaHS'] ?></td>
                        <td><?= $student['HoTen'] ?></td>
                        <td><?= $student['TenLop'] ?></td>
                        <td><?= $student['1'] ?></td>
                        <td><?= $student['2'] ?></td>
                        <td><?= $student['3'] ?></td>
                        <td><?= $student['4'] ?></td>
                        <td><?= $student['DiemTBHocKy'] ?></td>
                        <td><?= $student['HocLuc'] ?></td>
                        <td><?= $student['DiemHK'] ?></td>
                        <td><?= $student['DanhHieu'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div id="pagination-container"></div>
    </div>
<?php else: ?>
    <p>Không có dữ liệu học sinh.</p>
<?php endif; ?>

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