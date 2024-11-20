<div id="pagination-container"></div>

<style>
    .pagination {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 8px;
    margin-top: 20px;
}

.page-btn {
    background-color: #FFF;
    display: flex;
    justify-content: center;
    align-items: center;
    width: 32px;
    height: 32px;
    border: 1px solid #DFE3E8;
    color: #212B36;
    font-size: 14px;
    font-weight: 700;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.page-btn.active {
    background-color: #E14177;
    color: white;
}

.page-btn:hover:not(.active) {
    background-color: #ddd;
}

.page-btn[disabled] {
    cursor: not-allowed;
    opacity: 0.5;
}
</style>

<script>
    function createPagination({
    containerId,
    totalItems,
    itemsPerPage = 10,
    onPageChange,
}) {
    const container = document.getElementById(containerId);
    if (!container) {
        console.error(`Container with ID "${containerId}" not found.`);
        return;
    }

    let currentPage = 1; // Trang hiện tại
    const totalPages = Math.ceil(totalItems / itemsPerPage); // Tổng số trang

    // Hàm render pagination
    function createPagination({
    containerId,
    totalItems,
    itemsPerPage = 10,
    onPageChange,
}) {
    const container = document.getElementById(containerId);
    if (!container) {
        console.error(`Container with ID "${containerId}" not found.`);
        return;
    }

    let currentPage = 1; // Trang hiện tại
    const totalPages = Math.ceil(totalItems / itemsPerPage); // Tổng số trang

    // Hàm render pagination
    function renderPagination() {
        container.innerHTML = ''; // Xóa nội dung cũ
        const pagination = document.createElement('div');
        pagination.className = 'pagination';

        // Nút "Trước"
        const prevButton = document.createElement('button');
        prevButton.className = 'page-btn';
        prevButton.textContent = '<';
        prevButton.disabled = currentPage === 1;
        prevButton.addEventListener('click', () => {
            if (currentPage > 1) {
                currentPage--;
                updatePagination();
            }
        });
        pagination.appendChild(prevButton);

        // Các nút trang
        for (let i = 1; i <= totalPages; i++) {
            const pageButton = document.createElement('button');
            pageButton.className = 'page-btn';
            if (i === currentPage) {
                pageButton.classList.add('active');
            }
            pageButton.textContent = i;
            pageButton.addEventListener('click', () => {
                currentPage = i;
                updatePagination();
            });
            pagination.appendChild(pageButton);
        }

        // Nút "Tiếp"
        const nextButton = document.createElement('button');
        nextButton.className = 'page-btn';
        nextButton.textContent = '>';
        nextButton.disabled = currentPage === totalPages;
        nextButton.addEventListener('click', () => {
            if (currentPage < totalPages) {
                currentPage++;
                updatePagination();
            }
        });
        pagination.appendChild(nextButton);

        container.appendChild(pagination);
    }

    // Hàm cập nhật pagination và gọi lại onPageChange
    function updatePagination() {
        renderPagination();
        if (typeof onPageChange === 'function') {
            onPageChange(currentPage); // Gọi callback khi trang thay đổi
        }
    }

    // Khởi tạo component
    renderPagination();
}
}

</script>