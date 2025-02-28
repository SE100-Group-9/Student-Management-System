<div class="table-container">
    <table id="directorStaticsConduct">
        <tr>
            <th>Mã số học sinh</th>
            <th>Họ tên</th>
            <th>Thông tin liên hệ</th>
            <th>Lớp học</th>
            <th>Tình trạng</th>
            <th>Lý do nghỉ</th>
            <th>Tiền nợ</th>
        </tr>
        <tr>
            <td>01</td>
            <td>Lê Nguyễn Hoài Thương</td>
            <td>lnht@gmail.com</td>
            <td>11A1</td>
            <td>
                <?= view('components/status', ['status' => 'Đang bảo lưu']); ?>
            </td>
            <td>Chuyển đi nơi khác</td>
            <td>1.000.000</td>
        </tr>
        <tr>
            <td>02</td>
            <td>Đoàn Ngọc Hoàng</td>
            <td>lnht@gmail.com</td>
            <td>11A1</td>
            <td>
                <?= view('components/status', ['status' => 'Đang bảo lưu']); ?>
            </td>
            <td>Chuyển đi nơi khác</td>
            <td>1.000.000</td>
        </tr>
        <tr>
            <td>03</td>
            <td>Vũ Thị Oanh</td>
            <td>lnht@gmail.com</td>
            <td>11A1</td>
            <td>
                <?= view('components/status', ['status' => 'Đang bảo lưu']); ?>
            </td>
            <td>Chuyển đi nơi khác</td>
            <td>1.000.000</td>
        </tr>
        <tr>
            <td>04</td>
            <td>Phan Huỳnh Thành Khương</td>
            <td>lnht@gmail.com</td>
            <td>11A1</td>
            <td>
                <?= view('components/status', ['status' => 'Đang bảo lưu']); ?>
            </td>
            <td>Chuyển đi nơi khác</td>
            <td>1.000.000</td>
        </tr>
        <tr>
            <td>05</td>
            <td>Bùi Nhựt Tân</td>
            <td>lnht@gmail.com</td>
            <td>11A1</td>
            <td>
                <?= view('components/status', ['status' => 'Đang bảo lưu']); ?>
            </td>
            <td>Chuyển đi nơi khác</td>
            <td>1.000.000</td>
        </tr>
        <tr>
            <td>06</td>
            <td>Huỳnh Tuyết Nhi</td>
            <td>lnht@gmail.com</td>
            <td>11A1</td>
            <td>
                <?= view('components/status', ['status' => 'Đang bảo lưu']); ?>
            </td>
            <td>Chuyển đi nơi khác</td>
            <td>1.000.000</td>
        </tr>
        <tr>
            <td>07</td>
            <td>Bạch Nguyệt Quang</td>
            <td>lnht@gmail.com</td>
            <td>11A1</td>
            <td>
                <?= view('components/status', ['status' => 'Đang bảo lưu']); ?>
            </td>
            <td>Chuyển đi nơi khác</td>
            <td>1.000.000</td>
        </tr>
        <tr>
            <td>08</td>
            <td>Nguyễn Lê Trung</td>
            <td>lnht@gmail.com</td>
            <td>11A1</td>
            <td>
                <?= view('components/status', ['status' => 'Hết hạn bảo lưu']); ?>
            </td>
            <td>Chuyển đi nơi khác</td>
            <td>1.000.000</td>
        </tr>
        <tr>
            <td>09</td>
            <td>Cao Long Nhựt</td>
            <td>lnht@gmail.com</td>
            <td>11A1</td>
            <td>
                <?= view('components/status', ['status' => 'Đang bảo lưu']); ?>
            </td>
            <td>Chuyển đi nơi khác</td>
            <td>1.000.000</td>
        </tr>
        <tr>
            <td>10</td>
            <td>Bùi Nhựt Tân</td>
            <td>lnht@gmail.com</td>
            <td>11A1</td>
            <td>
                <?= view('components/status', ['status' => 'Đang bảo lưu']); ?>
            </td>
            <td>Chuyển đi nơi khác</td>
            <td>1.000.000</td>
        </tr>
    </table>
</div>

<style>
    .table-container {
        display: block;
        /* Đảm bảo container là block */
        overflow-x: auto;
        width: 100%;
        height: 100%;
    }

    #directorStaticsConduct {
        min-width: 100%;
        font-family: "Inter";
        border-collapse: collapse;
        color: black;
        height: 100%;
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

    #directorStaticsConduct a {
        text-decoration: none;
    }

    #directorStaticsConduct a:hover {
        background-color: transparent;
    }

    #directorStaticsConduct svg {
        cursor: pointer;
    }
</style>