<?php
session_start();
session_unset();
session_destroy();

// Redirect to login page with a flag
header("Location: login.php?logout=success");
exit;
