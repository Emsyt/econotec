<?php
$usuario = trim(shell_exec('sh /var/www/html/projects-codeigniter/econotec-script/database.sh usuario'));
$pass = trim(shell_exec('sh /var/www/html/projects-codeigniter/econotec-script/database.sh contrasena'));
$servidor = trim(shell_exec('sh /var/www/html/projects-codeigniter/econotec-script/database.sh servidor'));
$puerto = trim(shell_exec('sh /var/www/html/projects-codeigniter/econotec-script/database.sh puerto'));
?>
