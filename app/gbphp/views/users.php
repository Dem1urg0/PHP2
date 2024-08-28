<style>

    .sad h1 {
        font-size: 24px;
        margin-bottom: 10px;
        padding: 10px 0;
        border-bottom: 2px solid #4CAF50;
    }
    .sad a {
        text-decoration: none;
        color: #000;
    }
</style>
<div class="sad">
    <?php
    /**@var \App\modules\User [] $users */
    foreach ($users as $user) : ?>
        <h1><a href="?c=user&a=one&id=<?=$user->id?>"><?= $user->login ?></a></h1>
    <?php endforeach;?>
</div>
<script>
    var a = {};
</script>
