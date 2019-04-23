<?php

include "mapper.php";
include "form.php";
include "user.php";

$Form = new Form();
$Mapper = new Mapper();
$User = new User();

$name = $_POST["name"];
$address = $_POST["address"];
$email = $_POST["email"];

$Mapper->validateNameAddressEmailToInsert($name, $address, $email);

$User->setName($name)
    ->setEmail($email)
    ->setAddress($address);

$Mapper->insertNameAddressEmailIntoDatabase($User);
$Mapper->insertUserIdFormIdIntoDatabase($User, $Form);

$result = $Mapper->getNameAddressEmailFromDatabase();

$users = $result[0];
$forms = $result[1];

for( $i =0; $i< count($users); $i++) {

    $a = $users[$i];
    $b = $forms[$i];

    echo "My name is " .$a->getName(). "<br>";
    echo "My address is " .$a->getAddress(). "<br>";
    echo "My email is " .$a->getEmail(). "<br>";
    echo "My user id is " .$a->getUserId(). "<br>";
    echo "My form id is " .$b->getFormId(). "<br><br>";


}

