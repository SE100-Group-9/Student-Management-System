 <button class="button-upload">
     <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
         <path d="M12 16L12 10M12 10L9 12M12 10L15 12M3 6V16.8C3 17.9201 3 18.4801 3.21799 18.908C3.40973 19.2843 3.71547 19.5902 4.0918 19.782C4.51962 20 5.08009 20 6.2002 20H17.8002C18.9203 20 19.48 20 19.9078 19.782C20.2841 19.5902 20.5905 19.2843 20.7822 18.908C21.0002 18.4801 21.0002 17.9201 21.0002 16.8L21.0002 9.20002C21.0002 8.07992 21.0002 7.51986 20.7822 7.09204C20.5905 6.71572 20.2841 6.40973 19.9078 6.21799C19.48 6 18.9201 6 17.8 6H3ZM3 6C3 4.89543 3.89543 4 5 4H8.67452C9.1637 4 9.40858 4 9.63875 4.05526C9.84282 4.10425 10.0379 4.18508 10.2168 4.29474C10.4186 4.41842 10.5916 4.59135 10.9375 4.93726L12.0002 6" stroke="#E14177" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
     </svg>
     Tải lên
 </button>


 <style>
     .button-upload {
         display: inline-flex;
         align-items: center;
         height: 40px;
         padding: 10px;
         gap: 10px;
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

     .button-upload:hover {
         background-color: #F5F5F5;
     }
 </style>

<script>
    document.addEventListener('DOMContentLoaded', () => {
    const uploadButton = document.querySelector('.button-upload');
    const fileInput = document.createElement('input'); // Tạo input type="file"
    fileInput.type = 'file';
    fileInput.style.display = 'none'; // Ẩn input file

    // Thêm input vào DOM
    document.body.appendChild(fileInput);

    // Khi người dùng nhấn vào nút Upload
    uploadButton.addEventListener('click', () => {
        fileInput.click(); // Kích hoạt input file
    });

    // Khi người dùng chọn tệp
    fileInput.addEventListener('change', (event) => {
        const files = event.target.files;
        if (files.length > 0) {
            const file = files[0];
            console.log('Tệp đã chọn:', file.name); // Hiển thị tên tệp đã chọn
        }
    });
});

</script>