<?php

if (!function_exists('statusButton')) {
    function statusButton($status)
    {
        $classes = '';
        switch ($status) {
            case 'Đang học':
                $classes = 'third';
                break;
            case 'Giáo viên':
                $classes = 'primary';
                break;
            case 'Đang bảo lưu':
                $classes = 'primary';
                break;
            case 'Chưa thu':
                $classes = 'third';
                break;
            case 'Đã thu':
                $classes = 'primary';
                break;
            case 'Đang làm':
                $classes = 'third';
                break;
            case 'Tổ trưởng':
                $classes = 'third';
                break;
            case 'Trả 1 phần':
                $classes = 'secondary';
                break;
            case 'Tổ phó':
                $classes = 'secondary';
                break;
            case 'Thu ngân':
                $classes = 'secondary';
                break;
            case 'Hết hạn bảo lưu':
                $classes = 'fourth';
                break;
            case 'Giám thị':
                $classes = 'fourth';
                break;
            default:
                $classes = 'default';
                break;
        }
        return '<button class="' . $classes . '">' . $status . '</button>';
    }
}

// Kiểm tra nếu có biến `$status` được truyền vào file
if (isset($status)) {
    echo statusButton($status);
}
?>




<style>
    button {
        color: var(--label-color);
        background-color: var(--background-color);
        border: none;
        padding: 10px 17px;
        border-radius: 40px;
        font-size: 16px;
        width: auto;
        /* Chỉnh lại chiều rộng cho button */
    }

    /* Các trạng thái cụ thể */
    button.primary {
        --label-color: var(--White, #FFF);
        --background-color: var(--Cerulean, #01B3EF);
    }

    button.secondary {
        --label-color: var(--White, #FFF);
        --background-color: var(--Regal-Blue, #01427A);
    }

    button.third {
        --label-color: var(--White, #FFF);
        --background-color: var(--Cerise-Red, #E14177);
    }

    button.fourth {
        --label-color: var(--White, #FFF);
        --background-color: var(--Dark-Grey, #6C6C6C);
    }

    button.default {
        --label-color: var(--Black, #000);
        --background-color: var(--Light-Grey, #E0E0E0);
    }


    /* Thêm khoảng cách giữa các button */
    button:not(:last-of-type) {
        margin-right: 16px;
    }

    /* Style chung cho container */
    .status-container {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        /* Cho phép bọc xuống dòng nếu cần */
    }
</style>