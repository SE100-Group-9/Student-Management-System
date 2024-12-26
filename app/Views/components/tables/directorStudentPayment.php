<?php if (!empty($tuitionList) && is_array($tuitionList)): ?>
    <div class="table-container">
        <table id="directorStaticsConduct">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Mã học sinh</th>
                    <th>Họ tên</th>
                    <th>Email</th>
                    <th>Lớp học</th>
                    <th>Trạng thái</th>
                    <th>Tiền nợ</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tuitionList as $index => $tuition): ?>
                    <tr>
                        <td><?= $index + 1 ?></td>
                        <td><?= $tuition['MaHS'] ?></td>
                        <td><?= $tuition['HoTen'] ?></td>
                        <td><?= $tuition['Email'] ?></td>
                        <td><?= $tuition['TenLop'] ?></td>
                        <td>
                            <?= view('components/status', ['status' => $tuition['TrangThai']]); ?>
                        </td>
                        <td><?= $tuition['TienNo'] ?></td>
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