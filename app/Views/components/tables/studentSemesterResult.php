<div id="table-container">
    <table id="studentSemesterResult">
        <tr>
            <th>Môn</th>
            <th colspan="2">Kiểm tra thường xuyên</th>
            <th colspan="2">Kiểm tra giữa kì</th>
            <th>Kiểm tra cuối kì</th>
            <th>Điểm trung bình học kì</th>
        </tr>
        <tr>
            <td>Giáo dục công dân</td>
            <td>10</td>
            <td>10</td>
            <td>10</td>
            <td>10</td>
            <td>10</td>
            <td>10</td>
        </tr>
        <tr>
            <td>Giáo dục công dân</td>
            <td>10</td>
            <td>10</td>
            <td>10</td>
            <td>10</td>
            <td>10</td>
            <td>10</td>
        </tr>
        <tr>
            <td>Giáo dục công dân</td>
            <td>10</td>
            <td>10</td>
            <td>10</td>
            <td>10</td>
            <td>10</td>
            <td>10</td>
        </tr>
        <tr>
            <td>Giáo dục công dân</td>
            <td>10</td>
            <td>10</td>
            <td>10</td>
            <td>10</td>
            <td>10</td>
            <td>10</td>
        </tr>
        <tr>
            <td>Giáo dục công dân</td>
            <td>10</td>
            <td>10</td>
            <td>10</td>
            <td>10</td>
            <td>10</td>
            <td>10</td>
        </tr>
        <tr>
            <td>Giáo dục công dân</td>
            <td>10</td>
            <td>10</td>
            <td>10</td>
            <td>10</td>
            <td>10</td>
            <td>10</td>
        </tr>
        <tr>
            <td>Giáo dục công dân</td>
            <td>10</td>
            <td>10</td>
            <td>10</td>
            <td>10</td>
            <td>10</td>
            <td>10</td>
        </tr>
        <tr>
            <td>Giáo dục công dân</td>
            <td>10</td>
            <td>10</td>
            <td>10</td>
            <td>10</td>
            <td>10</td>
            <td>10</td>
        </tr>
        <tr>
            <td>Giáo dục công dân</td>
            <td>10</td>
            <td>10</td>
            <td>10</td>
            <td>10</td>
            <td>10</td>
            <td>10</td>
        </tr>
        <tr>
            <td>Giáo dục công dân</td>
            <td>10</td>
            <td>10</td>
            <td>10</td>
            <td>10</td>
            <td>10</td>
            <td>10</td>
        </tr>
        <tr>
            <td>Giáo dục công dân</td>
            <td>10</td>
            <td>10</td>
            <td>10</td>
            <td>10</td>
            <td>10</td>
            <td>10</td>
        </tr>
    </table>
</div>
<div id="pagination-container"></div>

<style>
    #table-container {
        width: 100%;
        max-width: 100%;
        overflow-x: auto;
        margin: 0 auto;
    }

    #studentSemesterResult {
        width: 100%;
        table-layout: auto;
        font-family: "Inter";
        border-collapse: collapse;
        color: black;
    }

    #studentSemesterResult th {
        padding: 10px;
        text-align: left;
        background-color: rgba(185, 185, 185, 0.50);
        color: black;
    }

    #studentSemesterResult td {
        padding: 10px;
        text-align: left;
        color: black;
        background-color: white;
        border-top: 1px solid rgba(0, 60, 60, 0.50);
    }

    #pagination-container {
        display: flex;
        justify-content: flex-end;  
        align-items: center;
        margin-top: 10px;  
        width: 100%; 
    }

    .page-btn {
        padding: 5px 10px;
        margin: 0 5px;
        border: 1px solid #ddd;
        background-color: #f9f9f9;
        cursor: pointer;
    }

    .page-btn.active {
        background-color: #007BFF;
        color: white;
        border-color: #007BFF;
    }

    .page-btn:hover:not(.active) {
        background-color: #ddd;
    }

</style>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const allRows = Array.from(document.querySelectorAll('#studentSemesterResult tr')).slice(1);
        const rowsPerPage = 10;
        let currentPage = 1; // Trang hiện tại

        // Hàm render dữ liệu cho bảng theo trang
        function renderTable(page) {
            const start = (page - 1) * rowsPerPage;
            const end = start + rowsPerPage;

            const table = document.getElementById('studentSemesterResult');
            
            // Xóa các dòng hiện tại trong bảng, chỉ giữ lại header
            const tableRows = table.getElementsByTagName('tr');
            for (let i = tableRows.length - 1; i >= 1; i--) {
                table.deleteRow(i);
            }

            // Thêm các dòng dữ liệu của trang hiện tại
            const rowsToRender = allRows.slice(start, end);
            rowsToRender.forEach(row => table.appendChild(row.cloneNode(true)));
        }

        // Hàm tạo pagination
        function createPagination({ containerId, totalItems, itemsPerPage, onPageChange }) {
            const totalPages = Math.ceil(totalItems / itemsPerPage);
            const container = document.getElementById(containerId);

            container.innerHTML = ''; // Xóa các nút cũ nếu có

            // Nút "Trước"
            const prevButton = document.createElement('button');
            prevButton.textContent = '<';
            prevButton.classList.add('page-btn');
            prevButton.disabled = currentPage === 1; // Disable khi ở trang đầu tiên
            prevButton.addEventListener('click', () => {
                if (currentPage > 1) {
                    currentPage--;
                    updatePagination();
                    onPageChange(currentPage);
                }
            });
            container.appendChild(prevButton);

            // Các nút trang
            for (let i = 1; i <= totalPages; i++) {
                const button = document.createElement('button');
                button.textContent = i;
                button.classList.add('page-btn');
                if (i === currentPage) button.classList.add('active'); // Trang đầu tiên mặc định active

                button.addEventListener('click', () => {
                    currentPage = i;
                    updatePagination();
                    onPageChange(i);
                });

                container.appendChild(button);
            }

            // Nút "Tiếp"
            const nextButton = document.createElement('button');
            nextButton.textContent = '>';
            nextButton.classList.add('page-btn');
            nextButton.disabled = currentPage === totalPages; // Disable khi ở trang cuối cùng
            nextButton.addEventListener('click', () => {
                if (currentPage < totalPages) {
                    currentPage++;
                    updatePagination();
                    onPageChange(currentPage);
                }
            });
            container.appendChild(nextButton);
        }

        // Cập nhật pagination để đánh dấu trang active
        function updatePagination() {
            // Cập nhật các nút trang
            const buttons = document.querySelectorAll('.page-btn');
            buttons.forEach(btn => btn.classList.remove('active')); // Xóa active từ tất cả các nút
            const activeButton = Array.from(buttons).find(btn => btn.textContent == currentPage);
            if (activeButton) activeButton.classList.add('active');

            // Cập nhật trạng thái disabled cho nút "Trước" và "Tiếp"
            const prevButton = document.querySelector('.page-btn:first-child');
            const nextButton = document.querySelector('.page-btn:last-child');

            if (prevButton) prevButton.disabled = currentPage === 1; // Vô hiệu hóa nút "Trước" khi ở trang 1
            if (nextButton) nextButton.disabled = currentPage === Math.ceil(allRows.length / rowsPerPage); // Vô hiệu hóa nút "Tiếp" khi ở trang cuối
        }

        // Tạo pagination và render trang đầu tiên
        createPagination({
            containerId: 'pagination-container',
            totalItems: allRows.length,
            itemsPerPage: rowsPerPage,
            onPageChange: renderTable,
        });

        // Hiển thị trang đầu tiên
        renderTable(1);
    });
</script>
