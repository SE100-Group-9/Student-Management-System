<div class="student-fee-payment">
    <?= view('components/heading'); ?>
    <div class="body">
        <?= view('components/sidebar_student'); ?>
        <div class="fee-payment-container">
            <h1>Học phí / Học phí / Thanh toán</h1>
            <div class="content">
                <div class="payment-info">
                    Thông tin thanh toán chuyển khoản
                    <div class="group">
                        <label for="name">Tên tài khoản:</label>
                        <input type="text" id="name" value="Nguyen Van A" readonly>
                    </div>
                    <div class="group">
                        <label for="account_number">Số tài khoản:</label>
                        <input type="text" id="account_number" value="123456789" readonly>
                    </div>
                    <div class="group">
                        <label for="amount">Số tiền phải đóng:</label>
                        <input type="text" id="amount" value="1,000,000" readonly>
                    </div>
                    <div class="group">
                        <label for="tranfer_content">Nội dung chuyển khoản:</label>
                        <input type="text" id="tranfer_content" value="Thanh toan hoc phi hoc ky x" readonly>
                    </div>
                </div>
                <div class="button_payment-container">
                    <button class="button-payment">
                        <p>Thanh toán</p>
                    </button>
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

.student-fee-payment {
    display: flex;
    flex-direction: column; 
    width: 100%;
    height: 100%;
    overflow: auto;
    
}

.body {
    display: flex; 
    flex-direction: row; 
    background: #F0F2F5;
    height: 100%;
}

.heading {
    padding: 20px;
    width: 100%;
    box-sizing: border-box;
}

.fee-payment-container {
    display: flex;
    padding: 20px;
    flex-direction: column;
    align-items: flex-start;
    gap: 20px;
    flex: 1 0 0;
    align-self: stretch;
}

.fee-payment-container h1 {
    color: #000;
    font-family: Inter;
    font-size: 16px;
    font-style: normal;
    font-weight: 400;
    line-height: normal;
}

.content {
    display: flex;
    padding: 20px;
    flex-direction: column;
    align-items: center;
    justify-content: space-between;
    align-self: stretch;
    gap: 20px;
    border-radius: 10px;
    background: var(--White, #FFF);
}

.payment-info {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    flex-direction: column;
    border-radius: 10px;
    border: 1px solid rgba(0, 60, 60, 0.30);
    padding: 30px;
    align-self: stretch;
    color: #000;
    font-family: Inter;
    font-size: 16px;
    font-style: normal;
    font-weight: 400;
    line-height: normal;
}

.group {
    display: flex;
    width: 500px;
    max-width: 500px;
    flex-direction: row;
    align-items: flex-start;
    gap: 10px;
}

.group label{
    color: #000;
    font-family: Inter;
    font-size: 14px;
    font-style: normal;
    font-weight: 700;
    line-height: normal;
} 

input[readonly] {
    border: none; 
    background-color: transparent; 
    color: #000; 
    font-size: 14px; 
    font-family: Inter;
    outline: none; 
}

.button-payment-container {
    display: flex;
    justify-content: center;
    align-items: center; 
    width: 100%; 
}

.button-payment {
    padding: 10px 20px;
    background: var(--Regal-Blue, #01427A);
    border-radius: 10px;
    color: #FFF;
    cursor: pointer;
    width: 500px;
    height: 40px;
}

.button-payment p {
    color: #FFF;
    font-family: Inter;
    font-size: 16px;
    font-style: normal;
    font-weight: 700;
    line-height: normal;
}

</style>