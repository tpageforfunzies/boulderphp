<?php

error_reporting( ~E_DEPRECATED & ~E_NOTICE );

define('DBHOST', 'localhost');
define('DBUSER', 'root');
define('DBPASS', '');
define('DBNAME', 'boulder');

global $link;
$link = mysqli_connect(DBHOST,DBUSER,DBPASS,DBNAME);


if ( !$link ) {
    die("Connection failed : " . mysqli_error($link));
}
else{
    echo "Connection Successful";
}

