<?php
session_start();
class userpdo
{
    private $id;
    public $login;
    public $email;
    public $firstname;
    public $lastname;
    public $bdd;

    public function all()
    {
        $this->bdd = new PDO('mysql:localhost;dbname=classes;charset=utf8', 'root', '', );
    }

    public function register($login, $password, $email, $firstname, $lastname)
    {
        $request =$this->bdd->query("INSERT INTO utilisateurs ( `id`,`login`, `password`, `email`, `firstname`, `lastname`) VALUES (null,'$login', '$password', '$email', '$firstname',
        '$lastname')");
        
        $tab = array($login, $password, $email, $firstname, $lastname);

        foreach ($tab as $t) {
            echo $t . "<br>";
        }
    }
    public function connect($login, $password)
    {

        $request =$this->bdd->query ('SELECT * FROM utilisateurs WHERE login ="' . $login . '" && password="' . $password . '"');
        $res = $request->PDO::fetchall();
        $this->id = $res[0][0];
        $this->login = $res[0][1];
        $this->password = $res[0][2];
        $this->email = $res[0][3];
        $this->firstname = $res[0][4];
        $this->lastname = $res[0][5];

        $_SESSION['login'] = $res[0][1];
        $_SESSION['id'] = $res[0][0];
        // echo $this->login . "</br>", $this->password . "</br>", $this->email . "</br>", $this->firstname . "</br>", $this->lastname . "</br>";



        return $res;
    }
    public function disconnect()
    {
        unset($_SESSION);
        session_destroy($_SESSION);
        
    }
    public function delete()
    {
        $id = $_SESSION['id'];
        $bd = $this->bdd->query ("DELETE FROM `utilisateurs` WHERE id=$id");
        unset($_SESSION);
        session_destroy($_SESSION);
    }
    public function update($login, $password, $email, $firstname, $lastname)
    {
        $id = $_SESSION['id'];
        $bd2 = $this->bdd->query ("UPDATE `utilisateurs` SET `login`=$login,`password`=$password,`email`=$email,`firstname`=$firstname,`lastname`=$lastname WHERE id=$id");
        
    }
    public function isConnected()
    {
        $log = $_SESSION['login'];
        if (isset($_SESSION['login'])) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    public function getAllInfos()
    {
        $table = array($this->login, $this->password, $this->email, $this->firstname, $this->lastname);
         return  $table;
    }
    public function getLogin()
    {
        return $this->login;
    }
    public function getEmail()
    {
        return $this->email;
    }
    public function getFirstname()
    {
        return $this->firstname;
    }
    public function getLastname()
    {
        return $this->lastname;
    }
    public function refresh()
    {
        
        $requete = $this->bdd->query('SELECT * FROM utilisateurs WHERE id=$this->id');
        $res = $requete->PDO::fetchassoc();

        $this->id = $res['id'];
        $this->login = $res['login'];
        $this->password = $res['password'];
        $this->email = $res['email'];
        $this->firstname = $res['firstname'];
        $this->lastname = $res['lastname'];



    }
}



$user = new userpdo;
$user->all();
// $user->register("mika", "motdepasse", "mika@mail.fr", "michael", "bod");
// $user->connect("mika", "motdepasse");
// echo "bonjour ".$user->login;
// $user->disconnect();
// $user->delete();
// $user->update("Mike", "motdepasse", "mike@mail.fr", "michael", "bod");
// $user->isConnected();
// $user->getAllInfos();
// $user->getlogin();
// $user->getEmail();
// $user->getFirstname();
// $user->getLastname();
//    $user->refresh();
   ?>