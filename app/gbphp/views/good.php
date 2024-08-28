<style>
    .content_block img {
        width: 150px;
        height: 150px;
    }

    .content_block_params a {
        text-decoration: none;
        color: black;
    }
    .content_block_params{
        display: flex;
        justify-content: space-between;
    }
    .content_block_info a{
        text-decoration: none;
        color: white;
        background-color: #df1d4a;
        padding: 10px 20px;
        border-radius: 5px;
        transition: background-color 0.3s ease;
    }

</style>
<div class="content_block">
    <div class="content_block_params">
        <div>
            <h1><?= $good->name ?></h1>
            <p><?= $good->price ?></p>
            <p><?= $good->type ?></p>
        </div>
        <img src="<?= $good->img ?>">
    </div>
    <div class="content_block_info">
    <p><?= $good->info ?></p>
    <a href="?c=good&a=all">Назад</a>
    </div>
</div>