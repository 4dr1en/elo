<?php
class CatsManager{
    private $_db;

    const STATUS_HIDE= 2;
    const STATUS_ACCEPT= 1;

    public function __construct(){
        try{
            $this->_db= new PDO('mysql:host=localhost;dbname=elocats;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        }
        catch (Exception $e){
            die('Erreur : ' . $e->getMessage());
        }
    }

    public function add(Cat $Cat){
        $q= $this->_db->prepare("INSERT INTO cats(name, ip, img_hash, age, elo, sex, date_post) VALUES(:name, :ip, :img_hash, :age, :elo, :sex, CURDATE())");
        $q->bindValue(':name', $Cat->name());
        $q->bindValue(':ip', $_SERVER['REMOTE_ADDR']);
        $q->bindValue(':img_hash', $Cat->imgHash());
        $q->bindValue(':age', $Cat->age(), PDO::PARAM_INT);
        $q->bindValue(':elo', 1000, PDO::PARAM_INT);
        $q->bindValue(':sex', $Cat->sex(), PDO::PARAM_BOOL);
        $q->execute();
        return $this->_db->lastInsertId();
    }

    public function get(int $id){
        $q= $this->_db->prepare("SELECT * FROM cats WHERE id = ?");
        $q->execute(array($id));
        return $q->fetch();
    }

    public function getAllHashs(){
        $r= $this->_db->query('SELECT id, img_hash FROM cats');
        return $r;
    }

    public function exist($id){
        $q= $this->_db->prepare('SELECT COUNT(*) FROM cats WHERE id = ?');
        $q->execute(array($id));
        return $q->fetchColumn();
    }

    public function count(){
        $q= $this->_db->prepare('SELECT COUNT(*) FROM cats WHERE status != :status');
        $q->bindValue(':status', self::STATUS_HIDE, PDO::PARAM_INT);
        $q->execute();
        return $q->fetchColumn();
    }

    public function gets(int $start, int $nb){
        $q= $this->_db->prepare("SELECT * FROM cats WHERE status != :status ORDER BY elo DESC LIMIT :nb OFFSET :start");
        $q->bindValue(':status', self::STATUS_HIDE, PDO::PARAM_INT);
        $q->bindValue(':nb', $nb, PDO::PARAM_INT);
        $q->bindValue(':start', $start, PDO::PARAM_INT);
        $q->execute();
        return $q;
    }

    public function updateImage(int $id, string $image){
        $q= $this->_db->prepare("UPDATE cats SET image = :image WHERE id = :id");
        return $q->execute(array(':image'=> $image, ':id'=> $id));
    }

    public function updateElo(int $id, int $nElo){
        $q= $this->_db->prepare("
            UPDATE cats AS a
            INNER JOIN cats AS b
            SET a.elo = :elo, 
            a.evaluations= b.evaluations+1 
            WHERE a.id = :id"
        );
        $q->bindValue(':elo', $nElo, PDO::PARAM_INT);
        $q->bindValue(':id', $id, PDO::PARAM_INT);
        return $q->execute();
    }

    /*return randomly two lines whose id is not contained in $ids*/
    public function get2rand(array $ids= null){
        $i= 0;
        $query= "SELECT * FROM cats WHERE status != :status";
        if(!empty($ids)){
            $query.= " AND id NOT IN (";
            foreach ($ids as $id) {
                $i++;
                if($i != 1){
                    $query.= ", ";
                }
                $query.= ":id".$i;
            }
            $query.= ")";
        }
        $query.= " ORDER BY RAND() LIMIT 2";

        $q= $this->_db->prepare($query);

        for ($i; $i > 0 ; $i--) { 
            $q->bindValue(':id'.$i, $ids[$i-1], PDO::PARAM_INT);
        }        
        $q->bindValue(':status', self::STATUS_HIDE, PDO::PARAM_INT);
        $q->execute();
        return $q;
    }

    public function nbOfSendByIp(string $dateStart= '2000-01-01', string $ip){
        $q= $this->_db->prepare('SELECT COUNT(*) FROM cats WHERE date_post >= :datePost AND ip= :ip');
        $q->execute(array(':datePost'=> $dateStart, ':ip'=> $ip));
        return $q->fetchColumn();
    }

    public function updateStatut(int $id, string $status){
        if($status == 'hide'){
            $q= $this->_db->prepare('UPDATE cats SET status = ? WHERE id = ?');
            $q->execute(array(self::STATUS_HIDE, $id));
        }
        elseif($status == 'accept'){
            $q= $this->_db->prepare('UPDATE cats SET status = ? WHERE id = ?');
            $q->execute(array(self::STATUS_ACCEPT, $id));
        }
    }
}

