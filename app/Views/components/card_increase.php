<?php
// Kiểm tra nếu các giá trị đã được truyền vào từ bên ngoài
$title = $title ?? "Số học sinh nhập học"; // giá trị mặc định
$count = $count ?? "5000"; // giá trị mặc định
$percentage = $percentage ?? "100.00%"; // giá trị mặc định
$comparison = $comparison ?? "so với năm 2023"; // giá trị mặc định
?>

<div class="card-increase">
    <div class="increase-info">
        <!-- Hiển thị giá trị title -->
        <h1><?= $title; ?></h1>
        <!-- Hiển thị giá trị count -->
        <h2><?= $count; ?></h2>
        <div class="increase-number">
            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="24" viewBox="0 0 25 24" fill="none">
                <path d="M12.5 19V5M12.5 5L6.5 11M12.5 5L18.5 11" stroke="#01B3EF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
            <!-- Hiển thị giá trị percentage -->
            <span><?= $percentage; ?></span>
        </div>
        <!-- Hiển thị giá trị comparison -->
        <p><?= $comparison; ?></p>
    </div>
    <svg xmlns="http://www.w3.org/2000/svg" width="81" height="81" viewBox="0 0 81 81" fill="none">
        <path d="M67.1682 23.8333L47.681 43.6249C47.3308 43.9806 47.1541 44.1584 46.9974 44.2987C44.4662 46.5643 40.6371 46.5643 38.1059 44.2987C37.9492 44.1584 37.7725 43.9805 37.4223 43.6249C37.0721 43.2692 36.897 43.0913 36.7403 42.9511C34.2091 40.6855 30.3799 40.6855 27.8487 42.9511C27.692 43.0913 27.5169 43.2693 27.1667 43.6249L13.8334 57.1666M67.1682 23.8333L67.1667 43.8333M67.1682 23.8333H47.1667" stroke="#01B3EF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
    </svg>
</div>

<style>
    .card-increase {
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

    .increase-info {
        display: flex;
        width: 70%;
        flex-direction: column;
        align-items: flex-start;
        flex-shrink: 0;
        gap: 20px;
    }

    .increase-info h1 {
        color: #000;
        font-family: Inter;
        font-size: 16px;
        font-style: normal;
        font-weight: 400;
        line-height: 20px;
    }

    .increase-info h2 {
        color: #000;
        font-family: Inter;
        font-size: 28px;
        font-style: normal;
        font-weight: 700;
        line-height: 20px;
    }

    .increase-info p {
        color: #000;
        font-family: Inter;
        font-size: 16px;
        font-style: normal;
        font-weight: 400;
        line-height: 20px;
    }

    .increase-number {
        display: flex;
        align-items: center;
        gap: 13px;
        color: var(--Cerulean, #01B3EF);
        font-family: Inter;
        font-size: 16px;
        font-style: normal;
        font-weight: 700;
        line-height: 20px;
    }
</style>