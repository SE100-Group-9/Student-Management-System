<div class="input">
    <input type="text" placeholder="Nhập nội dung..." />
</div>

<style>
    .input {
        display: flex;
        width: 500px;
        height: 40px;
        padding: 0px 10px;
        align-items: center;
        border-radius: 10px;
        border: 1px solid rgba(0, 60, 60, 0.20);
        background: var(--White, #FFF);
        transition: border-color 0.3s ease;
        color: #CCC;
        font-family: Inter;
        font-size: 16px;
        font-style: normal;
        font-weight: 400;
        line-height: normal;
    }

    .input:focus-within {
        border-color: #6DCFFB;
    }

    .input input {
        border: none;
        outline: none;
        flex: 1;
        background: transparent;
    }
</style>