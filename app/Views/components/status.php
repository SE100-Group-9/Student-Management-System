<?php

if (!function_exists('statusButton')) {
    function statusButton($status)
    {
        $classes = '';
        switch ($status) {
            case 'Đang học':
                $classes = 'status-third';
                break;
            case 'Mới tiếp nhận':
                $classes = 'status-secondary';
                break;
            case 'Nghỉ học':
                $classes = 'status-primary';
                break;  








            case 'Giáo viên':
                $classes = 'status-primary';
                break;
            case 'Đang bảo lưu':
                $classes = 'status-primary';
                break;
            case 'Chưa thu':
                $classes = 'status-third';
                break;
            case 'Đã thu':
                $classes = 'status-primary';
                break;
            case 'Đang làm việc':
                $classes = 'status-third';
                break;
            case 'Tổ trưởng':
                $classes = 'status-third';
                break;
            case 'Trả 1 phần':
                $classes = 'status-secondary';
                break;
            case 'Tổ phó':
                $classes = 'status-secondary';
                break;
            case 'Thu ngân':
                $classes = 'status-secondary';
                break;
            case 'Hết hạn bảo lưu':
                $classes = 'status-fourth';
                break;
            case 'Giám thị':
                $classes = 'status-fourth';
                break;
            default:
                $classes = 'status-default';
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
        font-size: 16px;
        width: auto;
    }

    /* Các trạng thái cụ thể với tiền tố status- */
    button.status-primary {
        --label-color: var(--White, #FFF);
        --background-color: var(--Cerulean, #01B3EF);
        border-radius: 40px;
    }

    button.status-secondary {
        --label-color: var(--White, #FFF);
        --background-color: var(--Regal-Blue, #01427A);
        border-radius: 40px;
    }

    button.status-third {
        --label-color: var(--White, #FFF);
        --background-color: var(--Cerise-Red, #E14177);
        border-radius: 40px;
    }

    button.status-fourth {
        --label-color: var(--White, #FFF);
        --background-color: var(--Dark-Grey, #6C6C6C);
        border-radius: 40px;
    }

    button.status-default {
        --label-color: var(--Black, #000);
        --background-color: var(--Light-Grey, #E0E0E0);
        border-radius: 40px;
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
    }
</style>