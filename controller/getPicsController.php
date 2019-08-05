<?php
require '../services/connection.php';
require '../services/queriesMysql.php';

$rowsToShow = $_REQUEST['rowsToShow'];
$showMore = queriesMysql::getAll($link,$rowsToShow);
echo json_encode($showMore);

