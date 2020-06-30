<?php 
/**
 * author: Benjamin Kuermayr
 * version: 2020-03-04
 * subject: Umsetzung eines Webshops mit PHP
 */

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
ini_set('upload_max_filesize', 100);
ini_set('post_max_size',100);

error_reporting(E_ALL);
define('ROOT_PATH', dirname(__DIR__).'/minishop_dbms/');
define('UPLOAD_PATH','./uploads/');
define('DEFAULT_CURRENCY','€');

require_once(ROOT_PATH.'functions/minishop_dbms.php');
$db = new MinishopDBMS("localhost","onlineshop","bkuermayr_dbuser","testtest");

require_once(ROOT_PATH.'layout/header.php'); 
require_once(ROOT_PATH.'layout/page-content.php');
require_once(ROOT_PATH.'layout/footer.php');
$db->close();
?>
