<?php if (!empty($worstStudents) && is_array($worstStudents)): ?>
    <div id="table-container">
        <table id="directorStaticsConduct">
            <thead>
                <tr>
                    <th>Hạng</th>
                    <th>Mã học sinh</th>
                    <th>Họ tên</th>
                    <th>Lớp</th>
                    <th>Điểm hạnh kiểm</th>
                    <th>Số lần vi phạm</th>
                    <th>Ghi chú</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($worstStudents as $index => $student): ?>
                    <tr>
                        <td><?= $index + 1 ?></td>
                        <td><?= $student['MaHS'] ?></td>
                        <td><?= $student['HoTen'] ?></td>
                        <td><?= $student['TenLop'] ?></td>
                        <td><?= $student['DiemHK'] ?></td>
                        <td><?= $student['SoLanViPham'] ?></td>
                        <td><?= $student['TrangThai'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php else: ?>
    <p>Không có dữ liệu học sinh.</p>
<?php endif; ?>

<style>
    #table-container {
        width: 100%;
        max-width: 100%;
        margin: 0 auto;
        overflow: hidden;
    }

    #directorStaticsConduct {
        width: 100%;
        font-family: "Inter";
        border-collapse: collapse;
        color: black;
    }

    #directorStaticsConduct thead th {
        position: sticky;
        top: 0;
        z-index: 1;
        padding: 10px;
        text-align: left;
        background-color: rgba(185, 185, 185, 0.50);
        color: black;
    }

    #directorStaticsConduct tbody {
        display: block;
        width: 100%;
        max-height: 400px;
        overflow-y: auto;
    }

    #directorStaticsConduct tbody td {
        padding: 10px;
        text-align: left;
        color: black;
        background-color: white;
        border-top: 1px solid rgba(0, 60, 60, 0.50);
    }

    #directorStaticsConduct thead {
        display: table;
        width: 100%;
        table-layout: fixed;
    }

    #directorStaticsConduct tbody tr {
        display: table;
        width: 100%;
        table-layout: fixed;
    }
</style>