<?php
session_start();
session_unset();
session_destroy();
header("Location: ../index.php");  // Redireciona de volta à página inicial
exit();
?>