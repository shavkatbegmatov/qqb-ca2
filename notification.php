<?php

session_start();

require 'connect/db.php';

if (!isset($_SESSION['user'])) {
	header('Location: http://project.loc/auth.php');
}

$notifications = R::findAll('notification', 'user_id = ?', [$_SESSION['user']['id']]);

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>Уведомления</title>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/fomantic-ui/2.9.2/semantic.min.js" integrity="sha512-5cguXwRllb+6bcc2pogwIeQmQPXEzn2ddsqAexIBhh7FO1z5Hkek1J9mrK2+rmZCTU6b6pERxI7acnp1MpAg4Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fomantic-ui/2.9.2/semantic.min.css" integrity="sha512-n//BDM4vMPvyca4bJjZPDh7hlqsQ7hqbP9RH18GF2hTXBY5amBwM2501M0GPiwCU/v9Tor2m13GOTFjk00tkQA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
	<div class="ui container">
		<div class="ui divider"></div>
		<?php foreach ($notifications as $notification) : ?>
			<div class="ui message">
				<div class="header">
					Система
				</div>
				<p><?php echo $notification['text']; ?></p>
			</div>
		<?php endforeach; ?>
	</div>
</body>

</html>