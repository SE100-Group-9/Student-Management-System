<div class="search-bar">
    <input type="text" placeholder="Tìm kiếm" />
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
        <path d="M15.7071 14.2929C15.3166 13.9024 14.6834 13.9024 14.2929 14.2929C13.9024 14.6834 13.9024 15.3166 14.2929 15.7071L15.7071 14.2929ZM20.2929 21.7071C20.6834 22.0976 21.3166 22.0976 21.7071 21.7071C22.0976 21.3166 22.0976 20.6834 21.7071 20.2929L20.2929 21.7071ZM10 16C6.68629 16 4 13.3137 4 10H2C2 14.4183 5.58172 18 10 18V16ZM4 10C4 6.68629 6.68629 4 10 4V2C5.58172 2 2 5.58172 2 10H4ZM10 4C13.3137 4 16 6.68629 16 10H18C18 5.58172 14.4183 2 10 2V4ZM16 10C16 13.3137 13.3137 16 10 16V18C14.4183 18 18 14.4183 18 10H16ZM14.2929 15.7071L20.2929 21.7071L21.7071 20.2929L15.7071 14.2929L14.2929 15.7071Z" fill="black"/>
    </svg>
</div>

<style>
    .search-bar {
        display: flex;
        width: 250px;
        height: 40px;
        padding: 10px;
        justify-content: space-between;
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

    .search-bar:focus-within {
        border-color: #6DCFFB;
    }

    .search-bar input {
        border: none;
        outline: none;
        flex: 1;
        background: transparent;
    }
</style>