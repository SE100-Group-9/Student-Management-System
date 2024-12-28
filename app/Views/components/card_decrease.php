<?php
// Kiểm tra nếu các giá trị đã được truyền vào từ bên ngoài
$title = $title ?? "Số học sinh bảo lưu"; // giá trị mặc định
$count = $count ?? "5000"; // giá trị mặc định
$percentage = $percentage ?? "100.00%"; // giá trị mặc định
$comparison = $comparison ?? "so với năm 2023"; // giá trị mặc định
?>

<div class="card-decrease">
    <div class="decrease-info">
        <!-- Hiển thị giá trị title -->
        <h1><?= $title; ?></h1>
        <!-- Hiển thị giá trị count -->
        <h2><?= $count; ?></h2>
        <div class="decrease-number">
            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="24" viewBox="0 0 25 24" fill="none">
                <path d="M12.5 5V19M12.5 19L18.5 13M12.5 19L6.5 13" stroke="#E14177" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
            <!-- Hiển thị giá trị percentage -->
            <span><?= $percentage; ?></span>
        </div>
        <!-- Hiển thị giá trị comparison -->
        <p><?= $comparison; ?></p>
    </div>
    <svg xmlns="http://www.w3.org/2000/svg" width="81" height="81" viewBox="0 0 81 81" fill="none">
        <path d="M67.1681 57.1666L47.681 37.375C47.3308 37.0193 47.1541 36.8414 46.9974 36.7012C44.4662 34.4356 40.637 34.4356 38.1058 36.7012C37.9491 36.8414 37.7724 37.0193 37.4222 37.375C37.072 37.7306 36.8969 37.9085 36.7402 38.0488C34.209 40.3143 30.3799 40.3143 27.8487 38.0488C27.692 37.9085 27.5168 37.7306 27.1666 37.375L13.8333 23.8333M67.1681 57.1666L67.1666 37.1666M67.1681 57.1666H47.1666" stroke="#E14177" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
    </svg>
</div>

<style>
    .card-decrease {
        display: flex;
        height: 200px;
        width: 300px;
        padding: 20px;
        justify-content: center;
        align-items: center;
        border-radius: 10px;
        border: 1px solid rgba(0, 60, 60, 0.20);
        background: var(--White, #FFF);
    }

    .decrease-info {
        display: flex;
        width: 70%;
        flex-direction: column;
        align-items: flex-start;
        flex-shrink: 0;
        gap: 20px;
    }

    .decrease-info h1 {
        color: #000;
        font-family: Inter;
        font-size: 16px;
        font-style: normal;
        font-weight: 400;
        line-height: 20px;
    }

    .decrease-info h2 {
        color: #000;
        font-family: Inter;
        font-size: 28px;
        font-style: normal;
        font-weight: 700;
        line-height: 20px;
    }

    .decrease-info p {
        color: #000;
        font-family: Inter;
        font-size: 16px;
        font-style: normal;
        font-weight: 400;
        line-height: 20px;
    }

    .decrease-number {
        display: flex;
        align-items: center;
        gap: 13px;
        color: var(--Cerise-Red, #E14177);
        font-family: Inter;
        font-size: 16px;
        font-style: normal;
        font-weight: 700;
        line-height: 20px;
    }
</style>