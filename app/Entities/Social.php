<?php

namespace App\Entities;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

/**
 * @ORM\Entity
 * @ORM\Table(name="social")
 */

class Social implements JsonSerializable{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=150)
     */
    private $id;
    /** @ORM\Column(type="text") */
    private $social_txt;
    /** @ORM\Column(type="string", length=150) */
    private $user_id;
    /** @ORM\Column(type="string", length=50) */
    private $user_screen_name;
    /** @ORM\Column(type="datetimetz") */
    private $created_at;

    public function __construct()
    {
        //
    }

    //getters
    public function getId(){
        return $this->id;
    }

    public function getSocialTXT(){
        return $this->social_txt;
    }

    public function getUserId(){
        return $this->user_id;
    }

    public function getUserScreenName(){
        return $this->user_screen_name;
    }

    public function getCreatedAt(){
        return $this->created_at;
    }

    //setters
    public function setId($id){
        $this->id = $id;
    }

    public function setSocialTXT($txt){
        $this->social_txt = $txt;
    }

    public function setUserId($user_id){
        $this->user_id = $user_id;
    }

    public function setUserScreenName($screen_name){
        $this->user_screen_name = $screen_name;
    }

    public function setCreatedAt($date){
        $this->created_at = $date;
    }

    public function jsonSerialize()
    {
        return array(
            'id' => $this->id,
            'text'=> $this->social_txt,
            'createdAt'=> $this->created_at,
        );
    }

}