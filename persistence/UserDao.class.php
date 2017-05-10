<?php
class UserDao
{
  private $_db;

  public function __construct($db){$this->setDb($db);}
  public function setDb(PDO $db){$this->_db = $db;}

  public function getMaxId()
  {
    $q = 'SELECT MAX(id) FROM users';
    if (($pstatement = $this->_db->prepare($q)) && $pstatement->execute())
      return $pstatement->fetchColumn();
    return (-1);
  }

  public function getIdByMail($mail)
  {
    $nb = 0;
    $q = 'SELECT id FROM users WHERE mail = :mail';
    if (($pstatement = $this->_db->prepare($q)) && $pstatement->execute(array (':mail' => $mail)))
      $nb = $pstatement->fetchColumn();
    return ($nb);
  }

  function confirmation_mail($user) {
        $login =$user->getLogin();
        $mail = $user->getMail();
        $key = $login . $mail . date('mY');
        $key = md5($key);
        $message = "
        Dear " . $login . "
        Confirm your e-mail address, clic here ;)\r\n
        http://localhost:8080/camagru/view/header_ctrl.php?mail=$mail&key=$key";
        $message = wordwrap($message, 70, "\r\n");
        mail($mail, 'Camagru confirmation mail', $message);
  }

  public function add(User $user)
  {
    if ($this->getIdByMail($user->getMail()))
  		  return ;
    $login = $user->getLogin();
    $key = $login . $user->getMail() . date('mY');
    $key = md5($key);
    $q = 'INSERT INTO users(id, mail, login, pwd, confKey) VALUES(:id, :mail, :login, :pwd, :confKey)';
    echo $user->getMail()."  ". $user->getPwd()." ". $user->getLogin();
    $id = $this->getMaxId() + 1;
    $user->__toString();
    if ($id > 0 && ($pstatement = $this->_db->prepare($q))
    && $pstatement->execute(array (':id' => $id, ':mail' => $user->getMail(), ':pwd' => $user->getPwd(), ':login' => $login, ':confKey' => $key)))
            return $user;
    return ;
  }

  public function delete(User $user)
  {
    $this->_db->exec('DELETE FROM users WHERE id = '.$user->getId());
  }

  public function get($id)
  {
    $id = (int) $id;
    $q = 'SELECT `id`, `login`, `mail`, `pwd`, `confKey` FROM `Users` WHERE id = '.$id;
    $pstatement = $this->_db->prepare($q);
    $pstatement->execute();
    $datas = $pstatement->fetch(PDO::FETCH_ASSOC);
    // print_r($datas);
    $user = new User();
    $user->hydrate($datas);
    return $user;
  }

  public function getByLogin($login)
  {
    $q = $this->_db->query('SELECT id, mail, login, pwd, confKey FROM users WHERE login = '.$login);
    $datas = $q->fetch(PDO::FETCH_ASSOC);

    return new User($datas);
  }

  public function getByMailPwd($mail, $pwd)
  {
    $q = 'SELECT * FROM users WHERE mail = :mail AND pwd = :pwd AND confKey = :active';
    if (($pstatement = $this->_db->prepare($q)) && $pstatement->execute(array (':mail' => $mail, ':pwd' => $pwd, ':active' => 2)))
    {
      if ($datas = $pstatement->fetch(PDO::FETCH_ASSOC))
      {
            $user = new User();
            $user->hydrate($datas);
            // echo $user->__toString();
            // print_r($datas);
            return $user;
      }
    }
    return;
  }

  public function getByMailKey($mail, $key)
  {
    echo $mail;
    echo $key;
    $q = 'SELECT * FROM users WHERE mail = :mail AND confKey = :key';
    if (($pstatement = $this->_db->prepare($q)) && $pstatement->execute(array (':mail' => $mail, ':key' => $key)))
    {
      if ($datas = $pstatement->fetch(PDO::FETCH_ASSOC))
      {
            $user = new User();
            $user->hydrate($datas);
            $user->setConfKey(2);
            $this->update($user);
            // echo $user->__toString();
            // print_r($datas);
            return $user;
      }
    }
    return;
  }

  public function update(User $user)
  {
    $q = 'UPDATE users SET mail = :mail, login = :login, pwd = :pwd, confKey = :confKey WHERE id = :id';
    $pstatement = $this->_db->prepare($q);
    $pstatement->bindValue(':id', $user->getId());
    $pstatement->bindValue(':mail', $user->getMail());
    $pstatement->bindValue(':login', $user->getLogin());
    $pstatement->bindValue(':pwd', $user->getPwd());
    $pstatement->bindValue(':confKey', $user->getConfKey());
    $pstatement->execute();
    $datas = $pstatement->fetch(PDO::FETCH_ASSOC);
    print_r($datas);

  }
}

// public function getList()
// {
//   $users = [];
//
//   $q = $this->_db->query('SELECT id, mail, login, pwd, confKe FROM users ORDER BY login');
//
//   while ($datas = $q->fetch(PDO::FETCH_ASSOC))
//   {
//     $users[] = new User($datas);
//   }
//
//   return $users;
// }
?>
