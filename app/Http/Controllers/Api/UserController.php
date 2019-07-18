<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Traits\Firebase;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Http\Controllers\Traits\UserApi;
use App\User;
use App\Cities;
use App\Account;
use DB;
use App\Notification;
use App\Http\Controllers\Traits\UserData;
use App\Http\Controllers\Traits\APIHelper;

class UserController extends Controller
{
    use Firebase, RegistersUsers, UserApi, UserData, APIHelper;

    /**
     * login user through Api Post
     *
     * @param Illuminate\Http\Request
     *
     * @return Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $message = '';
        $resultCode = 0;
        $userKey = NULL;

        if (!empty($request->user_email) && !empty($request->user_password)) {
            $email = $request->user_email;
            $password = $request->user_password;

            $auth = User::where('email', '=', $email)->first();
            if (!empty($auth)) {
                $checkPassword = Hash::check($password, $auth->password);

                if ($checkPassword) {
                    $resultCode = 4;
                    $message = 'Login Success';
                    $userKey = $auth->user_key;
                } else {
                    $resultCode = 1;
                    $message = 'Login failed, wrong email or password';
                }
            } else {
                $resultCode = 2;
                $message = 'User account not found';
            }
        } else {
            $resultCode = 2;
            $message = 'User account not found';
        }

        return response()->json([
            'result_code' => $resultCode,
            'request_code' => 200,
            'message' => $message,
            'user_key' => $userKey
        ]);
    }

    /**
     * register user through Api Post
     *
     * @param Illuminate\Http\Request
     *
     * @return Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $message = '';
        $resultCode = 0;

        $validator = Validator::make($request->all(), [
            'user_name' => 'required|max:191|regex:/^(\pL+\s?)*\s*$/',
            'user_email' => 'required|email|unique:users,email|max:191',
            'user_password' => 'required|string|min:6|alpha_num'
        ], [
            'user_name.required' => 'Nama tidak boleh kosong',
            'user_name.max' => 'Nama tidak boleh lebih dari :max karakter',
            'user_name.regex' => 'Format Nama tidak valid',
            'user_email.required' => 'Alamat Email tidak boleh kosong',
            'user_email.email' => 'Alamat Email harus dalam format email standar',
            'user_email.unique' => 'Alamat Email telah digunakan',
            'user_email.max' => 'Alamat Email tidak boleh lebih dari :max karakter',
            'user_password.required' => 'Kata sandi tidak boleh kosong',
            'user_password.min' => 'Kata sandi minimal terdiri dari :min karakter',
            'user_password.alpha_num' => 'Kata sandi harus berupa alfanumerik'
        ]);

        if ($validator->fails()) {
            $errors = (object)array();
            $validatorMessage = $validator->getMessageBag()->toArray();

            isset($validatorMessage['user_name']) ? ($errors->user_name = $validatorMessage['user_name'][0]) : $errors;
            isset($validatorMessage['user_email']) ? ($errors->user_email = $validatorMessage['user_email'][0]) : $errors;
            isset($validatorMessage['user_password']) ? ($errors->user_password = $validatorMessage['user_password'][0]) : $errors;

            return response()->json([
                'result_code' => 6,
                'request_code' => 200,
                'errors' => $errors
            ]);
        }

        $user = User::create([
            'name' => rtrim(ltrim($request->user_name)),
            'email' => $request->user_email,
            'password' => Hash::make($request->user_password),
            'user_key' => md5($request->user_email),
            'has_created_password' => 1
        ]);

        if ($user) {
            $user->sendEmailVerificationNotification();
            $message = 'Register Success';
            $resultCode = 5;
        }

        return response()->json([
            'result_code' => $resultCode,
            'request_code' => 200,
            'message' => $message
        ]);
    }

    /**
     * edit user password
     *
     * @param Illuminate\Http\Request
     *
     * @return Illuminate\Http\Response
     */
    public function editPassword(Request $request)
    {
        if (!$request->has('user_key') && $request->user_key != '') {
            return response()->json([
                'result_code' => 2,
                'request_code' => 200,
                'message' => 'User not found'
            ]);
        }

        $email = $this->getUserEmail($request->user_key);

        if ($email) {
            $user = User::where('email', '=', $email)->first();

            if ($user) {
                $request->password = $user->password;
                $validator = Validator::make($request->only('user_old_password', 'user_new_password', 'user_new_password_confirmation'), [
                    'user_old_password' => [
                        'required',
                        function ($attribute, $value, $fail) {
                            if (!Hash::check($value, request()->password)) {
                                $fail("Password lama tidak sesuai");
                            }
                        }

                    ],
                    'user_new_password' => 'required|alpha_num|min:6|confirmed|not_in:' . $request->user_old_password
                ], [
                    'user_old_password.required' => 'Password lama tidak boleh kosong',
                    'user_new_password.required' => 'Password baru tidak boleh kosong',
                    'user_new_password.min' => 'Password baru setidaknya terdiri dari :min karakter',
                    'user_new_password.alpha_num' => 'Password baru harus berisikan huruf dan angka',
                    'user_new_password.confirmed' => 'Konfirmasi password baru tidak sesuai',
                    'user_new_password.not_in' => 'Password baru tidak boleh sama dengan password lama'
                ]);

                if ($validator->fails()) {
                    $errors = (object)array();
                    $validatorMessage = $validator->getMessageBag()->toArray();

                    isset($validatorMessage['user_old_password']) ? ($errors->user_old_password = $validatorMessage['user_old_password'][0]) : $errors;
                    isset($validatorMessage['user_new_password']) ? ($errors->user_new_password = $validatorMessage['user_new_password'][0]) : $errors;

                    return response()->json([
                        'result_code' => 7,
                        'request_code' => 200,
                        'errors' => $errors
                    ]);
                }

                $user->update([
                    'password' => Hash::make($request->user_new_password)
                ]);

                return response()->json([
                    'result_code' => 3,
                    'request_code' => 200,
                    'message' => 'There is change on user profile, update user local data'
                ]);

            } else {
                return response()->json([
                    'result_code' => 2,
                    'request_code' => 200,
                    'message' => 'User not found'
                ]);
            }
        } else {
            return response()->json([
                'result_code' => 2,
                'request_code' => 200,
                'message' => 'User not found'
            ]);
        }
    }

