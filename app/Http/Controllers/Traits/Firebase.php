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

    public function userDetail($email)
    {
        $auth = $this->initialize();
        $user = $auth->getUserByEmail($email);
        
        return $user;
    }

    public function createUserFromFirebase($name, $email, $password)
    {
        $auth = $this->initialize();
        $userProperties = [
            'email' => $email,
            'password' => $password,
            'displayName' => $name,
        ];

        $createdUser = $auth->createUser($userProperties);

        return $createdUser;
    }
}
