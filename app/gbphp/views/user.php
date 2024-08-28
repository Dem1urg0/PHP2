<style>
    .orders-container {
        background-color: white;
        border-radius: 5px;
        padding: 20px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        margin-top: 20px;
    }

    .orders {
        display: flex;
        flex-direction: column;
    }

    .order {
        border-bottom: 1px solid #ddd;
        padding: 10px 0;
    }

    .order:not(:last-child) {
        border-bottom: 2px solid #4CAF50;
    }

    .product-list {
        display: flex;
        flex-direction: column;
        margin-top: 10px;
        margin-bottom: 10px;
    }

    .product {
        display: flex;
        justify-content: space-between;
        padding: 5px 0;
    }

    .product p {
        margin: 0;
    }
    .sad a {
        text-decoration: none;
        color: white;
        background-color: #df1d4a;
        padding: 10px 20px;
        border-radius: 5px;
        transition: background-color 0.3s ease;
    }
</style>
<div class="sad">
        <h1><?= $user->login ?></h1>
        <h2><?= $user->name ?></h2>
        <a href="?c=user&a=all">Назад</a>
</div>
<script>
    var a = '<?= $title?>';
</script>