    /**
     * create user password
     *
     * @param Illuminate\Http\Request
     *
     * @return Illuminate\Http\Response
     */
    public function createPassword(Request $request)
    {
        if (!$request->has('user_key')) {
            return response()->json([
                'result_code' => 2,
                'request_code' => 200,
                'message' => 'User not found'
            ]);
        }

        $email = $this->getUserEmail($request->user_key);

        if ($email) {
            $user = User::where('email', $email)->first();

            if ($user && isset($user->firebase_uid) && !isset($user->has_created_password)) {
                $validator = Validator::make($request->only(['user_password', 'user_password_confirmation']), [
                    'user_password' => 'required|alpha_num|min:6|confirmed'
                ], [
                    'user_password.required' => 'Password tidak boleh kosong',
                    'user_password.min' => 'Password setidaknya terdiri dari :min karakter',
                    'user_password.alpha_num' => 'Password harus berisikan huruf dan angka',
                    'user_password.confirmed' => 'Konfirmasi password tidak sesuai'
                ]);

                if ($validator->fails()) {
                    $errors = (object)array();
                    $validatorMessage = $validator->getMessageBag()->toArray();

                    isset($validatorMessage['user_password']) ? ($errors->user_password = $validatorMessage['user_password'][0]) : $errors;

                    return response()->json([
                        'result_code' => 8,
                        'request_code' => 200,
                        'errors' => $errors
                    ]);

                }

                $user->update([
                    'password' => Hash::make($request->user_password),
                    'has_created_password' => 1
                ]);

                return response()->json([
                    'result_code' => 3,
                    'request_code' => 200,
                    'message' => 'There is change on user profile, update user local data'
                ]);

            } else {
                return response()->json([
                    'result_code' => 2,
                    'request_code' => 200,
                    'message' => 'User not found'
                ]);
            }
        } else {
            return response()->json([
                'result_code' => 2,
                'request_code' => 200,
                'message' => 'User not found'
            ]);
        }
    }

