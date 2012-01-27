<?php

class UserRepository
{
    /**
     * @var Sparrow
     */
    protected $db;

    public function __construct(Sparrow $db)
    {
        $this->db = $db;
    }

    public function getUserByEmail($email)
    {
        return $this->db->from('users')
                    ->where('email = ', $this->db->escape($email))
                    ->one();
    }

    public function create($email, $name=null) {

        return $this->db->from('users')
                    ->insert(array('email' =>  $this->db->escape($email), 'name' => $name))
                    ->execute();
    }
    
    public function updateProfile($user_id, $name=null) {

        return $this->db->from('users')
                    ->where(array('user_id' => $user_id))
                    ->update(array('name' =>  $name))
                    ->execute();
    }

    public function getGravatar($email, $size = 32, $class='thumbnail'){
        $email_hash = md5( strtolower( trim( $email) ) );
        return "<img class='$class' src='http://www.gravatar.com/avatar/$email_hash?s=$size' />";
    }

}
