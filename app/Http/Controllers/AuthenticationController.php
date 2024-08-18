<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Models\RewardsModel;
use Illuminate\Http\Request;
use App\Models\ReferralsModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\RewardHistoriesModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AuthenticationController extends Controller
{
    public function login()
    {
        return view('authentication.login');
    }

    public function register()
    {
        return view('authentication.register');
    }

    public function cekRegister(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email||unique:users',
                'password' => 'required|string|min:8',
                'referral_code' => 'required|string|exists:users,referral_code',
            ]);

            if ($validator->fails()) {
                Log::error($validator->errors());
                $this->alert(
                    'Sign Up',
                    'Pastikan benar',
                    'error'
                );

                return redirect()->back();
            }

            DB::beginTransaction();

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'referral_code' => $this->generateUniqueReferralCode(),
            ]);

            if ($user) {
                RewardsModel::create([
                    'user_id' => $user->id,
                    'total_points' => 50
                ]);

                $referrer = User::where('referral_code', $request->referral_code)->first();

                $referral = ReferralsModel::create([
                    'referrer_id' => $referrer->id,
                    'referred_id' => $user->id,
                ]);


                if ($referral) {
                    $addPoint = RewardsModel::where('user_id', $referrer->id)->first();

                    $rewardHistory = RewardHistoriesModel::create([
                        'reward_id' => $addPoint->id,
                        'referral_id' => $referral->id
                    ]);
                    $addPoint->total_points += 50;
                    $addPoint->save();
                }
            }

            DB::commit();
            $credentials = $request->only('email', 'password');

            if (Auth::attempt($credentials)) {
                $this->alert(
                    'Sign in',
                    'Sign in Successfuly',
                    'success'
                );

                return redirect()->intended('reward');
            }

            $this->alert(
                'Sign in Failed',
                'Email atau Password Salah',
                'error'
            );

            return redirect()->back();
        } catch (Exception $e) {
            DB::rollBack();

            Log::error($e->getMessage());
            $this->alert(
                'Sign Up',
                'Sign Up Failed',
                'error'
            );

            return redirect()->back();
        }
    }

    private function generateUniqueReferralCode()
    {
        do {
            $code = strtoupper(substr(md5(mt_rand()), 0, 6));
        } while (User::where('referral_code', $code)->exists());

        return $code;
    }

    public function cekLogin(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
            'password' => 'required'
        ]);

        if ($validated->fails()) {
                $this->alert(
                    'Sign in Failed',
                    'Email atau Password Salah',
                    'error'
                );

            return redirect()->back();
        } else {
            $credentials = $request->only('email', 'password');

            if (Auth::attempt($credentials)) {
                $this->alert(
                    'Sign in',
                    'Sign in Successfuly',
                    'success'
                );

                return redirect()->intended('reward');
            }

            $this->alert(
                'Sign in Failed',
                'Email atau Password Salah',
                'error'
            );

            return redirect()->back();
        }
    }

    public function logout()
    {
        Auth::logout();

        Session::invalidate();

        $this->alert(
            'Logout Successfuly',
            'Redict to login',
            'success'
        );

        return redirect()->route('login');
    }
}
