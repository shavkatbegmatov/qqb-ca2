<?php

require '../connect/db.php';

session_start();

if (!empty($_POST)) {
    $credit = R::load('credit', $_GET['id']);
    $credit['status'] = 'tastiqlangan';
    $credit['status_text'] = $_POST['input'];
    $credit['checked_id'] = $_SESSION['user']['id'];
    R::store($credit);
    
    $notification = R::dispense('notification');
    $notification['user_id'] = R::findOne('credit', 'id = ?', [$_GET['id']])['client_id'];
    $notification['text'] = 'Ваш ' . $_GET['id'] . '-ый кредит одобрен :)';
    R::store($notification);
    
    header('Location: ' . ROOT . 'index.php');
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Canceling</title>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/fomantic-ui/2.9.2/semantic.min.js" integrity="sha512-5cguXwRllb+6bcc2pogwIeQmQPXEzn2ddsqAexIBhh7FO1z5Hkek1J9mrK2+rmZCTU6b6pERxI7acnp1MpAg4Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fomantic-ui/2.9.2/semantic.min.css" integrity="sha512-n//BDM4vMPvyca4bJjZPDh7hlqsQ7hqbP9RH18GF2hTXBY5amBwM2501M0GPiwCU/v9Tor2m13GOTFjk00tkQA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <div class="ui container">
		<div class="ui divider"></div>
        <form action="confirm.php?id=<?php echo $_GET['id']; ?>" method="POST" class="ui form">
            <div class="field">
                <label>Причина одобрения</label>
                <input type="text" name="input">
            </div>
            <button class="ui button" type="submit">Отправить</button>
        </form>
    </div>
</body>
</html>