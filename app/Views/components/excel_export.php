<div class="excel-container">
    <button class="button-text">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
            <path d="M12 0C11.8654 0.000816118 11.7313 0.015212 11.5996 0.0429688L11.5977 0.0410156L1.62891 2.03516L1.62695 2.03711C1.16976 2.12391 0.757141 2.36743 0.460171 2.72572C0.163201 3.084 0.000467831 3.53464 0 4V20C9.94457e-05 20.466 0.162903 20.9173 0.4603 21.276C0.757698 21.6348 1.17102 21.8784 1.62891 21.9648L11.5977 23.959C11.73 23.9862 11.8648 24 12 24C12.5304 24 13.0391 23.7893 13.4142 23.4142C13.7893 23.0391 14 22.5304 14 22V2C14 1.46957 13.7893 0.960859 13.4142 0.585786C13.0391 0.210714 12.5304 0 12 0ZM16 2V5H18V7H16V9H18V11H16V13H18V15H16V17H18V19H16V22H22C23.105 22 24 21.105 24 20V4C24 2.895 23.105 2 22 2H16ZM20 5H21C21.552 5 22 5.448 22 6C22 6.552 21.552 7 21 7H20V5ZM3.18555 7H5.58789L6.83203 9.99023C6.93303 10.2342 7.0138 10.5169 7.0918 10.8379H7.125C7.17 10.6449 7.25853 10.3518 7.39453 9.9668L8.78516 7H10.9727L8.35938 11.9551L11.0508 16.998H8.7168L7.21289 13.7402C7.15589 13.6252 7.0892 13.3933 7.0332 13.0723H7.01172C6.97772 13.2263 6.91059 13.4586 6.80859 13.7676L5.29492 17H2.94922L5.73242 11.9941L3.18555 7ZM20 9H21C21.552 9 22 9.448 22 10C22 10.552 21.552 11 21 11H20V9ZM20 13H21C21.552 13 22 13.448 22 14C22 14.552 21.552 15 21 15H20V13ZM20 17H21C21.552 17 22 17.448 22 18C22 18.552 21.552 19 21 19H20V17Z" fill="#01B3EF"/>
        </svg>
        Xuất excel
    </button>
</div>


<style>
    .excel-container {
        position: relative;
        width: 200px;
        display: flex;
        align-items: center;
    }

    .button-text {
        display: inline-flex;
        align-items: center;
        height: 40px;
        padding: 10px;
        gap: 20px;
        border-radius: 10px;
        border: 1px solid rgba(0, 60, 60, 0.20);
        background-color: #FFF;
        color: #000;
        font-family: Inter, sans-serif;
        font-size: 16px;
        font-weight: 400;
        line-height: normal;
        cursor: pointer;
    }

    .svg {
        position: absolute;
        top: 50%;
        left: 100px;
        transform: translateY(-50%);     
    }
</style>