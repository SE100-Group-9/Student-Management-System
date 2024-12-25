<link rel="stylesheet" href="<?= base_url(relativePath: 'assets/css/style.css') ?>">

<div class="statics-conduct">
    <div class="conduct-heading">
        <?= view('components/heading') ?>
    </div>
    <div class="body">
        <div class="body-left">
            <?= view('components/sidebar_director') ?>
        </div>
        <div class="body-right">
            Trung tâm / Thống kê / Hạnh kiểm
            <div class="dropdown-edit">
                <?= view('components/dropdown', ['options' => ['2024-2025', '2023-2024']]) ?>
            </div>
            <div class="conduct-btns">
                <button class="conduct-btn" onclick="loadChartData('grade-10')">Khối 10</button>
                <button class="conduct-btn" onclick="loadChartData('grade-11')">Khối 11</button>
                <button class="conduct-btn" onclick="loadChartData('grade-12')">Khối 12</button>
            </div>
            <div class="body-below">
                <div id="excellent">
                    <div class="conduct-chart">
                        <?= view('components/column_chart') ?>
                    </div>
                </div>
                <div class="conduct-table">
                    Danh sách các học sinh vi phạm nhiều nhất
                    <?= view('components/tables/directorStaticsConduct') ?>
                </div>
            </div>
            <div class="body-below">
                <div id="good" style="display:none">
                    <div class="conduct-chart">
                        <?= view('components/column_chart') ?>
                    </div>
                </div>
            </div>

            <div class="body-below">
                <div id="bad" style="display:none">
                    <div class="conduct-chart">
                        <?= view('components/column_chart') ?>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>


<style>
    *,
    *::before,
    *::after {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    .statics-conduct {
        display: flex;
        width: 100%;
        height: 100%;
        flex-direction: column;
        align-items: flex-start;
        background: var(--White, #FFF);
    }

    .conduct-heading {
        width: 100%;
        height: 60px;
        position: fixed;
    }

    .body {
        display: flex;
        align-items: flex-start;
        flex: 1 0 0;
        margin-top: 60px;
        align-self: stretch;
        background: var(--light-grey, #F9FAFB);
        overflow: hidden;
    }

    .body-left {
        height: 100%;
        overflow-y: auto;
    }

    .body-right {
        display: flex;
        padding: 20px;
        flex-direction: column;
        align-items: flex-start;
        gap: 20px;
        flex: 1 0 0;
        align-self: stretch;
        color: #000;
        font-family: Inter;
        font-size: 16px;
        font-style: normal;
        font-weight: 400;
        line-height: normal;
        height: auto;
    }

    .conduct-chart {
        display: flex;
        width: 500px;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        gap: 10px;
        background: var(--White, #FFF);
        z-index: 0;
    }

    .conduct-btns {
        display: inline-flex;
        padding: 4px 5px;
        align-items: flex-start;
        border-radius: 6px;
        border: 1px solid var(--slate-300, #CBD5E1);
        background: var(--White, #FFF);
    }

    .conduct-btn {
        display: flex;
        padding: 6px 12px;
        align-items: flex-start;
        background: var(--White, #FFF);
        border: none;
        font-family: "Inter";
        cursor: pointer;
    }

    .conduct-btn:hover {
        background: var(--slate-100, #F1F5F9);
    }

    .conduct-btn:focus {
        background: var(--slate-100, #F1F5F9);
    }

    .conduct-btn.active {
        background: var(--slate-100, #F1F5F9);
    }

    .body-below {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        align-self: stretch;
        width: 100%;
        background-color: white;
    }

    #excellent {
        width: 50%;
    }

    #good {
        width: 50%;
    }

    #bad {
        width: 50%;
    }

    .conduct-table {
        display: flex;
        padding: 10px;
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
        flex: 1; 
        align-self: stretch;
        background: #FFF;
        overflow: auto; 
        max-height: 500px; 
    }

    .dropdown-edit {
        width: 180px;
    }
</style>

<script>
    function openConduct(ConductName) {
        var x = document.getElementsByClassName("Conduct");
        for (var i = 0; i < x.length; i++) {
            x[i].style.display = "none";
        }
        document.getElementById(ConductName).style.display = "block";

        loadChartData(ConductName); // Gọi hàm vẽ chart khi chuyển tab
    }
</script>