<div id="confirm-dialog" class="dialog-overlay">
    <div class="dialog-box">
        <div class="content">
            <p>Xóa thanh toán</p>
            <div>
                <h1>Bạn có muốn xóa mã:</h1>
                <h2>HD001</h2>  
            </div>
        </div>
        <div class="button-section">
            <button class="cancel-btn">Không</button>
            <button class="confirm-btn">Có</button>
        </div>
    </div>
</div>

<style>
    .dialog-overlay {
        display: inline-flex; 
        position: fixed;
        flex-direction: column;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        backdrop-filter: blur(30px);
        background-color: rgba(0, 0, 0, 0.1);
        justify-content: center;
        align-items: center;
        z-index: 1000;
    }

    .dialog-box {
        display: flex;
        padding: 24px;
        flex-direction: column;
        align-items: flex-start;
        gap: 16px;
        border-radius: 10px;
        background: var(--White, #FFF);
        box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25);
        position: absolute;
    }

    .content {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        gap: 8px;
    }

    .content p {
        color: #000;
        font-family: Inter;
        font-size: 18px;
        font-style: normal;
        font-weight: 600;
        line-height: 28px;
    }   

    .content h1,
    .content h2 {
        display: inline; 
        margin: 0; 
    }


    .content h1 {
        color: #64748B;
        font-family: Inter;
        font-size: 14px;
        font-style: normal;
        font-weight: 400;
        line-height: 20px; 
    }

    .content h2 {
        color: #E14177;
        font-family: Inter;
        font-size: 14px;
        font-style: normal;
        font-weight: 700;
        line-height: 20px;
    }

    .button-section {
        display: flex;
        width: 464px;
        justify-content: flex-end;
        align-items: center;
        gap: 8px;
        align-self: stretch;
    }

    .cancel-btn {
        width: 100px;
        color: white;
        display: flex;
        height: 40px;
        padding: 0px 32px;
        justify-content: center;
        align-items: center;
        gap: 10px;
        border-radius: 5px;
        color: #000;
        font-family: Inter;
        font-size: 16px;
        font-style: normal;
        font-weight: 700;
        line-height: normal;
        letter-spacing: 0.48px;
        border: 1px solid #424242;
        cursor: pointer;
    }

    .confirm-btn {
        width: 100px;
        display: flex;
        height: 40px;
        padding: 0px 32px;
        justify-content: center;
        align-items: center;
        gap: 10px;
        border-radius: 5px;
        background: var(--Cerise-Red, #E14177);
        color: var(--White, #FFF);
        font-family: Inter;
        font-size: 16px;
        font-style: normal;
        font-weight: 700;
        line-height: normal;
        letter-spacing: 0.48px;
        border: none;
        cursor: pointer;
    }

</style>