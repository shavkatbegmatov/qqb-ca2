<?php

require '../connect/db.php';

session_start();

if (!isset($_SESSION['user'])) {
	header('Location: ' . ROOT . 'auth.php');
} else {
	if ($_SESSION['user']['role'] != 'admin') {
		header('Location: ' . ROOT . 'auth.php');
	}
}

$credits = R::findAll('credit');

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>Админ Панель</title>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/fomantic-ui/2.9.2/semantic.min.js" integrity="sha512-5cguXwRllb+6bcc2pogwIeQmQPXEzn2ddsqAexIBhh7FO1z5Hkek1J9mrK2+rmZCTU6b6pERxI7acnp1MpAg4Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fomantic-ui/2.9.2/semantic.min.css" integrity="sha512-n//BDM4vMPvyca4bJjZPDh7hlqsQ7hqbP9RH18GF2hTXBY5amBwM2501M0GPiwCU/v9Tor2m13GOTFjk00tkQA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
	<div class="ui container">
		<a class="ui tiny right floated red button" href="/">
			Выйти
		</a>
		<div class="ui text menu">
			<div class="item" style="width:72px;height:72px;margin-right:48px;">
				<img style="width:72px;height:72px;" src="https://manage.qishloqqurilishbank.uz/storage/logo-1620275124bYllR.jpg">
			</div>
			<div class="ui item">
				<div style="text-align:left;">
					<div style="display:block;">
						<p>Банк: <a href="#"><b>ТОШКЕНТ Ш., АТБ "КИШЛОК КУРИЛИШ БАНК" БОШ АМАЛИЁТЛАР</b></a></p>
					</div>
					<br>
					<div style="display:block;">
						<p>Клиент: <a href="#"><b><?php echo $_SESSION['user']['username']; ?> <?php echo $_SESSION['user']['name']; ?></a></b></p>
					</div>
				</div>
			</div>
			<div class="ui item">
				<div style="text-align:left;">
					<div style="display:block;">
						<p>Операционный день: <b>31.03.2023</b> <span class="ui black horizontal label">Открыт</span></p>
					</div>
					<br>
					<div style="display:block;">
						<p>Дата последнего входа: <span class="ui black horizontal label">31.03.2023 16:46:53</span></p>
					</div>
				</div>
			</div>
		</div>

		<div class="ui divider"></div>
		<table class="ui celled table">
			<thead>
				<tr>
					<th>ID</th>
					<th>Компания</th>
					<th>Тип кредита</th>
					<th>Причина кредита</th>
					<th>Сумма кредита</th>
					<th>Период кредита</th>
					<th>Статус</th>
					<th>Причина (отказа/согласия)</th>
					<th>Сотрудник</th>
					<th></th>
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
							<td>
								<button class="ui button" onclick="docs(<?php echo $credit['id']; ?>)">Документы</button>
								<?php if ($credit['status'] == 'yuborilgan') : ?>
									<br>
									<br>
									<div class="ui vertical buttons">
										<a class="ui green button" href="<?php echo ROOT ?>admin/confirm.php?id=<?php echo $credit['id']; ?>">Одобрить</a>
										<a class="ui red button" href="<?php echo ROOT ?>/admin/cancel.php?id=<?php echo $credit['id']; ?>">Отказать</a>
									</div>
								<?php endif; ?>
							</td>
						</tr>
					<?php endif; ?>
				<?php endforeach; ?>
			</tbody>
		</table>

		<div class="ui modal">
			<i class="close icon"></i>
			<div class="header">Документы</div>
			<div class="content">
				<div class="ui form files">
					<div class="ui inline field">
						<label>Сотиб олиш буйича шартнома</label>
						<a href="" id="file1" download></a>
					</div>
					<div class="ui inline field">
						<label>Молиявий хисоботлар</label>
						<a href="" id="file2" download></a>
					</div>
					<div class="ui inline field">
						<label>Кредит таъминотига такдим этиладиган мулклар</label>
						<a href="" id="file3" download></a>
					</div>
					<div class="ui inline field">
						<label>Лойиха буйича ишлаб чикилган ТИА (бизнес режа)</label>
						<a href="" id="file4" download></a>
					</div>
					<div class="ui inline field">
						<label>Таъсис хужжатлари</label>
						<a href="" id="file5" download></a>
					</div>
					<div class="ui inline field">
						<label>Шартнорма, кадастр ва эксперт хужжатлари</label>
						<a href="" id="file6" download></a>
					</div>
				</div>
			</div>
		</div>
	</div>

	<script>
		function docs(id) {
			$.ajax({
				url: 'file_name.php?id=' + id,
				dataType: 'text',
				type: 'get',
				success: function(result) {
					let filenames = result.split(',');


					$('#file1').attr('href', '/uploads/' + filenames[0]);
					$('#file1').html('<i class="fa fa-download"></i> ' + filenames[0]);

					$('#file2').attr('href', '/uploads/' + filenames[1]);
					$('#file2').html('<i class="fa fa-download"></i> ' + filenames[1]);

					$('#file3').attr('href', '/uploads/' + filenames[2]);
					$('#file3').html('<i class="fa fa-download"></i> ' + filenames[2]);

					$('#file4').attr('href', '/uploads/' + filenames[3]);
					$('#file4').html('<i class="fa fa-download"></i> ' + filenames[3]);

					$('#file5').attr('href', '/uploads/' + filenames[4]);
					$('#file5').html('<i class="fa fa-download"></i> ' + filenames[4]);

					$('#file6').attr('href', '/uploads/' + filenames[5]);
					$('#file6').html('<i class="fa fa-download"></i> ' + filenames[5]);

					$('.ui.modal').modal('show');
				}
			});
		}
	</script>
</body>

</html>