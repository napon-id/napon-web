<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\UserApi;
use App\User;
use App\Topup;
use App\Withdraw;
use App\Http\Controllers\Traits\Firebase;
use App\Http\Controllers\Traits\MidTrans;

class BalanceController extends Controller
{
    use Firebase, UserApi, MidTrans;

    /**
     * add deposit to user balance
     * 
     * @param Illuminate\Http\Request
     * 
     * @return Illuminate\Http\Response
     */
    public function topup(Request $request)
    {
        if ($request->has('user_key') && $request->user_key != '') {
            $email = $this->getUserEmail((string) $request->user_key);

            if ($email == '') {
                return response()->json([
                    'request_code' => 200,
                    'result_code' => 2,
                    'message' => 'User not found'
                ]);
            } else {
                $user = User::where('email', $email)->first();

                if ($request->has('topup_amount') && $request->topup_amount != '') {
                    if (is_numeric($request->topup_amount) && $request->topup_amount >= 10000) {
                        $topup = Topup::create([
                            'user_id' => $user->id,
                            'token' => md5('Topup-' . now()),
                            'amount' => $request->topup_amount
                        ]);

                        if ($topup) {
                            //midtrans implementation
                            $res = $this->topUpMidtrans($topup);

                            $result = json_decode($res->getBody());

                            return response()->json([
                                'request_code' => 200,
                                'result_code' => 4,
                                'transaction_data' => [
                                    'transaction_number' => 'NAPON-' . sprintf("%'03d", $topup->id),
                                    'transaction_key' => $topup->token,
                                    'transaction_total_payment' => (double) $topup->amount,
                                    'transaction_va_number' => $result->va_numbers[0]->va_number
                                ]
                            ]);
                        }


                    } else {
                        return response()->json([
                            'request_code' => 200,
                            'result_code' => 7,
                            'message' => 'Bad request'
                        ]);
                    }
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
                'message' => 'User not found'
            ]);
        }
    }

    /**
     * withdraw process from user balance
     * 
     * @param Illuminate\Http\Request
     * 
     * @return Illuminate\Http\Response
     */
    public function withdraw(Request $request)
    {

    }
}
