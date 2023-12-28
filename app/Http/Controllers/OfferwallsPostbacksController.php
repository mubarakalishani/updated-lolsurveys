<?php

namespace App\Http\Controllers;

use App\Models\OffersAndSurveysLog;
use App\Models\OfferwallsSetting;
use App\Models\User;
use App\Models\Log;
use Illuminate\Http\Request;

class OfferwallsPostbacksController extends Controller
{
    public function adscendmedia(Request $request)
    {


     /*===================================Ip Whitelist and Check Offerwall Enabled or not==================================*/
        echo $request->ip();
        
        $ipAddress = $request->ip();
        // Get the whitelisted IPs from the database
        $whitelistedIps = json_decode(OfferwallsSetting::where('name', 'adscendmedia_whitelisted_ips')->value('value'), true);

        // Check if $ipAddress is in the whitelisted IPs
        if (in_array($ipAddress, $whitelistedIps)) {
            
        } else {
            // IP address is not whitelisted, take appropriate action
            return "Access Denied! IP address $ipAddress is not whitelisted!";
        }

        if (OfferwallsSetting::where( 'name', 'adscendmedia_status')->value('value') != 1 ) {
            die();
            echo "offerwall is not enabled ";
        }
        
     /*===================================check the hash security==========================================================*/

        $adscendmedia_secret_admin = OfferwallsSetting::where('name', 'adscendmedia_secret' )->value('value');

     /*===================================Do necessary Calculations==========================================================*/

        $userId = User::where('unique_user_id', $request->input('userId'))->value('id');
        $user = User::find($userId);
        $refCommissionPercendtage = OfferwallsSetting::where('name', 'adscendmedia_ref_commission' )->value('value');
        $offerHOld = OfferwallsSetting::where('name', 'adscendmedia_hold' )->value('value');
        $minHoldAmount = OfferwallsSetting::where('name', 'adscendmedia_min_hold_amount' )->value('value');

        $userLevel = $user->value('level');

        if ( $userLevel == 0 ) 
        {
            $finalReward = ( $request->input('payout') / 100 ) * OfferwallsSetting::where('name', 'adscendmedia_starter_cp' )->value('value');
            $addToDiamondLevel = $request->input('payout') - $finalReward;
        }elseif ( $userLevel == 1 )
        {
            $finalReward = ( $request->input('payout') / 100 ) * OfferwallsSetting::where('name', 'adscendmedia_advanced_cp' )->value('value');
            $addToDiamondLevel = $request->input('payout') - $finalReward;
        }elseif ( $userLevel == 2 ) {
            $finalReward = ( $request->input('payout') / 100 ) * OfferwallsSetting::where('name', 'adscendmedia_expert_cp' )->value('value');
            $addToDiamondLevel = $request->input('payout') - $finalReward;
        }else
        {
            Log::create([
                'user_id' => $userId, 
                'description' => 'user level is not specified',
            ]);
        }


        if( $request->has('status') ) 
        {
            if ($request->status == 1 && $offerHOld == 0 ) 
            {
                $finalStatus = 0; //0, completed, 1 on hold / pending, 2 reversed.
            }
            elseif ( $request->status == 1 && $offerHOld == 1 && $minHoldAmount > 0 && $request->input('reward') > 0 && $request->input('payout') > 0 )  //the complete status value of the provider offerwall
            {
                $finalStatus = 1;
            }
            else
            {
                $finalStatus = 2;
            }
        }
        elseif ( $request->input('reward') < 0 || $request->input('payout') < 0)
        {
            $finalStatus = 2;
        }
        else
        {
            if ( $offerHOld == 1 && $minHoldAmount > 0) {
                $finalStatus = 1;
            }
            else
            {
                $finalStatus = 0;
            }
            
        }

        //check if user has any upline
        $uplineId = User::where('id', $userId)->value('upline');
        if( $uplineId != 'none' )
        {
            $upline = User::find($uplineId);
            $uplineCommision = abs($reward) / 100 * $refCommissionPercendtage;
        } else
        {
            $uplineCommision = 0;
        }
        

        //check if transaction found in the database
        $transactionId = $request->input('transactionId');
        $hash = $request->input('hash');
        $transactionIdExists = OffersAndSurveysLog::where('transaction_id', $request->input('transaction_id'))->exists();

     /*===================================Create Log if complete, update if trx found and reversed==========================================================*/
        //if transaction does not exist, create log
         if (!$transactionIdExists) 
         {
            OffersAndSurveysLog::create([
                'user_id' => $userId,
                'provider_name' => 'Adscendmedia',
                'payout' => $request->input('payout'),
                'reward' => $finalReward,   //replace it with the conversion rate of setting
                'upline_commision' => $uplineCommision,
                'transaction_id' => $request->input('transaction_id'),
                'offer_name' => $request->has('offer_name') ? $request->input('offer_name') : null,
                'offer_id' => $request->has('offer_id') ? $request->input('offer_id') : null,
                'hold_time' => 0,
                'instant_credit' => 0,    // 0 no, 1 yes, replace it with the setting value later
                'ip_address' => $request->has('ip_address') ? $request->input('ip_address') : null,
                'status' => $finalStatus,
            ]);

            
            //if finalstatus = 0(completed), reward, and if 2(reversed), deduct the worker and upline and corresponding log
            if ( $finalStatus == 0 ) 
            {
                $user->addWorkerBalance($finalReward);
                Log::create([
                    'user_id' => $userId,
                    'description' => 'reward ' . $finalReward . ' added from Adscendmedia',
                ]);
                if($uplineId != 'none')
                {
                    $uplineToReward = User::find($uplineId);
                    $uplineToReward->addWorkerBalance( $uplineCommision );
                    Log::create([
                        'user_id' => $uplineId, 
                        'description' => 'received referral Commission ' . $uplineCommision . ' from user '. $user->value('username'),
                    ]);
                }
            }
            elseif ( $finalStatus == 2 ) 
            {
                $user->deductWorkerBalance(abs($finalReward));
                Log::create([
                    'user_id' => $userId,
                    'description' =>  $finalReward . ' reversed by Adscendmedia',
                ]);
                if($uplineId != 'none')
                {
                    $uplineToReward = User::find($uplineId);
                    $uplineToReward->deductWorkerBalance( abs($uplineCommision) );
                    Log::create([
                        'user_id' => $uplineId, 
                        'description' => 'deducted chargedback ' . $uplineCommision . ' from user '. $user->value('username'),
                    ]);
                }
            }

         } elseif ( $transactionIdExists && $finalStatus == 2 )
         {
            $offerIdToReverse = OffersAndSurveysLog::where('transaction_id', $transactionId)->value('id');
            $offer = OffersAndSurveysLog::find($offerIdToReverse);
            $userIdToReverse = $offer->value('user_id');
            $user = User::find($userIdToReverse);
            if( $offer->value('status') == 0 )
            {
                $user->deductWorkerBalance(abs($finalReward));
                Log::create([
                    'user_id' => $user->value('id'),
                    'description' =>  $finalReward . ' reversed by Adscendmedia',
                ]);
            }

            if($uplineId != 'none')
                {
                    $uplineToDeduct = User::find($uplineId);
                    $uplineToDeduct->deductWorkerBalance( abs($uplineCommision) );
                    Log::create([
                        'user_id' => $uplineId, 
                        'description' => 'deducted chargedback ' . $uplineCommision . ' from user '. $user->value('username'),
                    ]);
                }
            $offer->update([ 'status' => 2 ]);
         }
         else
         {
            $user->deductWorkerBalance(abs($reward));
         }

    /*===================================reward or deduct user and upline==========================================================*/
        
       


    }

    public function ayetstudios(Request $request)
    {
        

    }

    public function bitlabs(Request $request)
    {
        

    }

    public function cpxresearch(Request $request)
    {
        

    }

    public function excentiv(Request $request)
    {
        

    }

}
