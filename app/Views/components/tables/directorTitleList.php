<table id="directorTitleList">
    <thead>
        <tr>
            <th>STT</th>
            <th>Tên danh hiệu</th>
            <th>Điểm trung bình tối thiểu</th>
            <th>Hạnh kiểm tối thiểu</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($titleList) && is_array($titleList)): ?>
        <?php foreach ($titleList as $index => $title): ?>
        <tr>
            <td><?= $index + 1 ?></td>
            <td><?= $title['TenDH'] ?></td>
            <td><?= $title['DiemTBToiThieu'] ?></td>
            <td><?= $title['DiemHanhKiemToiThieu'] ?></td>
            <td>
                <a href="/sms/public/director/title/update/<?= $title['MaDH'] ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="24" viewBox="0 0 25 24" fill="none">
                        <path d="M4.25 20H3.25C3.25 20.2652 3.35536 20.5196 3.5429 20.7071C3.73043 20.8946 3.98479 21 4.25001 21L4.25 20ZM4.25 16L3.54289 15.2929C3.35536 15.4804 3.25 15.7348 3.25 16H4.25ZM15.1186 5.13134L14.4115 4.42423L14.4115 4.42423L15.1186 5.13134ZM17.3813 5.13134L16.6742 5.83845L16.6742 5.83845L17.3813 5.13134ZM19.1186 6.8686L19.8257 6.16149L19.8257 6.16149L19.1186 6.8686ZM19.1186 9.13134L18.4115 8.42423L18.4115 8.42423L19.1186 9.13134ZM8.25 20L8.25001 21C8.51522 21 8.76957 20.8946 8.95711 20.7071L8.25 20ZM19.7869 7.691L20.7379 7.38198L20.7379 7.38198L19.7869 7.691ZM19.7869 8.30895L18.8358 7.99994L18.8358 7.99994L19.7869 8.30895ZM15.941 4.46313L15.632 3.51207L15.632 3.51207L15.941 4.46313ZM16.5591 4.46313L16.8681 3.51207L16.8681 3.51207L16.5591 4.46313ZM12.9571 7.29289C12.5666 6.90236 11.9334 6.90236 11.5429 7.29289C11.1524 7.68341 11.1524 8.31658 11.5429 8.7071L12.9571 7.29289ZM15.5429 12.7071C15.9334 13.0976 16.5666 13.0976 16.9571 12.7071C17.3476 12.3166 17.3476 11.6834 16.9571 11.2929L15.5429 12.7071ZM5.25 20V16H3.25V20H5.25ZM4.95711 16.7071L15.8257 5.83845L14.4115 4.42423L3.54289 15.2929L4.95711 16.7071ZM16.6742 5.83845L18.4115 7.57571L19.8257 6.16149L18.0885 4.42423L16.6742 5.83845ZM18.4115 8.42423L7.54289 19.2929L8.95711 20.7071L19.8257 9.83845L18.4115 8.42423ZM8.24999 19L4.24999 19L4.25001 21L8.25001 21L8.24999 19ZM18.4115 7.57571C18.6212 7.78538 18.7354 7.90068 18.8111 7.98986C18.8792 8.07014 18.8558 8.06142 18.8358 8.00002L20.7379 7.38198C20.6438 7.09225 20.4842 6.87034 20.3358 6.6955C20.1949 6.52957 20.0121 6.34784 19.8257 6.16149L18.4115 7.57571ZM19.8257 9.83845C20.0121 9.6521 20.1949 9.47036 20.3358 9.30444C20.4842 9.12959 20.6438 8.90769 20.7379 8.61797L18.8358 7.99994C18.8558 7.93855 18.8792 7.92983 18.8111 8.01009C18.7354 8.09927 18.6212 8.21456 18.4115 8.42423L19.8257 9.83845ZM18.8358 8.00002L18.8358 7.99994L20.7379 8.61797C20.8684 8.21628 20.8684 7.78367 20.7379 7.38198L18.8358 8.00002ZM15.8257 5.83845C16.0354 5.62878 16.1507 5.5146 16.2399 5.4389C16.3201 5.37078 16.3114 5.39424 16.25 5.41418L15.632 3.51207C15.3423 3.6062 15.1204 3.76576 14.9455 3.91419C14.7796 4.05505 14.5979 4.23788 14.4115 4.42423L15.8257 5.83845ZM18.0885 4.42423C17.9022 4.23794 17.7204 4.0551 17.5546 3.91427C17.3798 3.76583 17.1579 3.60622 16.8681 3.51207L16.2501 5.41418C16.1886 5.39422 16.1799 5.37071 16.2601 5.43883C16.3493 5.51456 16.4645 5.62873 16.6742 5.83845L18.0885 4.42423ZM16.25 5.41418H16.2501L16.8681 3.51207C16.4664 3.38156 16.0337 3.38156 15.632 3.51207L16.25 5.41418ZM11.5429 8.7071L15.5429 12.7071L16.9571 11.2929L12.9571 7.29289L11.5429 8.7071Z" fill="#01B3EF" />
                    </svg>
                </a>
                <a href="/sms/public/director/title/delete/<?= $title['MaDH'] ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa danh hiệu này?');">
                    <svg class="delete-icon" xmlns="http://www.w3.org/2000/svg" width="25" height="24" viewBox="0 0 25 24" fill="none">
                        <path d="M14.25 10V17M10.25 10L10.25 17M4.25 6H20.25M18.25 6V17.8C18.25 18.9201 18.2502 19.4802 18.0322 19.908C17.8405 20.2844 17.5341 20.5902 17.1578 20.782C16.73 21 16.1703 21 15.0502 21H9.4502C8.33009 21 7.76962 21 7.3418 20.782C6.96547 20.5902 6.65973 20.2844 6.46799 19.908C6.25 19.4802 6.25 18.9201 6.25 17.8V6H18.25ZM16.25 6H8.25C8.25 5.06812 8.25 4.60216 8.40224 4.23462C8.60523 3.74456 8.99432 3.35523 9.48438 3.15224C9.85192 3 10.3181 3 11.25 3H13.25C14.1819 3 14.6478 3 15.0154 3.15224C15.5054 3.35523 15.8947 3.74456 16.0977 4.23462C16.2499 4.60216 16.25 5.06812 16.25 6Z" stroke="#E14177" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </a>
            </td>
        </tr>
    </tbody>
    <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="5">Không có danh hiệu nào.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<style>
    #directorTitleList {
        width: 100%;
        font-family: "Inter";
        border-collapse: collapse;
        color: black;
    }

    #directorTitleList th {
        padding: 10px;
        text-align: left;
        background-color: rgba(185, 185, 185, 0.50);
        color: black;
    }

    #directorTitleList td {
        padding: 10px;
        text-align: left;
        color: black;
        background-color: white;
        border-top: 1px solid rgba(0, 60, 60, 0.50);
    }

    #directorTitleList a {
        text-decoration: none;
    }

    #directorTitleList a:hover {
        background-color: transparent;
    }

    #directorTitleList svg {
        cursor: pointer;
    }

    .dialog-overlay {
        display: flex;
        /* Chỉnh từ inline-flex thành flex */
        position: relative;
        top: 0%;
        left: 50%;
        right: 0;
        bottom: 50%;
        transform: translate(-50%, -50%);
        backdrop-filter: blur(30px);
        background-color: rgba(0, 0, 0, 0.1);
        justify-content: center;
        /* Căn giữa theo chiều dọc */
        align-items: center;
        /* Căn giữa theo chiều ngang */
        z-index: 1000;
    }

    .dialog-box {
        display: flex;
        padding: 24px;
        flex-direction: column;
        align-items: flex-start;
        gap: 16px;
        border-radius: 10px;
        background: var(--White, #FFF);
        box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25);
        /* Loại bỏ position absolute */
        width: auto;
        /* Đảm bảo kích thước tự động căn chỉnh theo nội dung */
        max-width: 500px;
        /* Giới hạn chiều rộng tối đa của hộp thoại */
        box-sizing: border-box;
    }

    .content {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        gap: 8px;
    }

    .content p {
        color: #000;
        font-family: Inter;
        font-size: 18px;
        font-style: normal;
        font-weight: 600;
        line-height: 28px;
    }

    .content h1 {
        display: inline;
        margin: 0;
    }


    .content h1 {
        color: #64748B;
        font-family: Inter;
        font-size: 14px;
        font-style: normal;
        font-weight: 400;
        line-height: 20px;
    }

    .button-section {
        display: flex;
        width: 464px;
        justify-content: flex-end;
        align-items: center;
        gap: 8px;
        align-self: stretch;
    }

    .cancel-btn {
        width: 100px;
        color: white;
        display: flex;
        height: 40px;
        padding: 0px 32px;
        justify-content: center;
        align-items: center;
        gap: 10px;
        border-radius: 5px;
        color: #000;
        font-family: Inter;
        font-size: 16px;
        font-style: normal;
        font-weight: 700;
        line-height: normal;
        letter-spacing: 0.48px;
        border: 1px solid #424242;
        cursor: pointer;
    }

    .confirm-btn {
        width: 100px;
        display: flex;
        height: 40px;
        padding: 0px 32px;
        justify-content: center;
        align-items: center;
        gap: 10px;
        border-radius: 5px;
        background: var(--Cerise-Red, #E14177);
        color: var(--White, #FFF);
        font-family: Inter;
        font-size: 16px;
        font-style: normal;
        font-weight: 700;
        line-height: normal;
        letter-spacing: 0.48px;
        border: none;
        cursor: pointer;
    }
</style>

