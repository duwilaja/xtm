<?php
   session_start();
   session_unset();
   session_destroy();
   $m="Logged Out.";
   header("Location: index.php?m=$m");
?>