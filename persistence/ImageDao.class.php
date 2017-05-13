<?php
class ImageDao
{
  private $_db;
  public function __construct($db){$this->setDb($db);}
  public function setDb(PDO $db){$this->_db = $db;}

  public function getMaxId()
  {
    $q = 'SELECT MAX(id) FROM images';
    if (($pstatement = $this->_db->prepare($q)) && $pstatement->execute())
      return $pstatement->fetchColumn();
    return (-1);
  }
  public function getMaxIdComments()
  {
    $q = 'SELECT MAX(id) FROM comments';
    if (($pstatement = $this->_db->prepare($q)) && $pstatement->execute())
      return $pstatement->fetchColumn();
    return (-1);
  }
  public function create($mail, $name)
  {
    $q = 'INSERT INTO `images`(`id`, `likes`, `mail`, `date`, `name`) VALUES (:id,  :likes, :mail, :dateofday, :name)';
    $id = $this->getMaxId() + 1;
    if ($id > 0 && ($pstatement = $this->_db->prepare($q)) &&
    $pstatement->execute(array (':id' => $id, ':mail' => $mail, ':dateofday' => date(Ymd), ':likes' => 0, 'name'=>$name)))
            return $id;
  }

  public function delete($idImg)
  {
    $this->_db->exec('DELETE FROM images WHERE id = '.$idImg);
    $this->_db->exec('DELETE FROM likes WHERE id = '.$idImg);
    $this->_db->exec('DELETE FROM comments WHERE idImg = '.$idImg);
  }

  public function getList()
  {
    $gallery = [];
    $q = $this->_db->query('SELECT * FROM Images ORDER BY id desc limit 5');
    while ($datas = $q->fetch(PDO::FETCH_ASSOC))
    {
      $img = new Image();
      $img->hydrate($datas);
      $gallery[] = $img;
    }
    return $gallery;
  }

  public function updateLike($id, $likes)
  {
    $q = 'UPDATE Images SET likes = :likes WHERE id = :id';
    $pstatement = $this->_db->prepare($q);
    $pstatement->bindValue(':id', $id);
    $pstatement->bindValue(':likes', $likes);
    $pstatement->execute();
    $datas = $pstatement->fetch(PDO::FETCH_ASSOC);
    print_r($datas);
  }

  public function createLike($id, $idUser)
  {
    $q = 'INSERT INTO Likes(id, idUser) VALUES (:id, :idUser)';
    $pstatement = $this->_db->prepare($q);
    $pstatement->bindValue(':id', $id);
    $pstatement->bindValue(':idUser', $idUser);
    $pstatement->execute();
  }

  public function getLike($id, $idUser)
  {
    $q = 'SELECT COUNT(*) from Likes WHERE id = :id AND idUser = :idUser';
    $pstatement = $this->_db->prepare($q);
    $pstatement->bindValue(':id', $id);
    $pstatement->bindValue(':idUser', $idUser);
    $pstatement->execute();
    return ($pstatement->fetchColumn());
  }
  public function deleteLike($id, $idUser)
  {
    // echo "delete ".$id.$idUser;
    $this->_db->exec('DELETE FROM likes WHERE id = '.$id . ' AND idUser = '.$idUser);
  }

  public function getComments($idImg)
  {
    $allComments = [];
    $q = 'SELECT * from Comments WHERE idImg = :idImg ORDER BY id desc limit 5';
    $pstatement = $this->_db->prepare($q);
    $pstatement->bindValue(':idImg', $idImg);
    $pstatement->execute();
    while ($datas = $pstatement->fetch(PDO::FETCH_ASSOC))
      $allComments[] = $datas;
    return ($allComments);
  }
  public function addComments($idImg, $idUser, $comment)
  {
    $q = 'INSERT INTO `Comments`(`id`, `idImg`, `idUser`, `msg`) VALUES (:id, :idImg, :idUser, :msg)';
    $pstatement = $this->_db->prepare($q);
    $pstatement->bindValue(':id', $this->getMaxIdComments() + 1);
    $pstatement->bindValue(':idImg', $idImg);
    $pstatement->bindValue(':idUser', $idUser);
    $pstatement->bindValue(':msg', $comment);
    $pstatement->execute();
  }
}

 ?>
