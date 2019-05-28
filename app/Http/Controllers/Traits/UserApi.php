<?php

namespace App\Http\Controllers\Traits;

use App\User;

trait UserApi
{
    /**
     * get User email from User key
     *
     * @param (string) user_key
     *
     * @return (string) email
     */
    public function getUserEmail(string $user_key)
    {
        $user = User::where('firebase_uid', '=', $user_key)->first();
        if (!$user) {
            $user = $this->userDetail($user_key);
        }

        if (!$user) {
            $user = User::where('user_key', '=', $user_key)->first();
        }

        if (!$user) {
            return '';
        } else {
            return (string)$user->email;
        }
    }

    /**
     * get User key
     *
     * @param App\User
     *
     * @return (array) key
     */
    public function getUserKey(User $user)
    {
        $key = [];
        if ($user->firebase_uid != NULL) {
            $key['userKey'] = $user->firebase_uid;
            $key['is_firebase'] = true;
        } else {
            $key['userKey'] = $user->id;
            $key['is_firebase'] = false;
        }

        return $key;
    }

}