    /**
     * register user from firebase
     *
     * @param Illuminate\Http\Request
     *
     * @return Illuminate\Http\Response
     */
    public function registerFromFirebase(Request $request)
    {
        if (!$request->has('user_key')) {
            return response()->json([
                'result_code' => 9,
                'request_code' => 200,
                'message' => 'There is no data'
            ]);
        }

        $email = $this->getUserEmail((string)$request->user_key);

        // check if registered user does not have User data
        $userData = User::where('email', $email)->count();

        if ($userData < 1) {
            $user = $this->registerUserFromFirebase($request->user_key, $email);

            if ($user) {
                $user->sendEmailVerificationNotification();
            }

            return response()->json([
                'result_code' => 5,
                'request_code' => 200,
                'message' => 'Register success'
            ]);
        } else {
            if (isset( $userData->firebase_uid)) {
                $userData->update([
                    'firebase_uid' => $request->user_key
                ]);
            } else {
                return response()->json([
                    'result_code' => 6,
                    'request_code' => 200,
                    'message' => 'User already registered'
                ]);
            }
        }
    }

    /**
     * get user detail based on email
     *
     * @return Illuminate\Http\Response
     */
    public function getUserDetail(Request $request)
    {
        $email = $this->getUserEmail((string)$request->user_key);

        if ($email == '') {
            return response()->json([
                'result_code' => 2,
                'request_code' => 200,
                'data' => [
                    'message' => 'User not found'
                ]
            ]);
        }

        $user = User::where('email', $email)->first();

        $userTrees = 0;
        foreach ($user->orders as $order) {
            if ($order->status > 2) {
                $userTrees = $userTrees + $order->product->tree_quantity;
            }
        }

        $data = $this->getUserData($user);

        return response()->json([
            'request_code' => 200,
            'data' => $data,
            'result_code' => 4,
        ]);
    }

