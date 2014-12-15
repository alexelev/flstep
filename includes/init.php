<?php
	include_once 'config.php';
	include ABSPATH . '\classes\Db.php';
	Db::connect(DB_HOST, DB_LOGIN, DB_PASSWORD, DB_NAME);