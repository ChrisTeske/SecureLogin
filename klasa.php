<?php

class Person
{
	public $name;
	public $surname;
	public $email;
	public $telefon;

	 public function setFullName($name, $surname, $email, $telefon)
	 {
	$this->name = $name;
	$this->surname = $surname;
	$this->email = $email;
	$this->telefon = $telefon;
	 } // end setFullName();

	 public function getFullName()
	 {
			return 'imię: ' . $this->name.' '.$this->surname . ' mój telefon to: ' . $this->telefon . ' mój mail to: ' . $this->email;
	 } // end getFullName();

}

		$janusz = new Person;
		$janusz->setFullName('Janusz', 'Kowalski', 'm@o2.pl', '997');

$adam = new Person;
$adam->setFullName('Adam', 'Nowak', 'a.nowak@tpl.com', '999 999 999');

echo 'Witaj, jestem '.$janusz->getFullName().'<br/>';
echo 'A ja jestem '.$adam->getFullName().'<br/>';
?>
