<?php

// this will avoid mysql_connect() deprecation error.
error_reporting( ~E_DEPRECATED & ~E_NOTICE );
// but I strongly suggest you to use PDO or MySQLi.

define('DBHOST', '127.0.0.1');
define('DBUSER', 'root');
define('DBPASS', '');
define('DBNAME', 'db_1');

$conn = mysqli_connect(DBHOST,DBUSER,DBPASS);
$dbcon = mysqli_select_db($conn, DBNAME);

if ( !$conn ) {
    die("Connection failed : " . mysqli_error());
}
echo "Host Connected";

if ( !$dbcon ) {
    die("Database Connection failed : " . mysqli_error());
}

echo "DB Connected";