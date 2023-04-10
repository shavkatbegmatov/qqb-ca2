<?php

session_start();

require 'connect/db.php';

if (!isset($_SESSION['user'])) {
	header('Location: ' . ROOT . 'auth.php');
}

$credits = R::findAll('credit', 'client_id = ?', [$_SESSION['user']['id']]);

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>Zayavka</title>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/fomantic-ui/2.9.2/semantic.min.js" integrity="sha512-5cguXwRllb+6bcc2pogwIeQmQPXEzn2ddsqAexIBhh7FO1z5Hkek1J9mrK2+rmZCTU6b6pERxI7acnp1MpAg4Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fomantic-ui/2.9.2/semantic.min.css" integrity="sha512-n//BDM4vMPvyca4bJjZPDh7hlqsQ7hqbP9RH18GF2hTXBY5amBwM2501M0GPiwCU/v9Tor2m13GOTFjk00tkQA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
	<div class="ui container">
		<div class="ui divider"></div>
		<a href="index.php" class="ui button">Главная</a>
		<div class="ui divider"></div>
				<table class="ui celled table">
			<thead>
				<tr>
					<th>ID</th>
					<th>Фирма</th>
					<th>Кредит тури</th>
					<th>Кредит максади</th>
					<th>Кредит суммаси</th>
					<th>Кредит муддати (ой)</th>
					<th>Статус</th>
					<th>Статус сабаби</th>
					<th>Текширган одам</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($credits as $credit) : ?>
					<?php if ($credit['status'] != 'ochirilgan') : ?>
						<tr>
							<td><?php echo $credit['id']; ?></td>
							<td><?php echo R::findOne('user', 'id = ?', [$credit['client_id']])['name']; ?></td>
							<td><?php echo R::findOne('ctypes', 'id = ?', [$credit['credit_type']])['name']; ?></td>
							<td><?php echo $credit['credit_purpose']; ?></td>
							<td><?php echo number_format($credit['credit_sum']); ?></td>
							<td><?php echo $credit['credit_period']; ?></td>
							<td><?php echo $credit['status']; ?></td>
							<td><?php echo $credit['status_text']; ?></td>
							<td><?php echo $credit['checked_id']; ?></td>
						</tr>
					<?php endif; ?>
				<?php endforeach; ?>
			</tbody>
		</table>
</body>

</html>