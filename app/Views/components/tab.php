<div class="tabs">
    <a style="text-decoration: none; color: inherit;" href="/sms/public/director/class/arrange/student/<?= $MaLop ?>" 
       class="tab <?= $activeTab === 'student' ? 'active' : '' ?>">
        Học sinh
    </a>
    <a style="text-decoration: none; color: inherit;" href="/sms/public/director/class/arrange/teacher/<?= $MaLop ?>" 
       class="tab <?= $activeTab === 'teacher' ? 'active' : '' ?>">
        Giáo viên
    </a>
</div>


<style>
    .tabs {
        width: 235px;
        height: 40px;
        border-radius: 6px;
        border: 1px solid var(--slate-300, #CBD5E1);
        background: var(--White, #FFF);
        overflow: hidden;
        display: inline-flex;
        padding: 4px 5px;
        align-items: flex-start;
    }

    .tab {
        width: 75px;
        height: 32px;
        flex: 1;
        display: flex;
        padding: 6px 12px;
        align-items: flex-start;
        text-align: center;
        font-family: Inter;
        font-size: 14px;
        line-height: 20px;
        font-weight: 500;
        color: #000;
        background-color: #FFF;
        border: none;
        cursor: pointer;
        border-radius: 4px;
    }

    .tab.active {
        background-color: #F3F4F6;
        color: #111827;
        font-weight: bold;
    }

    .tab:not(.active):hover {
        background-color: #F9FAFB;
    }
</style>