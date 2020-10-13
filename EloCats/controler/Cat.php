<?php
class Cat{
    private $_id;
    private $_image;
    private $_imgHash;
    private $_name;
    private $_age;
    private $_elo;
    private $_sex;
    private $_datePost;
    private $_evaluations;

    const DEFEAT= 0;
    const VICTORY= 1;


    public function __construct($tabVar= false)
    {
        if($tabVar){
            return $this->hydrate($tabVar);
        }
    }
    public function hydrate($tabVar){
        $success= true;
        foreach ($tabVar as $key => $value) {
            $method= 'set'.ucfirst($key);
            if(method_exists($this, $method)){
                $r= $this->$method($value);
                if(!$r){
                    $success= false;
                }
            }
        }
        return $success;
    }

    private function calcProba(int $elo2){
        $exp = ($elo2 - $this->_elo)/400;
        return 1/ (1+ 10**$exp);
    }
    public function newElo(int $elo2, $result){
        if(in_array($result, array(self::DEFEAT, self::VICTORY))){
            $nElo= $this->_elo + 20 *($result - $this->calcProba($elo2));
            $this->_elo= round($nElo);
            return  $this->_elo;
        }
        return false;
    }
    public function id(){
        return $this->_id;
    }
    public function image(){
        return $this->_image;
    }
    public function imgHash(){
        return $this->_imgHash;
    }
    public function name(){
        return $this->_name;
    }
    public function age(){
        return $this->_age;
    }
    public function fAge(){
        if($this->_age < 1){
            return ( $this->_age * 100) . " mois";
        }
        else return $this->_age . " ans";
    }
    public function elo(){
        return $this->_elo;
    }

    public function sex(){
        return $this->_sex;
    }

    public function fSex(){
        if($this->_sex) return "mâle";
        else return "femelle";
    }
    public function datePost(){
        return $this->_datePost;
    }
    public function evaluations(){
        return $this->_evaluations;
    }
    public function reliability(){
        if($this->_evaluations < 5){
            return 'très faible';
        }
        elseif($this->_evaluations < 10){
            return 'faible';
        }
        elseif($this->_evaluations < 20){
            return 'moyenne';
        }
        elseif($this->_evaluations < 30){
            return 'haute';
        }
        else{
            return 'très haute';
        }
    }


    public function setId(int $id){
        $id= (int) $id;
        if ($id > 0){
            $this->_id = $id;
            return true;
        }
        return false;
    }

    public function setImage(string $link){
        if( file_exists($link)){
            $this->_image = $link;
            return true;
        }
        return false;
    }

    public function setImg_hash(string $hash){
        if(mb_strlen($hash) >= 10 && strlen($hash) < 255){
            $this->_imgHash = $hash;
            return true;
        }
        return false;
    }

    public function setName(string $name){
        if(!empty($name) && mb_strlen($name) >= 2 && strlen($name) < 255){
            $this->_name = $name;
            return true;
        }
        return false;
    }

    public function setAge($age){
        $age= (float) $age;
        if ($age > 0 && $age < 40){
            $this->_age = $age;
            return true;
        }
        return false;
    }

    public function setElo(int $elo){
        $elo= (int) $elo;
        if ($elo > 0){
            $this->_elo = $elo;
            return true;
        }
        return false;
    }

    public function setSex(bool $sex){
        $this->_sex = $sex;
        return true;
    }

    public function setDate_post(string $datePost){
        $b= preg_match('/^([0-9]{4})-([0-9]{2})-([0-9]{2})$/', $datePost, $matches);
        if($b){
            if($matches['1'] <= date("Y") && $matches['2'] <= 12 && $matches['3'] <= 31){
                $this->_datePost = $datePost;
                return true;
            }
        }
        return false;
    }

    public function setEvaluations(int $evaluations){
        $this->_evaluations = $evaluations;
        return true;
    }
}