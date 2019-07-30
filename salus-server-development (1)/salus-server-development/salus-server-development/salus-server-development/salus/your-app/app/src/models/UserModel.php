<?php
namespace App\Model;

final class UserModel extends BaseModel
{
    /**
     * Add user record to 'user' table
     * [in]$email               User record 'email' field value 
     * [in]$hashed_password     User record 'hashed_password' field value
     * [in]$nonce               User record 'nonce' field value
     * [in]$firstName           User record 'fiest_name' field value
     * [in]$lastName            User record 'last_name' field value
     */
    public function addUser($email, $hashed_password, $nonce, $firstName, $lastName){
        $query = $this->db->prepare("INSERT users SET 
            email=:email, hashed_password=:hashed_password, 
            reg_time=now(), is_admin=0, is_active=0, 
            is_web_logged_in=0, web_last_act=now(),
            is_app_logged_in=0, app_last_act=now(),
            nonce=:nonce, first_name=:first_name, last_name=:last_name");
            
        $query->execute(['email' => $email, 'hashed_password' => $hashed_password,
                         'nonce' => $nonce, 'first_name' => $firstName, 'last_name' => $lastName]); 
    }

    /**
     * Check user record by email
     * [in]$email           Email to search
     * [out]$outUser        Return parameter for user record
     * [return]             If user exist reutrn true, otherwise return false.    
     */
    public function tryGetUserRecordByEmail($email, &$outUser)
    {
        $query = $this->db->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
        $query->execute(['email' => $email]); 
        $data = $query->fetch();
        
        if(!$data)
        {
            $outUser = null;
            return false;
        }
        
        $outUser = $data;
        return true;
    }
}