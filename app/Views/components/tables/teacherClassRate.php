<div id="table-container">
    <table id="teacherClassRate">
        <thead>
            <tr>
                <th>Mã học sinh</th>
                <th>Họ tên</th>
                <th>Giới tính</th>
                <th>Email</th>
                <th>Số điện thoại</th>
                <th>Lớp</th>
                <th>Điểm trung bình</th>
                <th>Tình trạng</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>HS0001</td>
                <td>Nguyễn Văn A</td>
                <td>Nam</td>
                <td>nam@gmail.com</td>
                <td>0123456789</td>
                <td>11A1</td>
                <td>9</td>
                <td>
                    <?= view('components/status', ['status' => 'Đang học']); ?>
                </td>
                <td>
                    <a href="">
                        <?= view('components/edit_button'); ?>
                    </a>
                </td>
            </tr>
        </tbody>
    </table>
    <div id="pagination-container"></div>
</div>

<style>
    #table-container {
        width: 100%;
        max-width: 100%;
        overflow: auto;
        margin: 0 auto;
    }

    #teacherClassRate {
        width: 100%;
        font-family: "Inter";
        border-collapse: collapse;
        color: black;
    }

    #teacherClassRate th {
        padding: 10px;
        text-align: left;
        background-color: rgba(185, 185, 185, 0.50);
        color: black;
    }

    #teacherClassRate td {
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
    const tableElement = document.getElementById('teacherClassRate');
    const paginationContainer = document.getElementById('pagination-container');

    initializeTablePagination({
        tableElement,
        paginationContainer,
        rowsPerPage: 10,
    });
});
</script>