<?php
Class User {
  private $_id;
  private $_mail;
  private $_login;
  private $_pwd;
  private $_confKey;

  public function getId(){return $this->_id;}
  public function getMail(){return $this->_mail;}
  public function getLogin(){return $this->_login;}
  public function getPwd(){return $this->_pwd;}
  public function getConfKey(){return $this->_confKey;}
  public function setId($id){$this->_id = $id;return;}
  public function setMail($mail){$this->_mail = $mail;return;}
  public function setLogin($login){$this->_login = $login;return;}
  public function setPwd($pwd){$this->_pwd = $pwd;return;}
  public function setConfKey($confKey){$this->_confKey = $confKey;return;}

  public function hydrate(array $datas) {
    foreach ($datas as $key => $value)
    {
      $method = 'set'.ucfirst($key);
      if (method_exists($this, $method)){$this->$method($value);}
    }
  }
  public function __toString()
   {
     return "mail : ".$this->_mail."<br>pwd : ".$this->_pwd."<br>login : ".$this->_login."<br>";
    //  $ret = $this->$_id.PHP_EOL.$this->$_mail.PHP_EOL.$this->$_login.PHP_EOL.$this->$_pwd.PHP_EOL.$this->$_confKeys;
    //  if ($this->$_pwd)
    //    $ret .= $this->$_pwd.PHP_EOL;
    //    if ($this->$_confKeys)
    //      $ret .= $this->$_confKeys;
      //  return $ret;
   }
}
?>
