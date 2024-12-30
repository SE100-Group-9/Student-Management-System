<?php if (!empty($studentList) && is_array($studentList)): ?>
    <div id="table-container">
        <form method="POST" action="/sms/public/teacher/class/rate" id="comment-form">
            <input type="hidden" name="year" value="<?= $selectedYear ?>">
            <input type="hidden" name="semester" value="<?= $selectedSemester ?>">
            <input type="hidden" name="class" value="<?= $selectedClass ?>">
            <table id="teacherClassRate">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Mã học sinh</th>
                        <th>Họ tên</th>
                        <th>Môn học</th>
                        <th>Điểm trung bình môn</th>
                        <th>Nhận xét</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($studentList as $index => $student): ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td><?= $student['MaHS'] ?></td>
                            <td><?= $student['HoTen'] ?></td>
                            <td>
                                <?= $student['TenMH'] ?>
                                <?php if (!empty($student['TenMH'])): ?>
                                    <input type="hidden" name="comments[<?= $student['MaHS'] ?>][TenMH]" value="<?= $student['TenMH'] ?>">
                                <?php endif; ?>

                            </td>
                            <td><?= $student['DiemTBMonHoc'] ?></td>
                            <td>
                                <?php if (empty($student['DiemTBMonHoc'])): ?>
                                    <input type="text" name="comments[<?= $student['MaHS'] ?>][NhanXet]" value="<?= $student['NhanXet'] ?>" disabled placeholder="Chưa có điểm trung bình môn">
                                <?php else: ?>
                                    <input type="text" name="comments[<?= $student['MaHS'] ?>][NhanXet]" value="<?= $student['NhanXet'] ?>">
                                <?php endif; ?>
                            </td>
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

    #teacherClassRate {
        width: 100%;
        table-layout: auto;
        font-family: "Inter";
        border-collapse: collapse;
        color: black;
    }

    #teacherClassRate th {
        padding: 10px;
        text-align: left;
        background-color: rgba(185, 185, 185, 0.50);
        color: black;
        white-space: nowrap;
    }

    #teacherClassRate td {
        padding: 0 10px;
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

    input:disabled {
        color: #000;
        background-color: #fff;
        opacity: 1;
        cursor: text;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const tableElement = document.getElementById('teacherClassRate');
        const paginationContainer = document.getElementById('pagination-container');

        initializeTablePagination({
            tableElement,
            paginationContainer,
            rowsPerPage: 10,
        });
    });
</script>