    /**
     * update user data
     *
     * @param Illuminate\Http\Request
     *
     * @return Illuminate\Http\Response
     */
    public function updateUserDetail(Request $request)
    {
        /**
         * request param && mapping
         * - user_name => user->name
         * - user_birth_date => userInformation->born_date
         * - user_sex => userInformation->gender
         * - user_phone => userInformation->phone
         * - user_address => userInformation->address
         * - user_city => userInformation->city
         * - user_state => userInformation->province
         * - user_zip_code => userInformation->postal_code
         * - user_id_number => userInformation->ktp
         */
        $email = $this->getUserEmail((string)$request->user_key);

        if ($email == '') {
            return response()->json([
                'result_code' => 2,
                'request_code' => 200,
                'message' => 'User not found'
            ]);
        }

        if (!$request->user_name && !$request->user_birth_date && !$request->user_sex && !$request->user_phone && !$request->user_address && !$request->user_city && !$request->user_state && !$request->user_zip_code && !$request->user_id_number) {
            return response()->json([
                'result_code' => 7,
                'request_code' => 200,
                'data' => [
                    'message' => 'Data not found'
                ]
            ]);
        }

        $user = User::where('email', $email)->first();

        if ($user) {
            $validator = Validator::make($request->all(), [
                'user_name' => 'nullable|regex:/^(\pL+\s?)*\s*$/|max:191',
                'user_birth_date' => 'nullable|date|before:' . now()->subYears(17),
                'user_sex' => 'nullable|in:1,2',
                'user_phone' => 'nullable|numeric|digits_between:8,14',
                'user_address' => 'nullable',
                'user_city' => 'nullable|exists:cities,id',
                'user_state' => 'nullable|exists:provinces,id',
                'user_zip_code' => 'nullable|numeric|digits:5',
                'user_id_number' => 'nullable|numeric|digits:16|unique:user_informations,ktp,' . $user->userInformation->id
            ], [
                'user_name.regex' => 'Nama pengguna tidak sesuai',
                'user_name.max' => 'Nama pengguna tidak boleh lebih dari :max karakter',
                'user_birth_date.before' => 'Tanggal lahir tidak boleh lebih dari ' . now()->subYears(17)->firstOfYear()->format('d/m/Y'),
                'user_birth_date.date' => 'Format tanggal lahir tidak sesuai',
                'user_sex.in' => 'Jenis kelamin tidak sesuai',
                'user_phone.numeric' => 'Nomor telepon harus berupa angka',
                'user_phone.digits_between' => 'Jumlah digit nomor telepon tidak sesuai',
                'user_city.exists' => 'Data kota tidak terdapat pada basis data',
                'user_state.exists' => 'Data provinsi tidak terdapat pada basis data',
                'user_zip_code.numeric' => 'Kode Pos harus berupa angka',
                'user_zip_code.digits' => 'Kode pos harus terdiri dari 5 digit angka',
                'user_id_number.numeric' => 'Nomor ktp harus berupa angka',
                'user_id_number.digits' => 'Nomor ktp harus terdiri dari 16 digit angka',
                'user_id_number.unique' => 'Nomor ktp sudah digunakan'
            ]);

            if ($validator->fails()) {
                $errors = (object)array();
                $validatorMessage = $validator->getMessageBag()->toArray();

                isset($validatorMessage['user_name']) ? ($errors->user_name = $validatorMessage['user_name'][0]) : $errors;
                isset($validatorMessage['user_birth_date']) ? ($errors->user_birth_date = $validatorMessage['user_birth_date'][0]) : $errors;
                isset($validatorMessage['user_sex']) ? ($errors->user_sex = $validatorMessage['user_sex'][0]) : $errors;
                isset($validatorMessage['user_phone']) ? ($errors->user_phone = $validatorMessage['user_phone'][0]) : $errors;
                isset($validatorMessage['user_address']) ? ($errors->user_address = $validatorMessage['user_address'][0]) : $errors;
                isset($validatorMessage['user_city']) ? ($errors->user_city = $validatorMessage['user_city'][0]) : $errors;
                isset($validatorMessage['user_state']) ? ($errors->user_state = $validatorMessage['user_state'][0]) : $errors;
                isset($validatorMessage['user_zip_code']) ? ($errors->user_zip_code = $validatorMessage['user_zip_code'][0]) : $errors;
                isset($validatorMessage['user_id_number']) ? ($errors->user_id_number = $validatorMessage['user_id_number'][0]) : $errors;

                return response()->json([
                    'result_code' => 8,
                    'request_code' => 200,
                    'errors' => $errors
                ]);
            }
        }

        $user->update([
            'name' => $request->user_name ?? $user->name
        ]);

        $userInformation = $user->userInformation()->first();

        $userInformation->update([
            'born_date' => $request->user_birth_date ?? $userInformation->born_date,
            'gender' => $request->user_sex ?? $userInformation->gender,
            'phone' => $request->user_phone ?? $userInformation->phone,
            'address' => $request->user_address ?? $userInformation->address,
            'city_id' => $request->user_city ?? $userInformation->city,
            'province' => ($request->has('user_city') ? Cities::find($request->user_city)->province_id : $request->user_state) ?? $userInformation->province,
            'postal_code' => $request->user_zip_code ?? $userInformation->postal_code,
            'ktp' => $request->user_id_number ?? $userInformation->ktp
        ]);

        return response()->json([
            'result_code' => 3,
            'request_code' => 200,
            'data' => [
                'message' => 'There is change on user profile, update user local data'
            ]
        ]);
    }

