<?php
include_once "../includes/preload.php";
//Check which page need to be shown

require_once (s('admin') ? "user_page.php" : "admin_page.php");