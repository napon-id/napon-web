<?php
namespace App\Http\Controllers\Traits;

use App\User;

trait UserData
{
    /**
     * return user data as an array
     */
    public function getUserData(User $user): array
    {
        $userTrees = 0;
        foreach ($user->orders as $order) {
            if ($order->status > 2) {
                $userTrees = $userTrees + $order->product->tree_quantity;
            }
        }

        if (isset($user->userInformation->gender) && isset($user->userInformation->phone) && isset($user->userInformation->address) && isset($user->userInformation->city_id) && isset($user->userInformation->postal_code) && isset($user->userInformation->ktp)) {
            $userDataFilled = true;
        } else {
            $userDataFilled = false;
        }

        $data = [
            'user_name' => $user->name,
            'user_email' => $user->email,
            'user_image' => $user->userInformation->user_image,
            'user_birth_date' => $user->userInformation->born_date,
            'user_sex' => (isset($user->userInformation->gender) ? ($user->userInformation->gender == 1 ? 'Laki-Laki' : 'Perempuan') : NULL),
            'user_phone' => $user->userInformation->phone,
            'user_address' => $user->userInformation->address,
            'user_city' => $user->userInformation->city ? $user->userInformation->city->name : NULL,
            'user_state' => $user->userInformation->city ? $user->userInformation->city->province->name : NULL,
            'user_zip_code' => $user->userInformation->postal_code,
            'user_id_number' => $user->userInformation->ktp,
            'user_id_image' => $user->userInformation->user_id_image,
            'user_total_tree' => $userTrees,
            'user_join_date' => $user->created_at->format('Y-m-d h:i:s'),
            'user_balance' => (float) $user->balance->balance,
            'user_total_investment' => (float) $user->orders->sum('buy_price'),
            'user_email_verified' => $user->email_verified_at ? true : false,
            'user_banks' => \DB::table('accounts')
                ->leftJoin('bank_lists', 'accounts.name', '=', 'bank_lists.bank_name')
                ->select([
                    \DB::raw('accounts.token AS user_bank_id'),
                    \DB::raw('COALESCE(bank_lists.full_bank_name, accounts.name) AS user_bank_name'),
                    \DB::raw('accounts.holder_name AS user_bank_account_name'),
                    \DB::raw('accounts.number AS user_bank_account_number')

                ])
                ->where('accounts.user_id', '=', $user->id)
                ->get(),
            'user_data_filled' => $userDataFilled
        ];

        return $data;
    }
}