    /**
     * update user id image
     *
     * @param Illuminate\Http\Request
     *
     * @return Illuminate\Http\Response
     */
    public function updateUserIdImage(Request $request)
    {
        $email = $this->getUserEmail((string)$request->user_key);

        if ($email == '') {
            return response()->json([
                'result_code' => 2,
                'request_code' => 200,
                'data' => [
                    'message' => 'User not found'
                ]
            ]);
        }

        $user = User::where('email', $email)->first();

        $userInformation = $user->userInformation()->first();

        if ($request->has('user_id_image')) {
            $validator = Validator::make($request->all(), [
                'user_id_image' => 'image|mimes:jpeg,jpg,bmp,png|max:2048'
            ]);

            if ($validator->fails()) {
                $errors = (object)array();
                $validatorMessage = $validator->getMessageBag()->toArray();

                isset($validatorMessage['user_id_image']) ? ($errors->user_id_image = $validatorMessage['user_id_image'][0]) : $errors;

                return response()->json([
                    'result_code' => 8,
                    'request_code' => 200,
                    'errors' => $errors
                ]);
            }

            $path = $request->file('user_id_image')->store('public/user');

            $fileName = basename($path);

            $userInformation->update([
                'user_id_image' => config('app.url') . '/images/user/' . $fileName
            ]);

            return response()->json([
                'result_code' => 3,
                'request_code' => 200,
                'message' => 'There is change on user profile, update user local data'
            ]);
        } else {
            return response()->json([
                'result_code' => 7,
                'request_code' => 200,
                'message' => 'Image not found'
            ]);
        }
    }

    /**
     * update user image
     *
     * @param Illuminate\Http\Request
     *
     * @return Illuminate\Http\Response
     */
    public function updateUserImage(Request $request)
    {
        $email = $this->getUserEmail((string)$request->user_key);

        if ($email == '') {
            return response()->json([
                'result_code' => 2,
                'request_code' => 200,
                'data' => [
                    'message' => 'User not found'
                ]
            ]);
        }

        $user = User::where('email', $email)->first();

        $userInformation = $user->userInformation()->first();

        if ($request->has('user_image')) {
            $validator = Validator::make($request->all(), [
                'user_image' => 'image|mimes:jpeg,jpg,bmp,png|max:2048'
            ]);

            if ($validator->fails()) {
                $errors = (object)array();
                $validatorMessage = $validator->getMessageBag()->toArray();

                isset($validatorMessage['user_image']) ? ($errors->user_image = $validatorMessage['user_image'][0]) : $errors;

                return response()->json([
                    'result_code' => 8,
                    'request_code' => 200,
                    'errors' => $errors
                ]);
            }

            $path = $request->file('user_image')->store('public/user');

            $fileName = basename($path);

            $userInformation->update([
                'user_image' => config('app.url') . '/images/user/' . $fileName
            ]);

            return response()->json([
                'result_code' => 3,
                'request_code' => 200,
                'message' => 'There is change on user profile, update user local data'
            ]);
        } else {
            return response()->json([
                'result_code' => 7,
                'request_code' => 200,
                'message' => 'Image not found'
            ]);
        }
    }

