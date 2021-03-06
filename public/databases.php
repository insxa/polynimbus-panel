<?php

require "include/config.php";
$file = "$_data_path/inventory/databases.list";
$date = date("Y-m-d H:i:s", filemtime($file));

require "include/page.php";
require "include/acl.php";
require "include/account.php";
page_header("Polynimbus - cloud databases inventory");
echo "<strong>List of all cloud databases as of $date</strong><br />\n";
table_start("databases", array(
	"vendor",
	"account",
	"dbhost",
	"dbname",
	"dbuser",
	"state",
	"engine",
	"version",
	"storage",
	"size",
	"location",
	"instance-type",
	"instance-id",
	"created",
	"acl",
));


$data = file_get_contents($file);
$lines = explode("\n", $data);

foreach ($lines as $line) {
	$line = trim($line);
	if (empty($line))
		continue;

	$tmp = explode(" ", $line, 17);
	$vendor = $tmp[0];
	$account = $tmp[1];
	$state = $tmp[6];
	$style = ($state != "available" ? "background-color: #f4cccc;" : false);
	$engine = $tmp[7];
	$dbport = $tmp[3];

	if ($dbport == "-")
		$dbhost = $tmp[2];
	else if ($engine == "postgres" && $dbport == 5432)
		$dbhost = $tmp[2];
	else if (($engine == "mysql" || $engine == "aurora-mysql") && $dbport == 3306)
		$dbhost = $tmp[2];
	else
		$dbhost = $tmp[2].":$dbport";

	table_row(array(
		$vendor,
		get_account_link($vendor, $account),
		$dbhost,
		$tmp[4],  // db
		$tmp[5],  // user
		$state,
		$engine,
		str_replace("mysql_aurora", "ma", $tmp[8]),  // version
		$tmp[9],  // storage
		$tmp[10], // size
		get_region_link($vendor, $tmp[1], $tmp[11]),
		$tmp[12], // type
		$tmp[13], // id
		$tmp[14], // created
		map_acl_to_ranges($vendor, $account, $tmp[11], $dbport, $tmp[16]),
	), $style);
}

table_end("databases");
page_end();
