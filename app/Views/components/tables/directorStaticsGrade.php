<?php if (!empty($topStudents) && is_array($topStudents)): ?>
    <table id="directorStaticsConduct">
        <tr>
            <th>Hạng</th>
            <th>Mã học sinh</th>
            <th>Họ tên</th>
            <th>Lớp</th>
            <th>Điểm trung bình</th>
        </tr>
        <?php foreach ($topStudents as $index => $student): ?>
            <tr>
                <td><?= $index + 1 ?></td>
                <td><?= $student['MaHS'] ?></td>
                <td><?= $student['HoTen'] ?></td>
                <td><?= $student['TenLop'] ?></td>
                <td><?= $student['DiemTB'] ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php else: ?>
    <p>Không có dữ liệu học sinh.</p>
<?php endif; ?>

<style>
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
    }

    #directorStaticsConduct td {
        padding: 10px;
        text-align: left;
        color: black;
        background-color: white;
        border-top: 1px solid rgba(0, 60, 60, 0.50);
    }
</style>