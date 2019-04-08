<?php
$enlace = mysql_connect("localhost", "usrsga", "sgadb2015");
if (!$enlace) {
    die("No pudo conectarse: " . mysql_error());
}
printf("Versión del servidor MySQL: %s\n", mysql_get_server_info());

?>