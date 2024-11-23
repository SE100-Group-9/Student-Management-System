<link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">

<div class="input">
    <input
        type="text"
        id="<?= isset($id) ? $id : '' ?>"
        placeholder="<?= isset($placeholder) ? $placeholder : 'Nhập nội dung...' ?>"
        value="<?= isset($value) ? $value : '' ?>"
        <?= isset($readonly) && $readonly ? 'readonly="readonly"' : '' ?> />
</div>

<style>
    .input {
        display: flex;
        width: 100%;
        height: 40px;
        padding: 0 10px;
        align-items: center;
        border-radius: 10px;
        border: 1px solid rgba(0, 60, 60, 0.20);
        background: var(--light-color, #FFF);
        transition: border-color 0.3s ease;
        color: #CCC;
        font-family: var(--font-family, 'Inter');
        font-size: var(--font-size-base, 16px);
    }

    .input:focus-within {
        border-color: var(--info-color, #6DCFFB);
    }

    .input input {
        flex: 1;
        border: none;
        outline: none;
        background: transparent;
        color: var(--dark-color, #000);
        font-family: var(--font-family, 'Inter');
        font-size: var(--font-size-base, 16px);
        line-height: normal;
    }
</style>