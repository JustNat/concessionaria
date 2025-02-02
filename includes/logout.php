<?php
session_start();
session_unset();
session_destroy();
$_SESSION['message'] = 'Você saiu com sucesso!';
header('Location: ../index.php');
exit();
?>
