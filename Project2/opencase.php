<?php

include 'functions.php';
if(isset($_POST["caseNum"])) {
	$briefcases = $_SESSION['briefcases'];
	$caseNum = $_POST["caseNum"];
	$briefcases[$caseNum]->setRevealed();

}
header('Location: deal.php');







?>