<?php

namespace App\Http\Controllers\Traits;

use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;

trait Firebase
{

    public function initialize()
    {
        $serviceAccount = ServiceAccount::fromJsonFile(__DIR__ . '/Firebase.json');
        $firebase = (new Factory)->withServiceAccount($serviceAccount)->create();
        $auth = $firebase->getAuth();

        return $auth;
    }

    public function userDetail($uid)
    {
        $user = NULL;

        $auth = $this->initialize();
        try {
            $user = $auth->getUser($uid);
        } catch (\Exception $e) {
            $user = NULL;    
        }
        
        return $user;
    }

    public function createUserFromFirebase($name, $email, $password)
    {
        $auth = $this->initialize();
        $userProperties = [
            'email' => $email,
            'password' => $password,
            'displayName' => $name,
            'email_verified_at' => now()
        ];

        $createdUser = $auth->createUser($userProperties);

        return $createdUser;
    }
}
