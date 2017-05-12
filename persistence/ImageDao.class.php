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
  public function create($mail, $name)
  {
    $q = 'INSERT INTO `images`(`id`, `likes`, `mail`, `date`, `name`) VALUES (:id,  :likes, :mail, :dateofday, :name)';
    $id = $this->getMaxId() + 1;
    if ($id > 0 && ($pstatement = $this->_db->prepare($q)) &&
    $pstatement->execute(array (':id' => $id, ':mail' => $mail, ':dateofday' => date(ymd), ':likes' => 0, 'name'=>$name)))
            return $id;
  }

  public function delete(Image $img)
  {
    $this->_db->exec('DELETE FROM images WHERE id = '.$img->getId());
  }

  public function getList()
  {
    $gallery = [];
    $q = $this->_db->query('SELECT * FROM Images ORDER BY date');
    while ($datas = $q->fetch(PDO::FETCH_ASSOC))
    {
      $img = new Image();
      $img->hydrate($datas);
      $gallery[] = $img;
    }
    return $gallery;
  }
}

 ?>
