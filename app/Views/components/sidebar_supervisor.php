<link rel="stylesheet" href="<?= base_url(relativePath: 'assets/css/style.css') ?>">
<div id="sidebar-supervisor" class="sidebar-supervisor">
    <div class="conduct-management">
        <h1>Hạnh kiểm</h1>
    </div>
    <div class="align">
        <div class="conduct-2 pointer" id="conduct-2" onclick="toggleDeeperConduct()">
            <div class="text">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path d="M6 11V6.20001C6 5.07991 6 4.51986 6.21799 4.09204C6.40973 3.71572 6.71547 3.40973 7.0918 3.21799C7.51962 3 8.08009 3 9.2002 3H13.6747C14.1639 3 14.4086 3 14.6388 3.05526C14.8428 3.10425 15.0379 3.18508 15.2168 3.29474C15.4186 3.41842 15.5916 3.59135 15.9375 3.93726L19.063 7.06274C19.4089 7.40864 19.5814 7.5816 19.705 7.78343C19.8147 7.96238 19.8953 8.15744 19.9443 8.36151C19.9996 8.59169 20 8.83632 20 9.3255V17.8C20 18.9201 20.0002 19.4801 19.7822 19.908C19.5905 20.2843 19.2841 20.5902 18.9078 20.782C18.48 21 17.9201 21 16.8 21H13M9 14L11 16M20.0002 9H17.2002C16.0801 9 15.5196 8.99997 15.0918 8.78198C14.7155 8.59024 14.4097 8.28429 14.218 7.90797C14 7.48014 14 6.9201 14 5.8V3M4 21V18.5L11.5 11L14 13.5L6.5 21H4Z" stroke="#01B3EF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <p>Quản lý hạnh kiểm</p>
            </div>
            <svg id="arrow-icon" class="svg-bottom" xmlns="http://www.w3.org/2000/svg" width="24" height="30" viewBox="0 0 24 30" fill="none">
                <path d="M19 11.25L12 20L5 11.25" stroke="#0C0C0D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </div>
        <div id="conduct-deeper" class="conduct-deeper">
            <div class="category pointer">
                <a style="text-decoration: none; background: none; color: inherit;" href="/sms/public/supervisor/category">
                    <p>Danh mục</p>
                </a>
            </div>
            <div class="fault pointer">
                <a style="text-decoration: none; background: none; color: inherit;" href="/sms/public/supervisor/conduct">
                    <p>Thông tin vi phạm</p>
                </a>
            </div>
        </div>
    </div>  
</div>

<style>
    .sidebar-supervisor {
        display: inline-flex;
        width: 250px;
        height: calc(100%);
        overflow-y: auto;
        padding: 20px;
        flex-direction: column;
        align-items: center;
        gap: 15px;
        position: relative;
        background: var(--White, #FFF);
        scrollbar-width: thin;
        scrollbar-color: #c1c1c1 #f5f5f5;
        transition: transform 0.3s ease, opacity 0.3s ease;
    }

    .align {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        gap: 20px;
        align-self: stretch;
        height: auto;
    }

    .sidebar-supervisor::-webkit-scrollbar {
        width: 8px;
        border-radius: 10px;
    }

    .sidebar-supervisor::-webkit-scrollbar-thumb {
        background-color: #c1c1c1;
        border-radius: 10px;
    }

    .sidebar-supervisor::-webkit-scrollbar-track {
        background: #f5f5f5;
        border-radius: 10px;
    }


    .conduct-management {
        display: flex;
        height: 30px;
        align-items: center;
        justify-content: space-between;
        align-self: stretch;
        cursor: default;
    }

    .text {
        display: flex;
        height: 30px;
        align-items: center;
        gap: 20px;
    }

    .pointer {
        cursor: pointer;
    }

    .conduct-2:hover {
        background: var(--Light-Blue, rgba(109, 207, 251, 0.20));
    }

    .category:hover, .fault:hover {
        background: var(--Light-Blue, rgba(109, 207, 251, 0.20));
    }

    .conduct-deeper {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.3s ease;
    }

    .conduct-deeper.open {
        max-height: 300px;
    }

    .conduct-deeper {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        align-self: stretch;
        gap: 20px;
        transition: max-height 0.3s ease;
        height: auto;
        overflow-y: auto;
    }

    .conduct-management h1 {
        color: var(--Silver, #AFAFAF);
        font-family: Inter;
        font-size: 14px;
        font-style: normal;
        font-weight: 400;
        line-height: normal;
    }

    .conduct-2 {
        display: flex;
        justify-content: space-between;
        align-items: center;
        align-self: stretch;
    }

    .category p, .fault p {
        color: #000;
        font-family: Inter;
        font-size: 14px;
        font-style: normal;
        font-weight: 400;
        line-height: normal;
    }

    .category, .fault {
        display: flex;
        height: 30px;
        padding: 0px 0px 0px 45px;
        align-items: center;
        gap: 10px;
        align-self: stretch;
    }

    .conduct-2:hover .svg-bottom path{
        stroke: #01B3EF;
    }

    #arrow-icon {
        transition: transform 0.3s ease;
    }
</style>

<script>
    function toggleDeeperConduct() {
        const deeperElement = document.getElementById('conduct-deeper');
        const arrowIcon = document.getElementById('arrow-icon');

        // Toggle lớp 'open' để bật/tắt hiệu ứng
        if (deeperElement.classList.contains('open')) {
            deeperElement.classList.remove('open');
            arrowIcon.style.transform = 'rotate(0deg)'; // Reset rotation
        } else {
            deeperElement.classList.add('open');
            arrowIcon.style.transform = 'rotate(180deg)'; // Rotate arrow
        }
    }
</script>
