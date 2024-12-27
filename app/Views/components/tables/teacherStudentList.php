<?php if (!empty($studentList) && is_array($studentList)): ?>
<div id="table-container">
    <table id="teacherStudentList">
        <thead>
            <tr>
                <th>STT</th>
                <th>Mã học sinh</th>
                <th>Họ tên</th>
                <th>Giới tính</th>
                <th>Ngày sinh</th>
                <th>Số điện thoại</th>
                <th>Email</th>
                <th>Tình trạng</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($studentList as $index => $student): ?>
            <tr>
                <td><?= $index + 1 ?></td>
                <td><?= $student['MaHS'] ?></td>
                <td><?= $student['HoTen'] ?></td>
                <td><?= $student['GioiTinh'] ?></td>
                <td><?= date('d/m/Y', strtotime($student['NgaySinh'])) ?></td>
                <td><?= $student['SoDienThoai'] ?></td>
                <td><?= $student['Email'] ?></td>
                <td>
                    <?= view('components/status', ['status' => $student['TinhTrang']]); ?>
                </td>
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
    #table-container {
        width: 100%;
        max-width: 100%;
        overflow-x: auto;
        margin: 0 auto;
    }

    #teacherStudentList {
        width: 100%;
        table-layout: auto;
        font-family: "Inter";
        border-collapse: collapse;
        color: black;
    }

    #teacherStudentList th {
        padding: 10px;
        text-align: left;
        background-color: rgba(185, 185, 185, 0.50);
        color: black;
        white-space: nowrap;
    }

    #teacherStudentList td {
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
        const tableElement = document.getElementById('teacherStudentList');
        const paginationContainer = document.getElementById('pagination-container');

        initializeTablePagination({
            tableElement,
            paginationContainer,
            rowsPerPage: 10,
        });
    });
</script>