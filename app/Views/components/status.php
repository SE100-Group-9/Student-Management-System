<button class="primary">Đã thu</button>
<button class="primary">Giáo viên</button>
<button class="primary">Đang bảo lưu</button>

<button class="secondary">Trả một phần</button>
<button class="secondary">Tổ phó</button>
<button class="secondary">Thu ngân</button>

<button class="third">Đang học</button>
<button class="third">Đang làm</button>
<button class="third">Tổ trưởng</button>
<button class="third">Chưa thu</button> 

<button class="fourth">Giám thị</button>
<button class="fourth">Hết hạn bảo lưu</button>

<style>
    button {
        color: var(--label-color);
        background-color: var(--background-color);
        border: none;
        padding: 10px 17px;
        border-radius: 40px;
        font-size: 16px;
        width: 160px;
    }

    button.primary {
        --label-color: var(--White, #FFF);
        --background-color: var(--Cerulean, #01B3EF);
    }

    button.secondary {
        --label-color: var(--White, #FFF);
        --background-color: var(--Regal-Blue, #01427A);
    }

    button.third {
        --label-color: var(--White, #FFF);
        --background-color: var(--Cerise-Red, #E14177);
    }

    button.fourth {
        --label-color: var(--White, #FFF);
        --background-color: var(--Dark-Grey, #6C6C6C);
    }

    button:not(:last-of-type) {
        margin-right: 16px;
    }

    html {
        height: 100%;
    }
    
    body {
        display: flex;
        justify-content: center;
        align-items: center;  
        height: 100%;
    }
</style>