    /**
     * add user bank data
     *
     * @param Illuminate\Http\Request
     *
     * @return Illuminate\Http\Response
     */
    public function userAddBank(Request $request)
    {
        if ($request->has('user_key') && $request->user_key != '') {
            $email = $this->getUserEmail($request->user_key);

            if ($email == '') {
                return response()->json([
                    'request_code' => 200,
                    'result_code' => 2,
                    'message' => 'User not found'
                ]);
            } else {
                $user = User::where('email', $email)->first();

                $validator = Validator::make($request->only(['user_bank_name', 'user_bank_account_name', 'user_bank_account_number']), [
                    'user_bank_name' => 'required|string|max:191',
                    'user_bank_account_name' => 'required|string|max:191',
                    'user_bank_account_number' => 'required|numeric|digits_between:10,15'
                ], [
                    'user_bank_name.required' => 'Nama Bank tidak boleh kosong',
                    'user_bank_name.max' => 'Nama Bank tidak boleh lebih dari :max karakter',
                    'user_bank_account_name.required' => 'Nama pemilik rekening tidak boleh kosong',
                    'user_bank_account_name.max' => 'Nama pemilik rekening tidak boleh lebih dari :max karakter',
                    'user_bank_account_number.required' => 'Nomor rekening tidak boleh kosong',
                    'user_bank_account_number.numeric' => 'Nomor rekening harus berupa angka',
                    'user_bank_account_number.digits_between' => 'Nomor rekening harus berada di antara :min hingga :max digit'
                ]);

                if ($validator->fails()) {
                    $errors = (object) array();
                    $validatorMessage = $validator->getMessageBag()->toArray();

                    isset($validatorMessage['user_bank_name']) ? ($errors->user_bank_name = $validatorMessage['user_bank_name'][0]) : $errors;
                    isset($validatorMessage['user_bank_account_name']) ? ($errors->user_bank_account_name = $validatorMessage['user_bank_account_name'][0]) : $errors;
                    isset($validatorMessage['user_bank_account_number']) ? ($errors->user_bank_account_number = $validatorMessage['user_bank_account_number'][0]) : $errors;

                    return response()->json([
                        'result_code' => 8,
                        'request_code' => 200,
                        'errors' => $errors
                    ]);
                }

                $account = Account::create([
                    'user_id' => $user->id,
                    'token' => md5('Bank-' . now()),
                    'name' => $request->user_bank_name,
                    'holder_name' => $request->user_bank_account_name,
                    'number' => $request->user_bank_account_number
                ]);

                if ($account) {
                    return response()->json([
                        'result_code' => 4,
                        'request_code' => 200,
                        'message' => 'Bank created'
                    ]);
                }
            }
        } else {
            return response()->json([
                'request_code' => 200,
                'result_code' => 2,
                'message' => 'User not found'
            ]);
        }
    }

