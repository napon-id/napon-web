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
use App\Account;
use App\Http\Controllers\Traits\UserData;

class BalanceController extends Controller
{
    use Firebase, UserApi, MidTrans, UserData;

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
                
                $userData = $this->getUserData($user);

                if (!$userData['user_email_verified']) {
                    return response()->json([
                        'request_code' => 200,
                        'result_code' => 16,
                        'message' => 'Verify your email address before continue'
                    ]);
                }

                if (!$userData['user_data_filled']) {
                    return response()->json([
                        'request_code' => 200,
                        'result_code' => 17,
                        'message' => 'Fill all personal information before continue'
                    ]);
                }

                if ($request->has('topup_amount') && $request->topup_amount != '') {
                    if (is_numeric($request->topup_amount) && $request->topup_amount >= 10000) {
                        
                        $unfinishedTopup = Topup::where('status', 1)
                            ->where('user_id', $user->id)
                            ->get()
                            ->count();

                        if ($unfinishedTopup > 0) {
                            return response()->json([
                                'request_code' => 200,
                                'result_code' => 20,
                                'message' => 'Please finish existing topup'
                            ]);
                        } else {
                            $topup = Topup::create([
                                'user_id' => $user->id,
                                'token' => md5('Topup-' . now()),
                                'amount' => $request->topup_amount
                            ]);
                            if (isset($topup)) {
                                //midtrans implementation
                                $res = $this->topUpMidtrans($topup);
    
                                $result = json_decode($res->getBody());

                                $va_number = $result->va_numbers[0]->va_number;

                                $topup->update([
                                    'payment_number' => $va_number
                                ]);
    
                                return response()->json([
                                    'request_code' => 200,
                                    'result_code' => 4,
                                    'top_up_data' => [
                                        'top_up_id' => $topup->token,
                                        'top_up_va_number' => $va_number
                                    ]
                                ]);
    
                            }
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

                $userData = $this->getUserData($user);

                if (!$userData['user_email_verified']) {
                    return response()->json([
                        'request_code' => 200,
                        'result_code' => 16,
                        'message' => 'Verify your email address before continue'
                    ]);
                }

                if (!$userData['user_data_filled']) {
                    return response()->json([
                        'request_code' => 200,
                        'result_code' => 17,
                        'message' => 'Fill all personal information before continue'
                    ]);
                }

                if ($request->has('withdraw_amount') && $request->withdraw_amount != '') {
                    if (is_numeric($request->withdraw_amount) && $request->withdraw_amount >= 10000) {
                        if ($request->withdraw_amount > $user->balance->balance) {
                            return response()->json([
                                'request_code' => 200,
                                'result_code' => 18,
                                'message' => 'Insufficient balance'
                            ]);
                        }

                        if ($request->has('user_bank_id') && $request->user_bank_id != '') {
                            $bank = Account::where('token', $request->user_bank_id)->first();

                            if (isset($bank)) {
                                $unfinishedWithdraw = Withdraw::where('user_id', $user->id)
                                    ->where('status', 1)
                                    ->get();

                                if ($unfinishedWithdraw->count() < 1) {
                                    $withdraw = Withdraw::create([
                                        'user_id' => $user->id,
                                        'token' => md5('Withdraw-' . now()),
                                        'account_id' => $bank->id,
                                        'amount' => $request->withdraw_amount
                                    ]);
    
                                    if ($withdraw) {
                                        return response()->json([
                                            'request_code' => 200,
                                            'result_code' => 4,
                                            'message' => 'Withdraw processed'
                                        ]);
                                    }
                                } else {
                                    return response()->json([
                                        'request_code' => 200,
                                        'result_code' => 20,
                                        'message' => 'There is still pending withdraw'
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
                                'result_code' => 7,
                                'message' => 'Bad request'
                            ]);
                        }
                    } else {
                        return response()->json([
                            'request_code' => 200,
                            'result_code' => 19,
                            'message' => 'Withdraw less than 10000'
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
    }

    /**
     * withdraw list 
     * 
     * @param Illuminate\Http\Request
     * 
     * @return Illuminate\Http\Response
     */
    public function withdrawList(Request $request)
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
                $withdrawCount = $user->withdraws()->get()->count();

                if ($withdrawCount < 1) {
                    return response()->json([
                        'request_code' => 200,
                        'result_code' => 9,
                        'message' => 'There is no data'
                    ]);
                } else {
                    $withdraws = Withdraw::where('user_id', $user->id)
                        ->orderBy('created_at', 'desc')
                        ->get([
                            'token AS withdraw_id',
                            'created_at AS withdraw_date',
                            'status AS withdraw_status',
                            'amount AS withdraw_amount'
                        ]);

                    return response()->json([
                        'request_code' => 200,
                        'result_code' => 4,
                        'withdraw_list' => $withdraws
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
     * topup list
     * 
     * @param Illuminate\Http\Request
     * 
     * @return Illuminate\Http\Response
     */
    public function topupList(Request $request)
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

                $topupCount = $user->topups()->get()->count();

                if ($topupCount < 1) {
                    return response()->json([
                        'request_code' => 200,
                        'result_code' => 9,
                        'message' => 'There is no data'
                    ]);
                } else {
                    $topups = Topup::where('user_id', $user->id)
                        ->orderBy('created_at', 'desc')
                        ->get([
                            'token AS top_up_id',
                            'created_at AS top_up_date',
                            'status AS top_up_status',
                            'amount AS top_up_amount',
                            'payment_number AS top_up_va_number'
                        ]);

                    return response()->json([
                        'request_code' => 200,
                        'result_code' => 4,
                        'top_up_list' => $topups
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
}
