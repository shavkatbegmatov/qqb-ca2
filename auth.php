<?php

require 'connect/db.php';

session_start();

if (!empty($_POST)) {
    if ($user = R::findOne('user', 'username = ? AND password = ?', [$_POST['username'], $_POST['password']])) {
        $_SESSION['user']['username'] = $user['username'];
        $_SESSION['user']['name'] = $user['name'];
        $_SESSION['user']['id'] = $user['id'];
        $_SESSION['user']['role'] = $user['role'];

        header('Location: http://project.loc/');
    } else {
        echo 'Неправильная!';
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Авторизация</title>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fomantic-ui/2.9.2/semantic.min.js" integrity="sha512-5cguXwRllb+6bcc2pogwIeQmQPXEzn2ddsqAexIBhh7FO1z5Hkek1J9mrK2+rmZCTU6b6pERxI7acnp1MpAg4Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fomantic-ui/2.9.2/semantic.min.css" integrity="sha512-n//BDM4vMPvyca4bJjZPDh7hlqsQ7hqbP9RH18GF2hTXBY5amBwM2501M0GPiwCU/v9Tor2m13GOTFjk00tkQA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <div class="ui container">
        <div class="ui divider"></div>
        <form class="ui form" action="auth.php" method="post">
            <div class="ui field">
                <label for="">Имя пользователя</label>
                <input name="username" type="text">
            </div>
            <div class="ui field">
                <label for="">Пароль</label>
                <input name="password" type="password">
            </div>
    
            <button class="ui button" type="submit">Отправить</button>
        </form>
    </div>
</body>
</html>