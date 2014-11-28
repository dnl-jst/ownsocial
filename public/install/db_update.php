<?php

# get installation config
$config = require('../../config.php');

# current release db layout version
$dbLayoutVersion = require('../../db_layout_version.php');

try {
	$db = new PDO('mysql:host=' . $config['db_host'] . ';dbname=' . $config['db_name'] . ';charset=utf8mb4', $config['db_user'], $config['db_pass']);
	$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
	die('database connect failed: ' . $e->getMessage());
}

$stmt = $db->query('SELECT `value` FROM configs WHERE `key` = \'db_layout_version\'');
$row = $stmt->fetch();

if ($row === false) {
	die('error: database layout version not found');
}

$installedLayoutVersion = (integer)$row['value'];

if (@$_SERVER['REQUEST_METHOD'] === 'POST') {

	$givenPassword = @$_POST['password'];

	if ($givenPassword === @$config['update_tool_password']) {

		if ($installedLayoutVersion < $dbLayoutVersion) {
			echo '<p>Pending db layout updates: ' . ($dbLayoutVersion - $installedLayoutVersion) . '</p>';
		} else {
			die('<p>Your db layout is up-to-date!</p>');
		}

		for ($i = ($installedLayoutVersion + 1); $i <= $dbLayoutVersion; $i++) {

			$sqlPath = sprintf('../../sql/%04u.sql', $i);

			if (is_file($sqlPath)) {

				$db->query(file_get_contents($sqlPath));

				echo '<p>Executed sql for db layout version: ' . $i . '</p>';
			} else {

				die ('<p>No sql script found for updating db layout to version: ' . $i . '</p>');

			}

		}

		$db->query('UPDATE configs SET `value` = ' . $db->quote($dbLayoutVersion) . ' WHERE `key` = \'db_layout_version\'');

		die('<p>Your database layout was successfully updated to version: ' . $dbLayoutVersion . '</p>');

	} else {

		die('<p>forbidden, wrong password</p>');

	}

} else {

?>

<html>
<head>
	<meta http-equiv="Content-Type" content="charset=utf-8" />
	<title>OwnSocial Update Procedure</title>

	<link href="/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<link href="/css/style.css" rel="stylesheet">

	<script src="/bower_components/jquery/dist/jquery.min.js"></script>
	<script src="/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container">

	<form method="post" action="" role="form">

		<div class="row">

			<div class="page-header">
				<h1>OwnSocial <small>System Update</small></h1>
			</div>

			<fieldset>
				<legend>Enter your update tool password.</legend>

				<div class="alert alert-info">
					There are <strong><?= ($dbLayoutVersion - $installedLayoutVersion); ?></strong> db layout updates pending...
				</div>

				<div class="alert alert-danger">
					You should upgrade your database before installing database upgrades...
				</div>

				<div>
					<div class="form-group">
						<input type="password" class="form-control" name="password" placeholder="Your update tool password" />
					</div>
				</div>

			</fieldset>

			<div>
				<input type="submit" class="btn btn-primary btn-lg" value="Update installation..." />
			</div>

		</div>
	</form>
</div>
</body>
</html>

<?php

}

