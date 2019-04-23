<?php

class Mapper {

    private $server ="xxxx";
    private $username ="xxxx";
    private $password ="xxxx";
    private $dbname = "xxxx";
    private $pdo = 0;


    public function __construct(){

        $dsn = "mysql:host=". $this->server . ";dbname=". $this->dbname;
        $this->pdo = new PDO($dsn, $this->username, $this->password);
    }

    public function insertNameAddressEmailIntoDatabase(User $user) {

        $name = $user->getName();
        $email = $user->getEmail();
        $address = $user->getAddress();

        $Into = $this->pdo->query("INSERT INTO User (Name, Address, Email) VALUES ('$name' , '$address' , '$email')");

        $lastInsertId = $this->pdo->lastInsertId();
        $user->setUserId($lastInsertId);
    }

    public function insertUserIdFormIdIntoDatabase(User $user, Form $form) {

        $userId = $user->getuserId();

        $In = $this->pdo->query("INSERT INTO Form (userId) VALUES ('$userId')");

        $lastInsertId = $this->pdo->lastInsertId();
        $form->setFormId($lastInsertId);

    }

    public function getNameAddressEmailFromDatabase(){
        $array = [];

        $sql = $this->pdo->query('SELECT * FROM User JOIN Form on User.id=Form.userId');

        while($row = $sql->fetch(PDO::FETCH_ASSOC)){

            $user = new User();
            $form = new Form();

            $user->setName($row['Name'])
                ->setAddress($row['Address'])
                ->setEmail($row['Email'])
                ->setUserId($row['userId']);
            $users[] = $user;

            $form->setFormId($row['id']);
            $forms[] = $form;

            $array = [$users, $forms];

        }

        return $array;
    }



    public function validateNameAddressEmailToInsert($name, $address, $email) {

        if(empty($name) || is_numeric($name)) {
            die("Du har inte angivit ditt namn korrekt. ");

        }

        if( empty($address) || is_numeric($address)){
            die("Du har inte angivit din adress korrekt. ");
        }

        if(empty($email)|| is_numeric($email)){
            die("Du har inte angivit din email korrekt. ");
        }

    }


}

