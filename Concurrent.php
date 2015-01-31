<?php
//concurrent login disabled
$concurrent = new ConcurrentClass("acecookie", 'acefile='.md5($_SESSION['createdSessionID']), 0);
$concurrent->createcookie();

?>