<?php if (!empty($studentList['PerformanceDetails']['Yếu']) && is_array($studentList['PerformanceDetails']['Yếu'])): ?>
    <table id="teacherRecordBad">
        <tr>
            <th>STT</th>
            <th>Mã học sinh</th>
            <th>Họ tên</th>
            <th>Điểm số</th>
        </tr>
        <?php foreach ($studentList['PerformanceDetails']['Yếu'] as $student): ?>
            <tr>
                <td><?= $student['STT'] ?></td>
                <td><?= $student['MaHS'] ?></td>
                <td><?= $student['HoTen'] ?></td>
                <td><?= $student['Diem'] ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php else: ?>
    <p>Không có dữ liệu học sinh.</p>
<?php endif; ?>

<style>
    #teacherRecordBad {
        width: 100%;
        font-family: "Inter";
        border-collapse: collapse;
        color: black;
    }

    #teacherRecordBad th {
        padding: 10px;
        text-align: left;
        background-color: rgba(185, 185, 185, 0.50);
        color: black;
    }

    #teacherRecordBad td {
        padding: 10px;
        text-align: left;
        color: black;
        background-color: white;
        border-top: 1px solid rgba(0, 60, 60, 0.50);
    }
</style>