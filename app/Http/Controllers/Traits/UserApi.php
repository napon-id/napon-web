<?php

namespace App\Http\Controllers\Traits;

use App\User;
use Illuminate\Support\Facades\Hash;

trait UserApi
{
    /**
     * get User email from User key
     *
     * @param string user_key
     *
     * @return string email
     */
    public function getUserEmail(string $user_key)
    {
        // check for local firebase_uid key
        $user = User::where('firebase_uid', '=', $user_key)->first();

        if (!$user) {
            $user = User::where('user_key', '=', $user_key)->first();
        }

        if (!$user) {
            // check user stored on firebase
            $firebaseObject = $this->userDetail($user_key);
            $user = User::where('email', $firebaseObject->email)->first();
            if (isset($user)) {
                // store fireabse uid to local firebase_uid
                $user->update([
                    'firebase_uid' => $firebaseObject->uid
                ]);
            }
        }

        if (!$user) {
            if (isset($firebaseObject)) {
                return (string) $firebaseObject->email;
            } else {
                return '';
            }
        } else {
            if (isset($firebaseObject)) {
                return (string) $firebaseObject->email;
            } else {
                return (string) $user->email;
            }
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

    /**
     * register user from firebase
     * 
     * @param string user_key
     * 
     * @return App\User
     */
    public function registerUserFromFirebase($user_key, $email)
    {
        $user = User::create([
            'name' => $email,
            'email' => $email,
            'password' => Hash::make($user_key),
            'firebase_uid' => (string) $user_key,
            'user_key' => md5($email)
        ]);

        return $user;
    }

    /**
     * Check whether password input match with current password
     * 
     * @param string input
     * @param string password
     * 
     * @return bool
     */
    public function passwordCheck($input, $password)
    {
        return Hash::check($password, $input);
    }
}
