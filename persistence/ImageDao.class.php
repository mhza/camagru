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

  public function getList($page)
  {
    $gallery = [];
    $page = ($page - 1) * 5;
    $q = 'SELECT * FROM Images ORDER BY id desc limit :page, 5';
    $pstatement = $this->_db->prepare($q);
    $pstatement->bindValue(':page', $page, PDO::PARAM_INT);
    $pstatement->execute();
    // echo $pstatement->queryString;
    while ($datas = $pstatement->fetch(PDO::FETCH_ASSOC))
    {
      $img = new Image();
      $img->hydrate((array)$datas);
      $gallery[] = $img;
    }
    return $gallery;
  }
  public function getImg($id)
  {
    $q = 'SELECT * FROM Images WHERE id = '.$id;
    $pstatement = $this->_db->prepare($q);
    $pstatement->execute();
    $datas = $pstatement->fetch(PDO::FETCH_ASSOC);
    $img = new Image();
    $img->hydrate($datas);
    return $img;
  }

  public function getImgCount()
  {
    $q = 'SELECT COUNT(*) FROM Images';
    if (($pstatement = $this->_db->prepare($q)) && $pstatement->execute())
      return $pstatement->fetchColumn();
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
  function new_comment_mail($label_img, $mail, $com) {
        $message = "
        You have a new comment about $label_img :\n
        \"$com\"\r\n";
        $message = wordwrap($message, 70, "\r\n");
        mail($mail, 'Camagru - new comment on your pic', $message);
  }
}


 ?>
