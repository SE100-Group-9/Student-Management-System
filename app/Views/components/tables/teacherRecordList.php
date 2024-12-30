<div id="table-container">
    <table id="teacherRecordList">
        <thead>
            <tr>
                <th>MSLH</th>
                <th>Tên lớp</th>
                <th>Giỏi</th>
                <th>Khá</th>
                <th>Trung bình</th>
                <th>Yếu</th>
                <th>Điểm trung bình</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>LP01</td>
                <td>11A1</td>
                <td>50%</td>
                <td>20%</td>
                <td>20%</td>
                <td>10%</td>
                <td>8.5</td>
                <td>
                    <a style="text-decoration: none; background: none; color: inherit;" title="Xem chi tiết" href="/sms/public/teacher/class/record/detail">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="16" viewBox="0 0 25 16" fill="none">
                            <path d="M15.3333 8C15.3333 9.654 13.9873 11 12.3333 11C10.6793 11 9.33334 9.654 9.33334 8C9.33334 6.346 10.6793 5 12.3333 5C13.9873 5 15.3333 6.346 15.3333 8ZM24.3333 7.551C24.3333 7.551 20.0813 16 12.3483 16C5.16834 16 0.333344 7.551 0.333344 7.551C0.333344 7.551 4.77934 0 12.3483 0C20.0423 0 24.3333 7.551 24.3333 7.551ZM17.3333 8C17.3333 5.243 15.0903 3 12.3333 3C9.57634 3 7.33334 5.243 7.33334 8C7.33334 10.757 9.57634 13 12.3333 13C15.0903 13 17.3333 10.757 17.3333 8Z" fill="#E14177" />
                        </svg>
                    </a>
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

    #teacherRecordList {
        width: 100%;
        font-family: "Inter";
        border-collapse: collapse;
        color: black;
    }

    #teacherRecordList th {
        padding: 10px;
        text-align: left;
        background-color: rgba(185, 185, 185, 0.50);
        color: black;
    }

    #teacherRecordList td {
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
        const tableElement = document.getElementById('teacherRecordList');
        const paginationContainer = document.getElementById('pagination-container');

        initializeTablePagination({
            tableElement,
            paginationContainer,
            rowsPerPage: 10,
        });
    });
</script>