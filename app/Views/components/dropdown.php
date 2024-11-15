<div class="dropdown">
    <div class="dropdown-inner">
        Select an option
        <svg xmlns="http://www.w3.org/2000/svg" width="8" height="12" viewBox="0 0 8 12" fill="none">
            <path d="M7 8.27271L4 11L1 8.27271" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            <path d="M1 3.72727L4 1L7 3.72727" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
        <div class="dropdown-option">
            <div class="option">
                <p>Option 1</p>
            </div>
            <div class="option">
                <p>Option 2</p>
            </div>
            <div class="option">
                <p>Option 3</p>
            </div>
            <div class="option">
                <p>Option 4</p>
            </div>
            <div class="option">
                <p>Option 5</p>
            </div>
            <div class="option">
                <p>Option 6</p>
            </div>
        </div>
    </div>
</div>

<style>
    .dropdown {
        display: inline-flex;
        align-items: flex-start;
        position: relative;
    }

    .dropdown-inner {
        display: flex;
        width: 160px;
        padding: 6px 12px;
        justify-content: space-between;
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
        width: 160px;
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
    document.addEventListener("DOMContentLoaded", function() {
        const dropdownInner = document.querySelector('.dropdown-inner');
        const dropdownOptions = document.querySelector('.dropdown-option');

        // Toggle dropdown on click
        dropdownInner.addEventListener('click', function() {
            dropdownOptions.classList.toggle('show');
        });

        // Hide dropdown when clicking outside
        document.addEventListener('click', function(event) {
            if (!dropdownInner.contains(event.target)) {
                dropdownOptions.classList.remove('show');
            }
        });
    });
</script>