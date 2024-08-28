<style>
    .content_block{
        display: flex;
        justify-content: space-between;
        border-bottom: 1px solid #cdcdcd;
        margin-top: 15px;
    }
    .content_block img{
        width: 100px;
        height: 100px;
    }
    .content_block a{
        text-decoration: none;
        color: black;
    }
</style>
<?php
/**@var \App\modules\Good [] $goods */
foreach ($goods as $good) : ?>
    <div class="content_block">
        <div>
            <a href="?c=good&a=one&id=<?= $good->id ?>"><h1><?= $good->name ?></h1></a>
            <p><?= $good->price ?></p>
        </div>
        <a href="?c=good&a=one&id=<?= $good->id ?>"><img src="<?= $good->img ?>"></a>
    </div>
<?php endforeach; ?>
