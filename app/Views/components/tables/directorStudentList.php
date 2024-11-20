<div class="table-container">
    <table id="directorStaticsConduct">
        <tr>
            <th>Họ tên</th>
            <th>Giới tính</th>
            <th>Email</th>
            <th>Số điện thoại</th>
            <th>Lớp học</th>
            <th>Dân tộc</th>
            <th>Ngày sinh</th>
            <th>Nơi sinh</th>
            <th>Tình trạng</th>
            <th>Action</th>
        </tr>
        <tr>
            <td>Lê Nguyễn Hoài Thương</td>
            <td>Nữ</td>
            <td>lnht@gmail.com</td>
            <td>0123456789</td>
            <td>11A1</td>
            <td>Kinh</td>
            <td>11/05/2004</td>
            <td>TPHCM</td>
            <td>
                <?= view('components/status', ['status' => 'Đang bảo lưu']); ?>
            </td>
            <td>11A1</td>
        </tr>
        <tr>
            <td>Đoàn Ngọc Hoàng</td>
            <td>Nữ</td>
            <td>lnht@gmail.com</td>
            <td>0123456789</td>
            <td>11A1</td>
            <td>Kinh</td>
            <td>11/05/2004</td>
            <td>TPHCM</td>
            <td>
                <?= view('components/status', ['status' => 'Đang học']); ?>
            </td>
            <td>11A1</td>
        </tr>
        <tr>
            <td>Vũ Thị Oanh</td>
            <td>Nữ</td>
            <td>lnht@gmail.com</td>
            <td>0123456789</td>
            <td>11A1</td>
            <td>Kinh</td>
            <td>11/05/2004</td>
            <td>TPHCM</td>
            <td>
                <?= view('components/status', ['status' => 'Đang học']); ?>
            </td>
            <td>11A1</td>
        </tr>
        <tr>
            <td>Phan Huỳnh Thành Khương</td>
            <td>Nữ</td>
            <td>lnht@gmail.com</td>
            <td>0123456789</td>
            <td>11A1</td>
            <td>Kinh</td>
            <td>11/05/2004</td>
            <td>TPHCM</td>
            <td>
                <?= view('components/status', ['status' => 'Đang học']); ?>
            </td>
            <td>11A1</td>
        </tr>
        <tr>
            <td>Bùi Nhựt Tân</td>
            <td>Nữ</td>
            <td>lnht@gmail.com</td>
            <td>0123456789</td>
            <td>11A1</td>
            <td>Kinh</td>
            <td>11/05/2004</td>
            <td>TPHCM</td>
            <td>
                <?= view('components/status', ['status' => 'Đang học']); ?>
            </td>
            <td>11A1</td>
        </tr>
        <tr>
            <td>Huỳnh Tuyết Nhi</td>
            <td>Nữ</td>
            <td>lnht@gmail.com</td>
            <td>0123456789</td>
            <td>11A1</td>
            <td>Kinh</td>
            <td>11/05/2004</td>
            <td>TPHCM</td>
            <td>
                <?= view('components/status', ['status' => 'Đang học']); ?>
            </td>
            <td>11A1</td>
        </tr>
        <tr>
            <td>Hà Cẩm Tú</td>
            <td>Nữ</td>
            <td>lnht@gmail.com</td>
            <td>0123456789</td>
            <td>11A1</td>
            <td>Kinh</td>
            <td>11/05/2004</td>
            <td>TPHCM</td>
            <td>
                <?= view('components/status', ['status' => 'Đang học']); ?>
            </td>
            <td>11A1</td>
        </tr>
        <tr>
            <td>Nguyễn Lê Trung</td>
            <td>Nữ</td>
            <td>lnht@gmail.com</td>
            <td>0123456789</td>
            <td>11A1</td>
            <td>Kinh</td>
            <td>11/05/2004</td>
            <td>TPHCM</td>
            <td>
                <?= view('components/status', ['status' => 'Đang học']); ?>
            </td>
            <td>11A1</td>
        </tr>
        <tr>
            <td>Cao Long Nhựt</td>
            <td>Nữ</td>
            <td>lnht@gmail.com</td>
            <td>0123456789</td>
            <td>11A1</td>
            <td>Kinh</td>
            <td>11/05/2004</td>
            <td>TPHCM</td>
            <td>
                <?= view('components/status', ['status' => 'Đang học']); ?>
            </td>
            <td>11A1</td>
        </tr>
        <tr>
            <td>Bùi Nhựt Tân</td>
            <td>Nữ</td>
            <td>lnht@gmail.com</td>
            <td>0123456789</td>
            <td>11A1</td>
            <td>Kinh</td>
            <td>11/05/2004</td>
            <td>TPHCM</td>
            <td>
                <?= view('components/status', ['status' => 'Đang học']); ?>
            </td>
            <td>11A1</td>
        </tr>
    </table>
</div>

<style>
    .table-container {
        overflow-x: auto;
        width: 100%;
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
    }

    #directorStaticsConduct td {
        padding: 10px;
        text-align: left;
        color: black;
        background-color: white;
        border-top: 1px solid rgba(0, 60, 60, 0.50);
    }
</style>