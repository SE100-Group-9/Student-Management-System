<?php if (!empty($ViPham) && is_array($ViPham)): ?>
<div id="table-container"> 
    <table id="supervisorFault">
        <thead>
            <tr>
                <th>Mã vi phạm</th>
                <th>Mã học sinh</th>
                <th>Tên học sinh</th>
                <th>Lớp</th>
                <th>Lỗi vi phạm</th>
                <th>Điểm trừ</th>
                <th>Người tạo</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
             <?php foreach ($ViPham as $index => $vipham): ?>
                <tr>
                    <td><?= $vipham['MaVP'] ?></td>
                    <td><?= $vipham['MaHS'] ?></td>
                    <td><?= $vipham['TenHS'] ?></td>
                    <td><?= $vipham['TenLop'] ?></td>
                    <td><?= $vipham['TenLVP'] ?></td>
                    <td><?= $vipham['DiemTru'] ?></td>
                    <td><?= $vipham['TenGT'] ?></td>
                    <td colspan="2">
                        <div class="button-container" style="display: flex; align-items: center; gap: 5px;">
                            <a href="/sms/public/supervisor/faultDetail/<?= $vipham['MaVP'] ?>" title="Xem chi tiết">
                            <svg width="24px" height="24px" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                                <path fill="#6C6C6C" d="M8,2 C14,2 16,8 16,8 C16,8 14,14 8,14 C2,14 0,8 0,8 C0,8 2,2 8,2 Z M8,4 C5.76219,4 4.27954,5.08865 3.28644,6.28037 C2.78373,6.88363 2.42604,7.49505 2.1951,7.95693 L2.17372,8 L2.1951,8.04307 C2.42604,8.50495 2.78373,9.11637 3.28644,9.71963 C4.27954,10.9113 5.76219,12 8,12 C10.2378,12 11.7205,10.9113 12.7136,9.71963 C13.2163,9.11637 13.574,8.50495 13.8049,8.04307 L13.8263,8 L13.8049,7.95693 C13.574,7.49505 13.2163,6.88363 12.7136,6.28037 C11.7205,5.08865 10.2378,4 8,4 Z M8,5 C8.30747,5 8.60413,5.04625 8.88341,5.13218 C8.36251,5.36736 8,5.89135 8,6.5 C8,7.32843 8.67157,8 9.5,8 C10.1087,8 10.6326,7.63749 10.8678,7.11659 C10.9537,7.39587 11,7.69253 11,8 C11,9.65685 9.65685,11 8,11 C6.34315,11 5,9.65685 5,8 C5,6.34315 6.34315,5 8,5 Z"/>
                            </svg>
                            <a href="/sms/public/supervisor/deletefault/<?= $vipham['MaVP'] ?>" title="Xóa vi phạm"  onclick="return confirm('Bạn có chắc chắn muốn xóa vi phạm này?')">
                                <?= view('components/delete_button'); ?>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div id="pagination-container"></div>
</div>
<?php else: ?>
    <p>Không có dữ liệu vi phạm.</p>
<?php endif; ?>


<style>

    #table-container {
        width: 100%;
        max-width: 100%;
        overflow: auto;
        margin: 0 auto;
    }

    #supervisorFault {
        width: 100%;
        font-family: "Inter";
        border-collapse: collapse;
        color: black;
    }

    #supervisorFault th {
        padding: 10px;
        text-align: left;
        background-color: rgba(185, 185, 185, 0.50);
        color: black;
    }

    #supervisorFault td {
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
</style>

<script>
    document.addEventListener('DOMContentLoaded', () => {
    const tableElement = document.getElementById('supervisorFault');
    const paginationContainer = document.getElementById('pagination-container');

    initializeTablePagination({
        tableElement,
        paginationContainer,
        rowsPerPage: 10, 
    });
});

</script>