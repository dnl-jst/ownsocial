<?php

if (is_file('../../config.php')) {
	die('application already installed');
}

if (@$_SERVER['REQUEST_METHOD'] === 'POST') {

	$dbHost = $_POST['db_host'];
	$dbName = $_POST['db_name'];
	$dbUser = $_POST['db_user'];
	$dbPass = $_POST['db_pass'];

	$firstName = trim($_POST['first_name']);
	$lastName = trim($_POST['last_name']);
	$email = trim($_POST['email']);
	$password = trim($_POST['password']);
	$password2 = trim($_POST['password2']);
	$siteTitle = trim($_POST['site_title']);

	if ($password !== $password2) {
		die('passwords are not equal');
	}

	try {
		$db = new PDO('mysql:host=' . $dbHost . ';charset=utf8mb4', $dbUser, $dbPass);
		$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
	} catch (PDOException $e) {
		die('database connect failed: ' . $e->getMessage());
	}

	if (!$firstName || !$lastName || !$email || !$password) {
		die('you have to enter all fields');
	}

	$stmt = $db->query('SHOW DATABASES LIKE ' . $db->quote($dbName));

	if ($stmt->fetch() !== false) {
		die('error: database already exists');
	}

	$db->query('CREATE DATABASE `' . $dbName . '` /*!40100 DEFAULT CHARACTER SET utf8mb4 */');
	$db->query('USE ' . $dbName);

	$db->exec('set foreign_key_checks=0');

	$sql = file_get_contents('install.sql');
	$db->query($sql);

	$stmt = $db->prepare('
		INSERT INTO
			users
			(
				email,
				password,
				first_name,
				last_name,
				created
			)
			VALUES
			(
				:email,
				:password,
				:first_name,
				:last_name,
				NOW()
			)'
	);

	$stmt->execute(array(
		':email' => $email,
		':password' => password_hash($password, PASSWORD_DEFAULT),
		':first_name' => $firstName,
		':last_name' => $lastName
	));

	$stmt = $db->prepare('INSERT INTO configs (`key`, `value`) VALUES (\'site_title\', :site_title)');
	$stmt->execute(array(
		':site_title' => $siteTitle
	));

	$db->exec('set foreign_key_checks=1');

	$config = array(
		'db_host' => $dbHost,
		'db_name' => $dbName,
		'db_user' => $dbUser,
		'db_pass' => $dbPass
	);

	$configFile = '<?php

return ' . var_export($config, true) . ';';

	if (!file_put_contents('../../config.php', $configFile)) {
		echo 'please create config.php in ownsocial root folder with the following contents:';
		echo '<pre>' . htmlspecialchars($configFile) . '</pre>';
	}


	die('finished. you can now login with your credentials.');

} else {
	?>

	<html>
	<head>
		<meta http-equiv="Content-Type" content="charset=utf-8" />
		<title>OwnSocial Installation</title>
	</head>
	<body>
		<form method="post" action="">

			<div class="text required">
				<input type="text" name="site_title" placeholder="Title of the network" />
			</div>

			<div class="text required">
				<input type="text" name="db_host" placeholder="Database host" />
			</div>

			<div class="text required">
				<input type="text" name="db_name" placeholder="Database name" />
			</div>

			<div class="text required">
				<input type="text" name="db_user" placeholder="Database user" />
			</div>

			<div class="text required">
				<input type="password" name="db_pass" placeholder="Database password" />
			</div>

			<div class="text required">
				<input type="text" name="first_name" placeholder="First name" />
			</div>

			<div class="text required">
				<input type="text" name="last_name" placeholder="Last name" />
			</div>

			<div class="text required">
				<input type="text" name="email" placeholder="Your e-mail-address" />
			</div>

			<div class="text required">
				<input type="password" name="password" placeholder="Your new password" />
			</div>

			<div class="text required">
				<input type="password" name="password2" placeholder="Confirm your new password" />
			</div>

			<div class="submit">
				<input type="submit" value="Install..." />
			</div>

		</form>
	</body>
	</html>

	<?php
}
