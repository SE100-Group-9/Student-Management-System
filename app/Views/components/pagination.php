<div id="pagination-container"></div>

<style>
    #pagination-container {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        margin-top: 10px;
        width: 100%;
        margin-left: auto;
    }

    .page-btn {
        padding: 5px 10px;
        margin: 0 5px;
        border: 1px solid #F9FAFB;
        background-color: #F9FAFB;
        cursor: pointer;
    }

    .page-btn.active {
        background-color: #01B3EF;
        color: white;
        border-color: #01B3EF;
    }

    .page-btn:hover:not(.active) {
        background-color: #F9FAFB;
    }
</style>

<script>
    function initializeTablePagination({
        tableElement,
        paginationContainer,
        rowsPerPage = 10
    }) {
        const allRows = Array.from(tableElement.querySelectorAll('tbody tr')); // Lấy tất cả các dòng trong tbody
        let currentPage = 1; // Trang hiện tại

        // Hàm render dữ liệu cho bảng theo trang
        function renderTable(page) {
            const start = (page - 1) * rowsPerPage;
            const end = start + rowsPerPage;

            // Lấy tbody của bảng (không động đến thead)
            const tbody = tableElement.querySelector('tbody');

            // Xóa các dòng hiện tại trong tbody
            while (tbody.firstChild) {
                tbody.removeChild(tbody.firstChild);
            }

            // Thêm các dòng dữ liệu của trang hiện tại vào tbody
            allRows.slice(start, end).forEach(row => tbody.appendChild(row.cloneNode(true)));
        }


        // Hàm tạo pagination
        function createPagination() {
    const totalPages = Math.ceil(allRows.length / rowsPerPage);
    paginationContainer.innerHTML = ''; // Xóa các nút cũ nếu có

    // Số lượng nút hiển thị tối đa mỗi lần
    const maxVisibleButtons = 5;
    const currentGroupStart = Math.max(1, currentPage - Math.floor(maxVisibleButtons / 2));
    const currentGroupEnd = Math.min(currentGroupStart + maxVisibleButtons - 1, totalPages);

    // Nút "Trước"
    const prevButton = document.createElement('button');
    prevButton.textContent = '<';
    prevButton.classList.add('page-btn');
    prevButton.disabled = currentPage === 1;
    prevButton.addEventListener('click', () => {
        if (currentPage > 1) {
            currentPage--; // Giảm trang hiện tại xuống 1
            createPagination(); // Cập nhật pagination
            renderTable(currentPage); // Hiển thị dữ liệu trang mới
        }
    });
    paginationContainer.appendChild(prevButton);

    // Tạo các nút trang hiển thị
    for (let i = currentGroupStart; i <= currentGroupEnd; i++) {
        const button = document.createElement('button');
        button.textContent = i;
        button.classList.add('page-btn');
        if (i === currentPage) button.classList.add('active');
        button.addEventListener('click', () => {
            currentPage = i; // Cập nhật trang hiện tại
            createPagination();
            renderTable(currentPage);
        });
        paginationContainer.appendChild(button);
    }

    // Nút "Tiếp"
    const nextButton = document.createElement('button');
    nextButton.textContent = '>';
    nextButton.classList.add('page-btn');
    nextButton.disabled = currentPage === totalPages;
    nextButton.addEventListener('click', () => {
        if (currentPage < totalPages) {
            currentPage++; // Tăng trang hiện tại lên 1
            createPagination(); // Cập nhật pagination
            renderTable(currentPage); // Hiển thị dữ liệu trang mới
        }
    });
    paginationContainer.appendChild(nextButton);
}

        // Cập nhật pagination để đánh dấu trang active
        function updatePagination() {
            const buttons = paginationContainer.querySelectorAll('.page-btn');
            buttons.forEach(btn => btn.classList.remove('active'));
            const activeButton = Array.from(buttons).find(btn => btn.textContent == currentPage);
            if (activeButton) activeButton.classList.add('active');

            const prevButton = paginationContainer.querySelector('.page-btn:first-child');
            const nextButton = paginationContainer.querySelector('.page-btn:last-child');

            prevButton.disabled = currentPage === 1;
            nextButton.disabled = currentPage === Math.ceil(allRows.length / rowsPerPage);
        }

        // Khởi tạo pagination và hiển thị trang đầu tiên
        createPagination();
        renderTable(currentPage);
    }
</script>