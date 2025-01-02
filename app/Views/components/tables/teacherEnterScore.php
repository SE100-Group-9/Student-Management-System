<?php if (!empty($scoreList) && is_array($scoreList)): ?>
    <div id="table-container">
        <form method="POST" action="/sms/public/teacher/class/enter/next" id="score-form">
            <input type="hidden" name="year" value="<?= $NamHoc ?>">
            <input type="hidden" name="semester" value="<?= $HocKy ?>">
            <input type="hidden" name="subject" value="<?= $TenMH ?>">
            <table id="teacherEnterScore">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Mã học sinh</th>
                        <th>Họ tên</th>
                        <th>15 Phút lần 1</th>
                        <th>15 Phút lần 2</th>
                        <th>1 Tiết lần 1</th>
                        <th>1 Tiết lần 2</th>
                        <th>Cuối kỳ</th>
                        <th>Điểm trung bình môn</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($scoreList as $index => $score): ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td><?= $score['MaHocSinh'] ?></td>
                            <td><?= $score['HoTen'] ?></td>
                            <td>
                                <input type="text" name="scores[<?= $score['MaHocSinh'] ?>][Diem15P_1]" value="<?= $score['Diem15P_1'] ?>">
                            </td>
                            <td>
                                <input type="text" name="scores[<?= $score['MaHocSinh'] ?>][Diem15P_2]" value="<?= $score['Diem15P_2'] ?>">
                            </td>
                            <td>
                                <input type="text" name="scores[<?= $score['MaHocSinh'] ?>][Diem1Tiet_1]" value="<?= $score['Diem1Tiet_1'] ?>">
                            </td>
                            <td>
                                <input type="text" name="scores[<?= $score['MaHocSinh'] ?>][Diem1Tiet_2]" value="<?= $score['Diem1Tiet_2'] ?>">
                            </td>
                            <td>
                                <input type="text" name="scores[<?= $score['MaHocSinh'] ?>][DiemCK]" value="<?= $score['DiemCK'] ?>">
                            </td>
                            <td><?= $score['DiemTBMonHoc'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </form>
        <div id="pagination-container"></div>
    </div>
<?php else: ?>
    <p>Không có dữ liệu học sinh.</p>
<?php endif; ?>

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