<?php
// Gán giá trị mặc định nếu chưa có
$datepicker_id = $datepicker_id ?? 'default-datepicker'; // ID mặc định
$name = $name ?? 'datepicker'; // Name mặc định
$value = $value ?? ''; // Giá trị mặc định cho datepicker
?>

<div class="datepicker-container">
    <input
        type="date"
        id="<?= htmlspecialchars($datepicker_id) ?>"
        name="<?= htmlspecialchars($name) ?>"
        value="<?= htmlspecialchars($value) ?>">
</div>


<style>
    .datepicker-container {
        background-color: #fff;
        border-radius: 8px;
        text-align: center;
        width: 100%;
    }

    input[type="date"] {
        padding: 10px;
        font-size: 1.1em;
        font-family: Inter;
        border: 1px solid #ddd;
        border-radius: 10px;
        outline: none;
        width: 100%;
        height: 40px;
        box-sizing: border-box;
        transition: border-color 0.3s;
    }

    input[type="date"]:focus {
        border-color: #6DCFFB;
    }
</style>