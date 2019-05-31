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

class UserController extends Controller
{
    use Firebase, RegistersUsers, UserApi;

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
        if (!$request->has('user_key')) {
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
                        'result_code' => 8,
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

        // check if registered user does not have User data
        $userData = User::where('email', $email)->count();

        if ($userData < 1) {
            $user = $this->registerUserFromFirebase($request->user_key, $email);

            if ($user) {
                $user->sendEmailVerificationNotification();
            }
        }

        $user = DB::table('users')
            ->leftJoin('user_informations', 'users.id', '=', 'user_informations.user_id')
            ->leftJoin('cities', 'cities.id', '=', 'user_informations.city')
            ->leftJoin('provinces', 'provinces.id', '=', 'cities.province_id')
            ->leftJoin('orders', 'orders.user_id', '=', 'users.id')
            ->leftJoin('products', 'products.id', '=', 'orders.product_id')
            ->leftJoin('trees', 'trees.id', '=', 'products.tree_id')
            ->leftJoin('balances', 'balances.id', '=', 'users.id')
            ->select(
                DB::raw('users.name AS user_name'),
                DB::raw('users.email AS user_email'),
                DB::raw('user_informations.user_image AS user_image'),
                DB::raw('user_informations.born_place AS user_birth_place'),
                DB::raw('user_informations.born_date AS user_birth_date'),
                DB::raw('user_informations.gender AS user_sex'),
                DB::raw('
                    (
                        CASE
                            WHEN user_informations.gender = "1"
                            THEN "Laki-Laki"
                            WHEN user_informations.gender = "2"
                            THEN "Wanita"
                            ELSE null
                            END
                        ) AS user_sex'),
                DB::raw('user_informations.phone AS user_phone'),
                DB::raw('user_informations.address AS user_address'),
                DB::raw('cities.name AS user_city'),
                DB::raw('provinces.name AS user_state'),
                DB::raw('user_informations.postal_code AS user_zip_code'),
                DB::raw('user_informations.ktp AS user_id_number'),
                DB::raw('user_informations.user_id_image AS user_id_image'),
                DB::raw('SUM(products.tree_quantity) AS user_total_tree'),
                DB::raw('users.created_at AS user_join_date'),
                DB::raw('balances.balance AS user_balance'),
                DB::raw('
                    SUM(trees.price)
                    AS user_total_investment'),
                DB::raw('
                    (
                        CASE
                            WHEN users.email_verified_at IS NULL
                            THEN false
                            ELSE true
                            END
                        ) AS user_email_verified')
            )
            ->where('users.email', '=', $email)
            ->groupBy(
                'users.id',
                'user_informations.id'
            )
            ->first();

        $banks = DB::table('users')
            ->rightJoin('accounts', 'accounts.user_id', '=', 'users.id')
            ->select(
                DB::raw('accounts.id AS user_bank_id'),
                DB::raw('accounts.name AS user_bank_name'),
                DB::raw('accounts.holder_name AS user_bank_account_name'),
                DB::raw('accounts.number AS user_bank_account_number')
            )
            ->where('users.email', '=', $email)
            ->get();

        if ($user) {
            $user->user_banks = $banks;

            if (!empty($user->user_birth_place) && !empty($user->user_birth_date) && !empty($user->user_sex) && !empty($user->user_phone) && !empty($user->user_address) && !empty($user->user_city) && !empty($user->user_state) && !empty($user->user_zip_code) && !empty($user->user_id_number) && !empty($user->user_id_image)) {
                $user->user_data_filled = (bool)true;
            } else {
                $user->user_data_filled = (bool)false;
            }

            // cast string to other data type
            $user->user_balance = (double)$user->user_balance;
            $user->user_total_tree = (int)$user->user_total_tree;
            $user->user_total_investment = (double)$user->user_total_investment;
            $user->user_email_verified = (bool)$user->user_email_verified;
        }

        return response()->json([
            'request_code' => 200,
            'data' => $user,
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
         * - user_birth_place => userInformation->born_place
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

        if (!$request->user_name && !$request->user_birth_place && !$request->user_birth_date && !$request->user_sex && !$request->user_phone && !$request->user_address && !$request->user_city && !$request->user_state && !$request->user_zip_cpde && !$request->user_id_number) {
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
                'user_birth_place' => 'nullable|regex:/^(\pL+\s?)*\s*$/|max:191',
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
                'user_birth_place.regex' => 'Tempat lahir tidak sesuai',
                'user_birth_place.max' => 'Tempat lahir tidak boleh lebih dari :max karakter',
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
                isset($validatorMessage['user_birth_place']) ? ($errors->user_birth_place = $validatorMessage['user_birth_place'][0]) : $errors;
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
            'born_place' => $request->user_birth_place ?? $userInformation->born_place,
            'born_date' => $request->user_birth_date ?? $userInformation->born_date,
            'gender' => $request->user_sex ?? $userInformation->gender,
            'phone' => $request->user_phone ?? $userInformation->phone,
            'address' => $request->user_address ?? $userInformation->address,
            'city' => $request->user_city ?? $userInformation->city,
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
        $email = $this->getUserEmail($request->user_key);

        $user = User::where('email', $email)->first();

        if ($user) {
            $validator = Validator::make($request->all(), [
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
                $errors = (object)array();
                $validatorMessage = $validator->getMessageBag()->toArray();

                isset($validatorMessage['user_bank_name']) ? ($errors->user_name = $validatorMessage['user_bank_name'][0]) : $errors;
                isset($validatorMessage['user_bank_account_name']) ? ($errors->user_email = $validatorMessage['user_bank_account_name'][0]) : $errors;
                isset($validatorMessage['user_bank_account_number']) ? ($errors->user_password = $validatorMessage['user_bank_account_number'][0]) : $errors;

                return response()->json([
                    'result_code' => 7,
                    'request_code' => 200,
                    'errors' => $errors
                ]);
            }

            $account = Account::create([
                'user_id' => $user->id,
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
        } else {
            return response()->json([
                'result_code' => 2,
                'request_code' => 200,
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
        $email = $this->getUserEmail($request->user_key);

        if (!$request->has('user_bank_id')) {
            return response()->json([
                'result_code' => 9,
                'request_code' => 200,
                'message' => 'There is no data'
            ]);
        } else {
            if (!$request->has('user_bank_name') && !$request->has('user_bank_account_name') && !$request->has('user_bank_account_number')) {
                return response()->json([
                    'result_code' => 9,
                    'request_code' => 200,
                    'message' => 'There is no data'
                ]);
            }
        }

        $user = User::where('email', $email)->first();

        if ($user) {
            $validator = Validator::make($request->all(), [
                'user_bank_name' => 'nullable|string|max:191',
                'user_bank_account_name' => 'nullable|string|max:191',
                'user_bank_account_number' => 'nullable|numeric|digits_between:10,15'
            ], [
                // 'user_bank_name.required' => 'Nama Bank tidak boleh kosong',
                'user_bank_name.max' => 'Nama Bank tidak boleh lebih dari :max karakter',
                // 'user_bank_account_name.required' => 'Nama pemilik rekening tidak boleh kosong',
                'user_bank_account_name.max' => 'Nama pemilik rekening tidak boleh lebih dari :max karakter',
                // 'user_bank_account_number.required' => 'Nomor rekening tidak boleh kosong',
                'user_bank_account_number.numeric' => 'Nomor rekening harus berupa angka',
                'user_bank_account_number.digits_between' => 'Nomor rekening harus berada di antara :min hingga :max digit'
            ]);

            if ($validator->fails()) {
                $errors = (object)array();
                $validatorMessage = $validator->getMessageBag()->toArray();

                isset($validatorMessage['user_bank_name']) ? ($errors->user_name = $validatorMessage['user_bank_name'][0]) : $errors;
                isset($validatorMessage['user_bank_account_name']) ? ($errors->user_email = $validatorMessage['user_bank_account_name'][0]) : $errors;
                isset($validatorMessage['user_bank_account_number']) ? ($errors->user_password = $validatorMessage['user_bank_account_number'][0]) : $errors;

                return response()->json([
                    'result_code' => 7,
                    'request_code' => 200,
                    'errors' => $errors
                ]);
            }

            $account = Account::where('id', $request->user_bank_id)->where('user_id', $user->id)->first();

            if ($account) {
                $account->update([
                    'name' => $request->has('user_bank_name') ? $request->user_bank_name : $account->name,
                    'holder_name' => $request->has('user_bank_account_name') ? $request->user_bank_account_name : $account->holder_name,
                    'number' => $request->has('user_bank_account_number') ? $request->user_bank_account_number : $account->number
                ]);
                
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
     * delete user bank data
     *
     * @param Illuminate\Http\Request
     *
     * @return Illuminate\Http\Response
     */
    public function userDeleteBank(Request $request)
    {
        $email = $this->getUserEmail($request->user_key);

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
}
