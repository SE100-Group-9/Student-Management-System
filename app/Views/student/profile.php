<div class="student-profile">
    <?= view('components/heading'); ?>
    <div class="body">
        <?= view('components/sidebar_student'); ?>
        <div class="body-right">
            <div class="content">
                <p>Thông tin cá nhân</p>
                <div class="info-1">
                    <div class="id">
                        <h1>Mã học sinh</h1>
                        <?= view('components/input'); ?>
                    </div>
                    <div class="id">
                        <h1>Mã học sinh</h1>
                        <?= view('components/input'); ?>
                    </div>
                </div>
                <div class="info-2">
                    <div class="id">
                        <h1>Mã học sinh</h1>
                        <?= view('components/input'); ?>
                    </div>
                    <div class="id">
                        <h1>Mã học sinh</h1>
                        <?= view('components/input'); ?>
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

.student-profile {
    display: flex;
    flex-direction: column; 
    width: 100%;
    height: 100%;
    overflow: auto;
    align-items: flex-start;
    
}

.body {
    display: flex;
    align-items: flex-start;
    gap: 20px;
    flex: 1 0 0;
    align-self: stretch;
    background: var(--light-grey, #F9FAFB);
}

.body-right {
    display: flex;
    padding: 0px 20px;
    flex-direction: column;
    align-items: center;
    gap: 30px;
    flex: 1 0 0;
    align-self: stretch;
}

.content {
    display: flex;
    padding: 20px;
    flex-direction: column;
    align-items: flex-start;
    gap: 20px;
    border-radius: 10px;
    /* border: 1px solid var(--Silver, #AFAFAF); */
    background: var(--White, #FFF);
}


.content p {
    color: #000;
    font-family: Inter;
    font-size: 20px;
    font-style: normal;
    font-weight: 600;
    line-height: normal;
}

.info-1, .info-2 {
    display: flex;
    align-items: flex-start;
    gap: 20px;
}

.id {
    display: flex;
    width: 500px;
    max-width: 500px;
    flex-direction: column;
    align-items: flex-start;
    gap: 10px;
}

.id h1{
    color: #000;
    font-family: Inter;
    font-size: 16px;
    font-style: normal;
    font-weight: 500;
    line-height: normal;
}

</style>