    /**
     * edit user bank data
     *
     * @param Illuminate\Http\Request
     *
     * @return Illuminate\Http\Response
     */
    public function userEditBank(Request $request)
    {
        if ($request->has('user_key') && $request->user_key != '') {
            $email = $this->getUserEmail($request->user_key);
            $user = User::where('email', $email)->first();

            if ($request->has('user_bank_id') && $request->user_bank_id != '') {
                $bank = $user->banks()->where('token', $request->user_bank_id)->first();

                if (!$request->has('user_bank_name') && !$request->has('user_bank_account_name') && !$request->has('user_bank_account_number')) {
                    return response()->json([
                        'result_code' => 7,
                        'request_code' => 200,
                        'message' => 'Bad request'
                    ]);
                }

                if (isset($bank)) {
                    $validator = Validator::make($request->only([
                        'user_bank_name',
                        'user_bank_account_name',
                        'user_bank_account_number'
                    ]), [
                        'user_bank_name' => 'string|max:191',
                        'user_bank_account_name' => 'string|max:191',
                        'user_bank_account_number' => 'sometimes|numeric|digits_between:10,15'
                    ], [
                        'user_bank_name.string' => 'Nama Bank tidak boleh kosong',
                        'user_bank_name.max' => 'Nama Bank tidak boleh lebih dari :max karakter',
                        'user_bank_account_name.max' => 'Nama pemilik rekening tidak boleh lebih dari :max karakter',
                        'user_bank_account_name.string' => 'Nama pemilik rekening tidak boleh kosong',
                        'user_bank_account_number.numeric' => 'Nomor rekening harus berupa angka',
                        'user_bank_account_number.sometimes' => 'Nomor rekening tidak boleh kosong',
                        'user_bank_account_number.digits_between' => 'Nomor rekening harus berada di antara :min hingga :max digit'
                    ]);

                    if ($validator->fails()) {
                        $errors = (object) array();
                        $validatorMessage = $validator->getMessageBag()->toArray();

                        isset($validatorMessage['user_bank_name']) ? ($errors->user_bank_name = $validatorMessage['user_bank_name'][0]) : $errors;
                        isset($validatorMessage['user_bank_account_name']) ? ($errors->user_bank_account_name = $validatorMessage['user_bank_account_name'][0]) : $errors;
                        isset($validatorMessage['user_bank_account_number']) ? ($errors->user_bank_account_number = $validatorMessage['user_bank_account_number'][0]) : $errors;

                        return response()->json([
                            'result_code' => 7,
                            'request_code' => 200,
                            'errors' => $errors
                        ]);
                    }

                    $bank->update([
                        'name' => $request->has('user_bank_name') ? $request->user_bank_name : $bank->name,
                        'holder_name' => $request->has('user_bank_account_name') ? $request->user_bank_account_name : $bank->holder_name,
                        'number' => $request->has('user_bank_account_number') ? $request->user_bank_account_number : $bank->number
                    ]);

                    if ($bank) {
                        return response()->json([
                            'result_code' => 3,
                            'request_code' => 200,
                            'message' => 'There is change on user profile, update user local data'
                        ]);
                    }
                } else {
                    return response()->json([
                        'request_code' => 200,
                        'result_code' => 9,
                        'message' => 'There is no data'
                    ]);
                }
            } else {
                return response()->json([
                    'request_code' => 200,
                    'result_code' => 9,
                    'message' => 'There is no data'
                ]);
            }
        } else {
            return response()->json([
                'request_code' => 200,
                'result_code' => 2,
                'message' => 'User not found'
            ]);
        }
    }

    /**
     * delete user bank data
     *
     * @param Illuminate\Http\Request
     *
     * @return Illuminate\Http\Response
     */
    public function userDeleteBank(Request $request)
    {
        if ($request->has('user_key') && $request->user_key != '') {
            $email = $this->getUserEmail($request->user_key);
            
            if ($email == '') {
                return response()->json([
                    'request_code' => 200,
                    'result_code' => 2, 
                    'message' => 'User not found'
                ]);
            } else {
                $user = User::where('email', $email)->first();

                if ($request->has('user_bank_id') && $request->user_bank_id != '') {
                    $bank = $user->banks()->where('token', $request->user_bank_id)->first();

                    if (isset($bank)) {
                        $bank->delete();
                        return response()->json([
                            'request_code' => 200,
                            'result_code' => 4,
                            'message' => 'Bank deleted'
                        ]);
                    } else {
                        return response()->json([
                            'request_code' => 200,
                            'result_code' => 9,
                            'message' => 'There is no data'
                        ]);
                    }
                } else {
                    return response()->json([
                        'request_code' => 200,
                        'result_code' => 7,
                        'message' => 'Bad request'
                    ]);
                }
            }
        } else {
            return response()->json([
                'request_code' => 200,
                'result_code' => 2,
                'message' => 'User not found'
            ]);
        }

        if (!$request->has('user_bank_id')) {
            return response()->json([
                'result_code' => 9,
                'request_code' => 200,
                'message' => 'There is no data'
            ]);
        }

        $user = User::where('email', $email)->first();

        if ($user) {
            $account = Account::where('id', $request->user_bank_id)->where('user_id', $user->id)->first();

            if ($account) {
                $account->delete();

                return response()->json([
                    'result_code' => 3,
                    'request_code' => 200,
                    'message' => 'There is change on user profile, update user local data'
                ]);
            } else {
                return response()->json([
                    'result_code' => 9,
                    'request_code' => 200,
                    'message' => 'There is no data'
                ]);
            }
        } else {
            return response()->json([
                'result_code' => 2,
                'request_code' => 200,
                'message' => 'User not found'
            ]);
        }
    }

