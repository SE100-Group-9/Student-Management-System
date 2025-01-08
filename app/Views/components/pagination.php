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
            const totalGroups = Math.ceil(totalPages / maxVisibleButtons);

            // Xác định nhóm hiện tại
            const currentGroup = Math.ceil(currentPage / maxVisibleButtons);
            const groupStart = (currentGroup - 1) * maxVisibleButtons + 1;
            const groupEnd = Math.min(groupStart + maxVisibleButtons - 1, totalPages);

            // Nút "Trước Nhóm"
            const prevGroupButton = document.createElement('button');
            prevGroupButton.textContent = '<';
            prevGroupButton.classList.add('page-btn');
            prevGroupButton.disabled = currentGroup === 1;
            prevGroupButton.addEventListener('click', () => {
                if (currentGroup > 1) {
                    currentPage = groupStart - 1; // Chuyển sang nhóm trước
                    createPagination();
                    renderTable(currentPage);
                }
            });
            paginationContainer.appendChild(prevGroupButton);

            // Tạo các nút trong nhóm hiện tại
            for (let i = groupStart; i <= groupEnd; i++) {
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

            // Nút "Tiếp Nhóm"
            const nextGroupButton = document.createElement('button');
            nextGroupButton.textContent = '>';
            nextGroupButton.classList.add('page-btn');
            nextGroupButton.disabled = currentGroup === totalGroups;
            nextGroupButton.addEventListener('click', () => {
                if (currentGroup < totalGroups) {
                    currentPage = groupEnd + 1; // Chuyển sang nhóm tiếp theo
                    createPagination();
                    renderTable(currentPage);
                }
            });
            paginationContainer.appendChild(nextGroupButton);
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