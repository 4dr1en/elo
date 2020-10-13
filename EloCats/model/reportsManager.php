<?php

class ReportsManager{
    private $_db;

    public function __construct(){
        try{
            $this->_db= new PDO('mysql:host=localhost;dbname=elocats;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        }
        catch (Exception $e){
            die('Erreur : ' . $e->getMessage());
        }
    }

    public function newReport($idCat, $reason){
        $q= $this->_db->prepare("INSERT INTO reports(id_cat, reason, ip_reporter) VALUES(:idCat, :reason, :ipReporter)");
        $q->bindValue(':idCat', $idCat, PDO::PARAM_INT);
        $q->bindValue(':reason', $reason);
        $q->bindValue(':ipReporter', $_SERVER['REMOTE_ADDR']);
        $q->execute();
        return $this->_db->lastInsertId();
    }

    public function getAllReports(bool $checked= false){
        if($checked){
            $r= $this->_db->query('SELECT * FROM reports ORDER BY date_report');
        }
        else{
            $r= $this->_db->query('SELECT * FROM reports WHERE treatment = false ORDER BY date_report');
        }
        return $r;
    }
    
    public function getCatReports(int $id){

        $q= $this->_db->prepare('SELECT * FROM reports WHERE id= ?');
        $q->execute(array($id));
        return $q;
    }

    public function itDouble(int $idCat){
        $q= $this->_db->prepare('SELECT COUNT(*) FROM reports WHERE id_cat = :idCat AND ip_reporter= :ipReporter');
        $q->bindValue(':idCat', $idCat, PDO::PARAM_INT);
        $q->bindValue(':ipReporter', $_SERVER['REMOTE_ADDR']);
        $q->execute();
        return $q->fetchColumn();
    }

    public function exist($idCat){
        $q= $this->_db->prepare('SELECT COUNT(*) FROM reports WHERE id_cat = ?');
        $q->execute(array($idCat));
        return $q->fetchColumn();
    }

    public function treated($id){
        $q= $this->_db->prepare('UPDATE reports SET treatment = 1 WHERE id = ?');
        $q->execute(array($id));
    }
}