    /**
     * resend email verification
     *
     * @param Illuminate\Http\Request
     *
     * @return Illuminate\Http\Response
     */
    public function resendVerificationEmail(Request $request)
    {
        if ($request->has('user_key') && $request->user_key != '') {
            $email = $this->getUserEmail((string)$request->user_key);
            
            if ($email == '') {
                return response()->json([
                    'request_code' => 200,
                    'result_code' => 2,
                    'message' => 'User not found'
                ]);
            } else {
                $user = User::where('email', $email)->first();

                if (isset($user->email_verified_at)) {
                    return response()->json([
                        'request_code' => 200,
                        'result_code' => 4,
                        'message' => 'User already registered'
                    ]);
                } else {
                    $user->sendEmailVerificationNotification();

                    return response()->json([
                        'request_code' => 200,
                        'result_code' => 4,
                        'message' => 'Email verification sent'
                    ]);
                }
            }
        } else {
            return response()->json([
                'request_code' => 200,
                'result_code' => 2,
                'message' => 'User not found'
            ]);
        }
    }

    /**
     * get all notifications based on user key
     * 
     * @param Iluminate\Http\Request
     * 
     * @return Illuminate\Http\Response
     */
    public function getNotifications(Request $request)
    {
        $pagination = $this->paginateResult($request);

        if ($request->has('user_key') && $request->user_key != '') {
            $email = $this->getUserEmail((string) $request->user_key);

            if ($email == '') {
                return response()->json([
                    'request_code' => 200,
                    'result_code' => 2,
                    'data' => [
                        'message' => 'User not found'
                    ]
                ]);
            } else {
                $user = User::where('email', $email)->first();
                $notifications = $user
                    ->notifications()
                    ->orderBy('created_at', 'DESC')
                    ->limit($pagination['dataPerPage'])
                    ->offset($pagination['offset'])
                    ->get([
                        'token AS notification_id',
                        'status AS notification_status',
                        'title AS notification_title',
                        'subtitle AS notification_subtitle',
                        'content AS notification_content',
                        'created_at AS notification_time'
                ]);

                if ($notifications->count() > 0) {
                    return response()->json([
                        'request_code' => 200,
                        'result_code' => 4,
                        'notification_list' => $notifications
                    ]);
                } else {
                    return response()->json([
                        'request_code' => 200,
                        'result_code' => 9,
                        'message' => 'There is no data'
                    ]);
                }
            }
        } else {
            return response()->json([
                'request_code' => 200,
                'result_code' => 2,
                'data' => [
                    'message' => 'User not found'
                ]
            ]);
        }
    }

    /**
     * mark notification as read
     * 
     * @param Illuminate\Http\Request
     * 
     * @return Illuminate\Http\Response
     */
    public function markNotificationAsRead(Request $request)
    {
        if ($request->has('notification_id') && $request->notification_id != '') {
            $notification = Notification::where('token', $request->notification_id)->first();

            if (isset($notification)) {
                if ($notification->status != 1) {
                    $notification->update([
                        'status' => 1
                    ]);

                    return response()->json([
                        'request_code' => 200,
                        'result_code' => 4,
                        'message' => 'Read notification'
                    ]);
                } else {
                    return response()->json([
                        'request_code' => 200,
                        'result_code' => 8,
                        'message' => 'Edit failed'
                    ]);
                }
            } else {
                return response()->json([
                    'request_code' => 200,
                    'result_code' => 9,
                    'data' => [
                        'message' => 'There is no data'
                    ]
                ]);
            }
        } else {
            return response()->json([
                'request_code' => 200,
                'result_code' => 7,
                'data' => [
                    'message' => 'Bad request'
                ]
            ]);
        }
    }
}
