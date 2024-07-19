<?php
function indexAction()
{
    $html = file_get_contents(dirname(__DIR__) . '/tmpl/login.html');
    $errorMessage = '<div class="error-message" style = "display: block">Incorrect username or password</div>';

    if (isset($_GET['e']) && $_GET['e'] == 'true') {
        $html = str_replace('<div id="error"></div>', $errorMessage, $html);
    }

    return $html;
}

function autAction()
{
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        if ($_GET['login'] != NULL && preg_match("#^[aA-zZ0-9]+$#", $_GET['login'])) {
            $login = mysqli_real_escape_string(connect(), $_GET['login']);
            $sql = "SELECT login FROM users WHERE login = '$login'";
            if ($_GET['mth'] == 'login') {
                if (mysqli_fetch_assoc(mysqli_query(connect(), $sql)) != NULL) {
                    login();
                    exit;
                }
            } else if ($_GET['mth'] == 'reg') {
                if (mysqli_fetch_assoc(mysqli_query(connect(), $sql)) == NULL) {
                    reg();
                } else {
                    header('Location:/?p=reg&le=true');
                    exit;
                }
            }
        }
        header('Location:/?p=login&e=true');
    }
}

function login()
{
    if ($_GET['pass'] != NULL && preg_match("#^[aA-zZ0-9]+$#", $_GET['pass'])) {
        $pass = mysqli_real_escape_string(connect(), md5($_GET['pass']));
        $sql = "SELECT id, role FROM users WHERE password = '$pass'";
        $foundUser = (mysqli_fetch_assoc(mysqli_query(connect(), $sql)));
        if ($foundUser) {
            session_start();
            $_SESSION['user']['id'] = $foundUser['id'];
            $_SESSION['user']['admin'] = $foundUser['role'];
            header('Location: /?p=user&a=one');
            exit;
        }
    }
    header('Location:/?p=login&e=true');
}

function reg()
{
    if ($_GET['pass'] != NULL && preg_match("#^[aA-zZ0-9]+$#", $_GET['pass'])) {
        $pass = mysqli_real_escape_string(connect(), md5($_GET['pass']));
        $login = mysqli_real_escape_string(connect(), $_GET['login']);
        $sql = "INSERT INTO `users` (`id`, `role`, `password`, `login`, `name`) VALUES (NULL, '0', '$pass', '$login', 'NO')";
        mysqli_query(connect(), $sql);
        header('Location:/?p=login');
        exit;
    }
    header('Location:/?p=reg&pe=true');
    exit;
}