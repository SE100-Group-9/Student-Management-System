<?php if (!empty($teacherList) && is_array($teacherList)): ?>
<table id="directorClassTeacher">
    <thead>
        <tr>
            <th>STT</th>
            <th>Mã giáo viên</th>
            <th>Tên giáo viên</th>
            <th>Ngày sinh</th>
            <th>Email</th>
            <th>Môn giảng dạy</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($teacherList as $index => $teacher): ?>
        <tr>
            <td><?= $index + 1 ?></td>
            <td><?= $teacher['MaGV'] ?></td>
            <td><?= $teacher['HoTen'] ?></td>
            <td><?= date('d/m/Y', strtotime($teacher['NgaySinh'])) ?></td>
            <td><?= $teacher['Email'] ?></td>
            <td><?= $teacher['TenMH'] ?></td>
            <td>
                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="24" viewBox="0 0 25 24" fill="none">
                    <path d="M14.3334 10V17M10.3334 10L10.3334 17M4.33337 6H20.3334M18.3334 6V17.8C18.3334 18.9201 18.3336 19.4802 18.1156 19.908C17.9239 20.2844 17.6175 20.5902 17.2412 20.782C16.8133 21 16.2537 21 15.1336 21H9.53357C8.41346 21 7.85299 21 7.42517 20.782C7.04885 20.5902 6.74311 20.2844 6.55136 19.908C6.33337 19.4802 6.33337 18.9201 6.33337 17.8V6H18.3334ZM16.3334 6H8.33337C8.33337 5.06812 8.33337 4.60216 8.48561 4.23462C8.6886 3.74456 9.07769 3.35523 9.56775 3.15224C9.93529 3 10.4015 3 11.3334 3H13.3334C14.2653 3 14.7312 3 15.0987 3.15224C15.5888 3.35523 15.978 3.74456 16.181 4.23462C16.3333 4.60216 16.3334 5.06812 16.3334 6Z" stroke="#E14177" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </td>
        </tr>
    </tbody>
    <?php endforeach; ?>
</table>
<?php else: ?>
    <p>Không có dữ liệu giáo viên.</p>
<?php endif; ?>

<style>
    #directorClassTeacher {
        width: 100%;
        font-family: "Inter";
        border-collapse: collapse;
        color: black;
    }

    #directorClassTeacher th {
        padding: 10px;
        background-color: rgba(185, 185, 185, 0.50);
        color: black;
        text-align: center;
    }

    #directorClassTeacher td {
        padding: 10px;
        text-align: left;
        text-align: center;
        color: black;
        background-color: white;
        border-top: 1px solid rgba(0, 60, 60, 0.50);
    }
</style>