<div class="searchbar">
    <input id="search-bar" type="text" name="search" value="<?= esc($searchTerm ?? '') ?>" placeholder="Tìm kiếm" />
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
        <path d="M15.7071 14.2929C15.3166 13.9024 14.6834 13.9024 14.2929 14.2929C13.9024 14.6834 13.9024 15.3166 14.2929 15.7071L15.7071 14.2929ZM20.2929 21.7071C20.6834 22.0976 21.3166 22.0976 21.7071 21.7071C22.0976 21.3166 22.0976 20.6834 21.7071 20.2929L20.2929 21.7071ZM10 16C6.68629 16 4 13.3137 4 10H2C2 14.4183 5.58172 18 10 18V16ZM4 10C4 6.68629 6.68629 4 10 4V2C5.58172 2 2 5.58172 2 10H4ZM10 4C13.3137 4 16 6.68629 16 10H18C18 5.58172 14.4183 2 10 2V4ZM16 10C16 13.3137 13.3137 16 10 16V18C14.4183 18 18 14.4183 18 10H16ZM14.2929 15.7071L20.2929 21.7071L21.7071 20.2929L15.7071 14.2929L14.2929 15.7071Z" fill="black" />
    </svg>
</div>

<style>
    .searchbar {
        display: flex;
        width: 100%;
        height: 40px; /* Chiều cao cố định */
        padding: 0 10px; /* Thêm padding cho khung bao quanh */
        justify-content: space-between; /* Giãn đều các phần tử */
        align-items: center; /* Căn giữa các phần tử theo chiều dọc */
        border-radius: 10px;
        border: 1px solid rgba(0, 60, 60, 0.20);
        background: var(--White, #FFF);
        transition: border-color 0.3s ease;
        color: #CCC;
        font-family: Inter, sans-serif;
        font-size: 16px;
        font-weight: 400;
        box-sizing: border-box; /* Bao gồm padding và border trong kích thước tổng thể */
    }

    .searchbar input {
        flex: 1; /* Chiếm không gian còn lại trong .searchbar */
        height: calc(100% - 2px); /* Chiều cao giảm trừ border nếu cần */
        background: transparent;
        color: #000;
        font-family: Inter, sans-serif;
        font-size: 14px;
        font-weight: 400;
        padding: 10px; /* Padding trong input */
        border: none; /* Xóa border mặc định */
        outline: none; /* Xóa viền mặc định khi focus */
        line-height: normal; /* Đặt lại line-height */
        vertical-align: middle;
        display: inline-block;
        box-sizing: border-box;
    }

    .searchbar svg {
        cursor: pointer;
        margin-left: 10px; /* Khoảng cách giữa biểu tượng và input */
    }
</style>

<script>
    document.getElementById('search-bar').addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase(); // Lấy từ khóa tìm kiếm và chuyển thành chữ thường

        // Lấy tất cả các bảng trong trang
        const tables = document.querySelectorAll('table'); // Lấy tất cả các bảng trên trang

        tables.forEach(function(table) {
            const rows = table.querySelectorAll('tbody tr'); // Lấy tất cả các hàng trong mỗi bảng

            rows.forEach(function(row) {
                const cells = row.querySelectorAll('td'); // Các cột trong mỗi hàng
                let rowText = ''; // Biến để lưu trữ văn bản của hàng

                // Lấy toàn bộ văn bản trong các cột của hàng
                cells.forEach(function(cell) {
                    rowText += cell.textContent.toLowerCase() +
                        ' '; // Thêm vào toàn bộ văn bản của hàng
                });

                // Kiểm tra xem từ khóa có trong văn bản của hàng không
                if (rowText.includes(searchTerm)) {
                    row.style.display = ''; // Hiển thị hàng nếu tìm thấy từ khóa
                } else {
                    row.style.display = 'none'; // Ẩn hàng nếu không tìm thấy từ khóa
                }
            });
        });
    });
</script>