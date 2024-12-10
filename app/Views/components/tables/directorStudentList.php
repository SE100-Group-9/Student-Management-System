<?php if (!empty($studentlist) && is_array($studentlist)): ?>
<div id="table-container">
    <table id="directorStudentList">
        <thead>
            <tr>
                <th>STT</th>
                <th>Mã HS</th>
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
        </thead>
        <tbody>
            <?php foreach ($studentlist as $index => $student): ?>
                <tr>
                    <td><?= $index + 1 ?></td>
                    <td><?= $student['MaHS'] ?></td>
                    <td><?= $student['HoTen'] ?></td>
                    <td><?= $student['GioiTinh'] ?></td>
                    <td><?= $student['Email'] ?></td>
                    <td><?= $student['SoDienThoai'] ?></td>
                    <td><?= $student['TenLop'] ?? 'Chưa xếp lớp' ?></td>
                    <td><?= $student['DanToc'] ?></td>
                    <td><?= date('d/m/Y', strtotime($student['NgaySinh'])) ?></td>
                    <td><?= $student['NoiSinh'] ?></td>
                    <td>
                        <?= view('components/status', ['status' => $student['TinhTrang']]); ?>
                    </td>
                    <td>
                        <a href="/sms/public/director/student/update/<?= $student['MaHS'] ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="24" viewBox="0 0 25 24" fill="none">
                                <path d="M4.25 20H3.25C3.25 20.2652 3.35536 20.5196 3.5429 20.7071C3.73043 20.8946 3.98479 21 4.25001 21L4.25 20ZM4.25 16L3.54289 15.2929C3.35536 15.4804 3.25 15.7348 3.25 16H4.25ZM15.1186 5.13134L14.4115 4.42423L14.4115 4.42423L15.1186 5.13134ZM17.3813 5.13134L16.6742 5.83845L16.6742 5.83845L17.3813 5.13134ZM19.1186 6.8686L19.8257 6.16149L19.8257 6.16149L19.1186 6.8686ZM19.1186 9.13134L18.4115 8.42423L18.4115 8.42423L19.1186 9.13134ZM8.25 20L8.25001 21C8.51522 21 8.76957 20.8946 8.95711 20.7071L8.25 20ZM19.7869 7.691L20.7379 7.38198L20.7379 7.38198L19.7869 7.691ZM19.7869 8.30895L18.8358 7.99994L18.8358 7.99994L19.7869 8.30895ZM15.941 4.46313L15.632 3.51207L15.632 3.51207L15.941 4.46313ZM16.5591 4.46313L16.8681 3.51207L16.8681 3.51207L16.5591 4.46313ZM12.9571 7.29289C12.5666 6.90236 11.9334 6.90236 11.5429 7.29289C11.1524 7.68341 11.1524 8.31658 11.5429 8.7071L12.9571 7.29289ZM15.5429 12.7071C15.9334 13.0976 16.5666 13.0976 16.9571 12.7071C17.3476 12.3166 17.3476 11.6834 16.9571 11.2929L15.5429 12.7071ZM5.25 20V16H3.25V20H5.25ZM4.95711 16.7071L15.8257 5.83845L14.4115 4.42423L3.54289 15.2929L4.95711 16.7071ZM16.6742 5.83845L18.4115 7.57571L19.8257 6.16149L18.0885 4.42423L16.6742 5.83845ZM18.4115 8.42423L7.54289 19.2929L8.95711 20.7071L19.8257 9.83845L18.4115 8.42423ZM8.24999 19L4.24999 19L4.25001 21L8.25001 21L8.24999 19ZM18.4115 7.57571C18.6212 7.78538 18.7354 7.90068 18.8111 7.98986C18.8792 8.07014 18.8558 8.06142 18.8358 8.00002L20.7379 7.38198C20.6438 7.09225 20.4842 6.87034 20.3358 6.6955C20.1949 6.52957 20.0121 6.34784 19.8257 6.16149L18.4115 7.57571ZM19.8257 9.83845C20.0121 9.6521 20.1949 9.47036 20.3358 9.30444C20.4842 9.12959 20.6438 8.90769 20.7379 8.61797L18.8358 7.99994C18.8558 7.93855 18.8792 7.92983 18.8111 8.01009C18.7354 8.09927 18.6212 8.21456 18.4115 8.42423L19.8257 9.83845ZM18.8358 8.00002L18.8358 7.99994L20.7379 8.61797C20.8684 8.21628 20.8684 7.78367 20.7379 7.38198L18.8358 8.00002ZM15.8257 5.83845C16.0354 5.62878 16.1507 5.5146 16.2399 5.4389C16.3201 5.37078 16.3114 5.39424 16.25 5.41418L15.632 3.51207C15.3423 3.6062 15.1204 3.76576 14.9455 3.91419C14.7796 4.05505 14.5979 4.23788 14.4115 4.42423L15.8257 5.83845ZM18.0885 4.42423C17.9022 4.23794 17.7204 4.0551 17.5546 3.91427C17.3798 3.76583 17.1579 3.60622 16.8681 3.51207L16.2501 5.41418C16.1886 5.39422 16.1799 5.37071 16.2601 5.43883C16.3493 5.51456 16.4645 5.62873 16.6742 5.83845L18.0885 4.42423ZM16.25 5.41418H16.2501L16.8681 3.51207C16.4664 3.38156 16.0337 3.38156 15.632 3.51207L16.25 5.41418ZM11.5429 8.7071L15.5429 12.7071L16.9571 11.2929L12.9571 7.29289L11.5429 8.7071Z" fill="#01B3EF" />
                            </svg>
                        </a>
                        <svg class="delete-icon" xmlns="http://www.w3.org/2000/svg" width="25" height="24" viewBox="0 0 25 24" fill="none">
                            <path d="M14.25 10V17M10.25 10L10.25 17M4.25 6H20.25M18.25 6V17.8C18.25 18.9201 18.2502 19.4802 18.0322 19.908C17.8405 20.2844 17.5341 20.5902 17.1578 20.782C16.73 21 16.1703 21 15.0502 21H9.4502C8.33009 21 7.76962 21 7.3418 20.782C6.96547 20.5902 6.65973 20.2844 6.46799 19.908C6.25 19.4802 6.25 18.9201 6.25 17.8V6H18.25ZM16.25 6H8.25C8.25 5.06812 8.25 4.60216 8.40224 4.23462C8.60523 3.74456 8.99432 3.35523 9.48438 3.15224C9.85192 3 10.3181 3 11.25 3H13.25C14.1819 3 14.6478 3 15.0154 3.15224C15.5054 3.35523 15.8947 3.74456 16.0977 4.23462C16.2499 4.60216 16.25 5.06812 16.25 6Z" stroke="#E14177" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </td>
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
        overflow-x: auto;
        margin: 0 auto;
    }

    #directorStudentList {
        width: 100%;
        table-layout: auto;
        font-family: "Inter";
        border-collapse: collapse;
        color: black;
    }

    #directorStudentList th {
        padding: 10px;
        text-align: left;
        background-color: rgba(185, 185, 185, 0.50);
        color: black;
        white-space: nowrap;
    }

    #directorStudentList td {
        padding: 10px;
        text-align: left;
        color: black;
        background-color: white;
        border-top: 1px solid rgba(0, 60, 60, 0.50);
        white-space: nowrap;
    }

    #directorStudentList a {
        text-decoration: none;
        background-color: transparent;
    }

    #directorStudentList svg:hover {
        cursor: pointer;
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
        const tableElement = document.getElementById('directorStudentList');
        const paginationContainer = document.getElementById('pagination-container');

        initializeTablePagination({
            tableElement,
            paginationContainer,
            rowsPerPage: 10,
        });
    });
</script>