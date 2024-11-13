<div class="pagination">
    <button class="page-btn" disabled>
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
            <path d="M15.1599 7.41L10.5799 12L15.1599 16.59L13.7499 18L7.74991 12L13.7499 6L15.1599 7.41Z" fill="#FCFCFC"/>
        </svg>
    </button>
    <button class="page-btn active">1</button>
    <button class="page-btn">2</button>
    <button class="page-btn">...</button>
    <button class="page-btn">9</button>
    <button class="page-btn">10</button>
    <button class="page-btn">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
            <path d="M8.84009 7.41L13.4201 12L8.84009 16.59L10.2501 18L16.2501 12L10.2501 6L8.84009 7.41Z" fill="#3C3C3C"/>
        </svg>
    </button>
</div>

<style>
    .pagination {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 8px;
        margin-top: 20px;
}

.page-btn {
    background-color: var(--White, #FFF);
    display: flex;
    justify-content: center;
    align-items: center;
    width: 32px;
    height: 32px;
    border: 1px solid #DFE3E8;
    color: var(--Dark-Grey-400, #212B36);
    padding: 5px 4px;
    font-size: 16px;
    cursor: pointer;
    border-radius: 4px;
    text-align: center;
    font-family: Inter;
    font-size: 14px;
    font-style: normal;
    font-weight: 700;
    line-height: 20px;
}

.page-btn.active {
    background-color: var(--Cerise-Red, #E14177);
    color: white;
    border: 1px solid #DFE3E8;
}

.page-btn:hover:not(.active) {
    background-color: #ddd;
}

.page-btn[disabled] {
    cursor: not-allowed;
    opacity: 0.5;
}

</style>