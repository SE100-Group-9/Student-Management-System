<div class="view-container">
    <button type="submit" class="button-view">
        <p>Xem<p>
    </button>
</div>

<style>
    .view-container {
        position: relative;
        display: flex;
        align-items: center;
    }

    .button-view {
        display: inline-flex;
        width: 50px;
        padding: 10px;
        justify-content: center;
        align-items: center;
        border-radius: 10px;
        border: 1px solid rgba(0, 60, 60, 0.20);
        background: rgba(175, 175, 175, 0.30);
        cursor: pointer;
    }

    .button p {
        color: #000;
        text-align: center;
        font-family: Inter;
        font-size: 14px;
        font-style: normal;
        font-weight: 400;
        line-height: normal;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', () => {
    const buttonView = document.querySelector('.button-view');
    const infoContainer = document.querySelector('.info-container');

    buttonView.addEventListener('click', () => {
        // Chỉ hiển thị thông tin nếu nó đang ẩn
        if (infoContainer.style.display === 'none' || infoContainer.style.display === '') {
            infoContainer.style.display = 'block';
        }
    });
});

</script>