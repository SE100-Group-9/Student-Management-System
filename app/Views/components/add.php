<div class="add-container">
    <button class="button-text">
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
        <path d="M8 11C7.44772 11 7 11.4477 7 12C7 12.5523 7.44772 13 8 13V11ZM16 13C16.5523 13 17 12.5523 17 12C17 11.4477 16.5523 11 16 11V13ZM11 16C11 16.5523 11.4477 17 12 17C12.5523 17 13 16.5523 13 16H11ZM13 8C13 7.44772 12.5523 7 12 7C11.4477 7 11 7.44772 11 8H13ZM12 20C7.58172 20 4 16.4183 4 12H2C2 17.5228 6.47715 22 12 22V20ZM4 12C4 7.58172 7.58172 4 12 4V2C6.47715 2 2 6.47715 2 12H4ZM12 4C16.4183 4 20 7.58172 20 12H22C22 6.47715 17.5228 2 12 2V4ZM20 12C20 16.4183 16.4183 20 12 20V22C17.5228 22 22 17.5228 22 12H20ZM8 13H16V11H8V13ZM13 16V8H11V16H13Z" fill="white"/>
    </svg>
    </button>
</div>

<style>
    .add-container {
        position: relative;
        width: 300px;
        display: flex;
        align-items: center;
    }

    .button-text {
        display: inline-flex;
        align-items: center;
        height: 40px;
        padding: 10px;
        gap: 20px;
        border-radius: 10px;
        border: none;
        background-color: var(--Cerulean, #01B3EF);
        cursor: pointer;
    }

    .svg {
        position: absolute;
        top: 50%;
        left: 100px;
        transform: translateY(-50%);     
    }
</style>