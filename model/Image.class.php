<?php
Class Image {
  private $_id;
  private $_name;
  private $_mail;
  private $_date;
  // private $_comments;
  private $_likes;

  public function  getId(){return $this->_id;}
  public function  getName(){return $this->_name;}
  public function  getMail(){return $this->_mail;}
  public function  getDate(){return $this->_date;}
  // public function  getComments(){return $this->_comments;}
  public function  getLikes(){return $this->_likes;}
  public function setId($id){$this->_id = $id;return;}
  public function setName($name){$this->_name = $name;return;}
  public function setMail($mail){$this->_mail = $mail;return;}
  public function setDate($date){$this->_date = $date;return;}
  // public function setComments($comments){$this->_comments = $_comments;return;}
  public function setLikes($likes){$this->_likes = $likes;return;}

  public function hydrate(array $datas) {
    foreach ($datas as $key => $value)
    {
      $method = 'set'.ucfirst($key);
      if (method_exists($this, $method)){$this->$method($value);}
    }
  }


}
 ?>
