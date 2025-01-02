<?php
$options = $options ?? ['Option 1', 'Option 2', 'Option 3']; // Các tùy chọn mặc định
$dropdown_id = $dropdown_id ?? 'default-dropdown'; // Đảm bảo có ID
$name = $name ?? 'dropdown'; // Giá trị name mặc định cho form
$selected_text = $selected_text ?? 'Select an option'; // Text mặc định khi dropdown chưa chọn
$value = $value ?? '';
?>

<div class="dropdown" data-dropdown-id="<?= htmlspecialchars($dropdown_id) ?>">
    <div class="dropdown-inner">
        <input type="hidden" name="<?= htmlspecialchars($name) ?>" value="<?= htmlspecialchars($value) ?>" id="<?= htmlspecialchars($dropdown_id) ?>">
        <span class="selected-text"><?= htmlspecialchars($value ?: $selected_text) ?></span>
        <svg xmlns="http://www.w3.org/2000/svg" width="8" height="12" viewBox="0 0 8 12" fill="none">
            <path d="M7 8.27271L4 11L1 8.27271" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            <path d="M1 3.72727L4 1L7 3.72727" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
        <div class="dropdown-option">
            <?php foreach ($options as $option): ?>
                <div 
                    class="option <?= $option === $value ? 'selected' : '' ?>"
                    data-value="<?= htmlspecialchars($option, ENT_QUOTES, 'UTF-8') ?>">
                    <p><?= htmlspecialchars($option, ENT_QUOTES, 'UTF-8') ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>



<style>
    .dropdown {
        display: inline-flex;
        align-items: flex-start;
        position: relative;
        width: 100%;
    }

    .dropdown-inner {
        display: flex;
        width: 100%;
        padding: 6px 12px;
        justify-content: space-between;
        gap: 10px;
        align-items: center;
        border-radius: 5px;
        border: 1px solid #003C3C;
        color: #000;
        font-family: Inter;
        font-size: 14px;
        font-style: normal;
        font-weight: 400;
        line-height: 24px;
        cursor: pointer;
        /* 171.429% */
    }

    .dropdown-option {
        display: none;
        width: 100%;
        flex-direction: column;
        align-items: flex-start;
        gap: 5px;
        border-radius: 5px;
        border: 1px solid #003C3C;
        background: var(--White, #FFF);
        position: absolute;
        /* Giữ absolute để dropdown nằm đúng vị trí */
        top: 100%;
        left: 0;
        /* Đảm bảo căn giữa từ bên trái */
        z-index: 2000;
        max-height: 250px; /* Giới hạn chiều cao dropdown */
        overflow-y: auto; /* Thêm thanh cuộn dọc khi nội dung vượt quá chiều cao */
    }

    .option {
        display: flex;
        padding: 6px 8px 6px 32px;
        justify-content: center;
        align-items: center;
        gap: 10px;
        align-self: stretch;
    }

    .option p {
        flex: 1 0 0;
        align-self: stretch;
        color: #000;
        font-family: Inter;
        font-size: 14px;
        font-style: normal;
        font-weight: 400;
        line-height: 20px;
        /* 142.857% */
        letter-spacing: 0.42px;
    }

    .dropdown-option.show {
        display: flex;
        /* Show when toggled */
    }

    .option:hover {
        background-color: #6DCFFB;
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Đóng tất cả các dropdown
        function closeAllDropdowns() {
            document.querySelectorAll('.dropdown-option.show').forEach((dropdownOptions) => {
                dropdownOptions.classList.remove('show');
            });
        }

        // Xử lý khi nhấn vào một tùy chọn
        function handleOptionClick(option, dropdown) {
            const hiddenInput = dropdown.querySelector('input[type="hidden"]');
            const selectedText = dropdown.querySelector('.selected-text');

            // Cập nhật giá trị của dropdown
            const value = option.getAttribute('data-value');
            hiddenInput.value = value;
            selectedText.textContent = value;

            // Đánh dấu tùy chọn được chọn
            dropdown.querySelectorAll('.option').forEach((opt) => {
                opt.classList.remove('selected');
            });
            option.classList.add('selected');

            // Đóng dropdown
            closeAllDropdowns();
        }

        // Xử lý khi nhấn vào dropdown
        function handleDropdownClick(dropdown) {
            const dropdownOptions = dropdown.querySelector('.dropdown-option');
            if (dropdownOptions.classList.contains('show')) {
                dropdownOptions.classList.remove('show');
            } else {
                closeAllDropdowns();
                dropdownOptions.classList.add('show');
            }
        }

        // Thêm sự kiện cho dropdown và các tùy chọn
        document.querySelectorAll('.dropdown').forEach((dropdown) => {
            const dropdownInner = dropdown.querySelector('.dropdown-inner');
            const options = dropdown.querySelectorAll('.option');

            // Sự kiện click vào dropdown
            dropdownInner.addEventListener('click', function (event) {
                event.stopPropagation();
                handleDropdownClick(dropdown);
            });

            // Sự kiện click vào tùy chọn
            options.forEach((option) => {
                option.addEventListener('click', function (event) {
                    event.stopPropagation();
                    handleOptionClick(option, dropdown);
                });
            });
        });

        // Đóng tất cả dropdown khi click ra ngoài
        document.addEventListener('click', function () {
            closeAllDropdowns();
        });
    });


</script>