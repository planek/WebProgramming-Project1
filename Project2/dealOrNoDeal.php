<?php
session_start();

class Briefcase {
	public $number;
	public $value;
	public $isRevealed = false;
	public $userChosen = false;

	public function __construct($number, $value) { 
		$this->number = $number;
		$this->value = $value;
	}
	
	public function setRevealed() {
		$this->isRevealed = true;
	}
	
	public function setChosen() {
		$this->userChosen = true;
	}
	
	public function getNumber() {
		return $this->number;
	}
	
	public function getValue() {
		return $this->value;
	}
	
	public function isRevealed() {
		return $this->isRevealed;
	}
	
	public function isChosen() {
		return $this->userChosen;
	}
	
	public function showAll() {
		$caseNum = $this->number;
		echo "Number: " . $this->number . "<br>";
		echo "Value: " . $this->value . "<br>";
		echo "Revealed? " . $this->isRevealed . "<br>";
		
		if($this->isRevealed) {
			echo '<img src="openbag.jpg">';
		}
		else if(!$this->isRevealed) {
			echo 
			"<form action='opencase.php' method='POST'>
				<input type='hidden' value=$caseNum name='caseNum' />
				<input type='submit' value='Open Bag'>
			</form>";
			echo '<img src="closedbag.jpg"><br>';
			
			
		}
		echo "User Chosen? " . $this->userChosen . "<br><br>";
	}
}

function generateBriefcases() {
	$valueArray = array(100, 500, 1000, 5000, 10000, 50000, 100000, 500000, 1000000);
	shuffle($valueArray);
	$_SESSION['briefcasesCreated'] = true;
	$briefcaseArray = array();
	for($i = 0 ; $i<9 ; $i++) {
		array_push($briefcaseArray, new Briefcase($i, $valueArray[$i]));	
	}
	$_SESSION['briefcases'] = $briefcaseArray;
}

function generateOffer() {
	$sumOfValues = 0;
	$casesRemaining = 0;
	$briefcaseArray = $_SESSION['briefcases'];
	for($i = 0 ; $i<9 ; $i++) {
		if(!$briefcaseArray[$i]->isRevealed()) {
			$sumOfValues = $sumOfValues + $briefcaseArray[$i]->getValue();
			$casesRemaining++;
		}
	}
	$offer = $sumOfValues/$casesRemaining;
	
	return $offer;
}

function showCases() {
	$briefcaseArray = $_SESSION['briefcases'];
	for($i = 0 ; $i<9 ; $i++) {
		$briefcaseArray[$i]->showAll();	
	}
}

if(!isset($_SESSION['briefcases'])) {
	generateBriefcases();
}
?>


<form action="sessionrestart.php">
	<input type='submit' value="New Game">
</form>
<br>
<?php
echo "Current Offer: $" . generateOffer() . "<br><br>";
showCases();
?>
