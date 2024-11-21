<div id="table-container">
    <table id="supervisorCategory">
        <thead>
            <tr>
                <th>Mã vi phạm</th>
                <th>Tên vi phạm</th>
                <th>Điểm trừ</th>
                <th colspan="2"></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>Đi trễ</td>
                <td>3</td>
                <td colspan="2">
                    <div class="button-container">
                        <?= view('components/edit_button'); ?>
                        <?= view('components/delete_button'); ?>
                    </div>
                </td>
            </tr>
            <tr>
                <td>1</td>
                <td>Đi trễ</td>
                <td>3</td>
                <td colspan="2">
                    <div class="button-container">
                        <?= view('components/edit_button'); ?>
                        <?= view('components/delete_button'); ?>
                    </div>
                </td>
            </tr>
            <tr>
                <td>1</td>
                <td>Đi trễ</td>
                <td>3</td>
                <td colspan="2">
                    <div class="button-container">
                        <?= view('components/edit_button'); ?>
                        <?= view('components/delete_button'); ?>
                    </div>
                </td>
            </tr>
            <tr>
                <td>1</td>
                <td>Đi trễ</td>
                <td>3</td>
                <td colspan="2">
                    <div class="button-container">
                        <?= view('components/edit_button'); ?>
                        <?= view('components/delete_button'); ?>
                    </div>
                </td>
            </tr>
            <tr>
                <td>1</td>
                <td>Đi trễ</td>
                <td>3</td>
                <td colspan="2">
                    <div class="button-container">
                        <?= view('components/edit_button'); ?>
                        <?= view('components/delete_button'); ?>
                    </div>
                </td>
            </tr>
            <tr>
                <td>1</td>
                <td>Đi trễ</td>
                <td>3</td>
                <td colspan="2">
                    <div class="button-container">
                        <?= view('components/edit_button'); ?>
                        <?= view('components/delete_button'); ?>
                    </div>
                </td>
            </tr>
            <tr>
                <td>1</td>
                <td>Đi trễ</td>
                <td>3</td>
                <td colspan="2">
                    <div class="button-container">
                        <?= view('components/edit_button'); ?>
                        <?= view('components/delete_button'); ?>
                    </div>
                </td>
            </tr>
            <tr>
                <td>1</td>
                <td>Đi trễ</td>
                <td>3</td>
                <td colspan="2">
                    <div class="button-container">
                        <?= view('components/edit_button'); ?>
                        <?= view('components/delete_button'); ?>
                    </div>
                </td>
            </tr>
            <tr>
                <td>1</td>
                <td>Đi trễ</td>
                <td>3</td>
                <td colspan="2">
                    <div class="button-container">
                        <?= view('components/edit_button'); ?>
                        <?= view('components/delete_button'); ?>
                    </div>
                </td>
            </tr>
            <tr>
                <td>1</td>
                <td>Đi trễ</td>
                <td>3</td>
                <td colspan="2">
                    <div class="button-container">
                        <?= view('components/edit_button'); ?>
                        <?= view('components/delete_button'); ?>
                    </div>
                </td>
            </tr>
            <tr>
                <td>2</td>
                <td>Nghỉ học không phép</td>
                <td>3</td>
                <td colspan="2">
                    <div class="button-container">
                        <?= view('components/edit_button'); ?>
                        <?= view('components/delete_button'); ?>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
    <div id="pagination-container"></div>
</div>

<style>
    #table-container {
        width: 100%;
        max-width: 100%;
        overflow: auto;
        margin: 0 auto;
    }

    #supervisorCategory {
        width: 100%;
        font-family: "Inter";
        border-collapse: collapse;
        color: black;
    }

    #supervisorCategory th {
        padding: 10px;
        text-align: left;
        background-color: rgba(185, 185, 185, 0.50);
        color: black;
    }

    #supervisorCategory td {
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

    .button-container {
        display: flex; 
        gap: 5px; 
        justify-content: center; 
        align-items: center; 
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', () => {
    const tableElement = document.getElementById('supervisorCategory');
    const paginationContainer = document.getElementById('pagination-container');

    initializeTablePagination({
        tableElement,
        paginationContainer,
        rowsPerPage: 10,
    });
});
</script>