<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\VerificationCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    
    public function login( Request $request )
    {
        $request->validate([
            'name' => 'required',
            'provider_id' => 'required',
            'provider' => 'required'
        ]);


        $user = User::where('provider_id', $request->provider_id)->first();

        DB::beginTransaction();
        try 
        {
            if( !$user )
            {
                $user = new User;
                $user->name = $request->name;
                $user->email = $request->email ?? null;
                $user->phone = $request->phone ?? null;
                $user->provider_id = $request->provider_id;
                $user->provider = $request->provider;
                $user->device_id = $request->device_id ?? null;
                $user->image = $request->photoURL ?? null;
               
                $user->save();
    
            }
            else if( $request->device_id )
            {
                if( !$user->active ) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Account is inactive/disabled',
                        'data' => null
                    ],400);
                }
                $user->device_id = $request->device_id;
                $user->save();
            }
    
            $token = $user->createToken($user->provider_id)->plainTextToken;
    
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'User Logged In Successfully',
                'data' => [
                    'user' => $user,
                    'token' => $token
                ]
            ]);
        } catch( \Exception $e ) {

            DB::rollback();
         
            return response()->json([
                'success' => false,
                'message' => 'Check Input and try again',
                'data' => null
            ],400);
        }
       
    }

    public function logout()
    {
        $user = auth()->guard('sanctum')->user();

        $user->tokens()->where( 'id', $user->currentAccessToken()->id )->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'User Logged Out Successfully',
            'data' => null
        ]);
    }
    

	public function sendResetOtpEmail(Request $request)
	{
		$request->validate(['email' => 'required|email']);
		try 
        {
		
            $user = User::where('email', $request->email)->first();
            
            if( !$user )
            {
                return response()->json(['success' => false, 'message' => 'user with given email not found','data' => null],400);
            }
            // We will send the password reset link to this user. Once we have attempted
            // to send the link, we will examine the response then see the message we
            // need to show to the user. Finally, we'll send out a proper response.
            $verificationCode =$this->generateOtp($user);

            if(  $verificationCode  )
            {
                Mail::send('mail.reset_otp', ['otp' => $verificationCode->otp, 'name' => $user->name],
                function ($message) use ($user)
                {
                    $message
                        ->to($user->email)
                        ->subject('Password Reset OTP');
                });
                return response()->json(['success' => true, 'message' => 'we have sent a password rest OTP to your email, you can use this otp to reset your password', 'data' => null]);
            }

        } catch ( \Exception $e) {
            Log::info('Reset password otp exception', ['Exception' => $e]);
        }
        
        return response()->json(['success' => false, 'message' => 'something went wrong please try again','data' => null],500);
	}


    public function generateOtp($user)
    {
        # User Does not Have Any Existing OTP
        $verificationCode = VerificationCode::where('user_id', $user->id)->latest()->first();

        $now = Carbon::now();

        if($verificationCode && $now->isBefore($verificationCode->expire_at)){
            return $verificationCode;
        }

        // Create a New OTP
        return VerificationCode::create([
            'user_id' => $user->id,
            'otp' => rand(123456, 999999),
            // 'otp' => 123456,
            'expire_at' => Carbon::now()->addMinutes(5)
        ]);
    }

    public function verifyOtp(Request $request)
    {
        #Validation
        $request->validate([
            'otp' => 'required',
            'email' => 'required|email'
        ]);

        $user = User::where('email', $request->email)->first();
            
        if( !$user )
        {
            return response()->json(['success' => false, 'message' => 'user with given email not found','data' => null],400);
        }
       
        #Validation Logic
        $verificationCode   = VerificationCode::where('user_id', $user->id)->where('otp', $request->otp)->first();
       
        $now = Carbon::now();

        if (!$verificationCode) 
        {
            return response()->json([
                'message' => 'Your OTP is not correct',
                'data' => null,
                'success' => false
            ], 422);
        }
        else if($verificationCode && $now->isAfter($verificationCode->expire_at))
        {
          return response()->json([
            'message' => 'Your OTP has been expired',
            'data' => null,
            'success' => false
          ], 422);
        }
      
        return response()->json([ 'success' => true, 'data' => $user,'message' => 'Otp verified successfully']);
    }


    public function resetPassword( Request $request )
    {
        $request->validate([
            'password' => 'required|confirmed|min:6',
            'email' => 'required|email'
        ]);

        $user = User::where('email', $request->email)->first();
            
        if( !$user )
        {
            return response()->json(['success' => false, 'message' => 'user with given email not found','data' => null],400);
        }

        $user->password = bcrypt($request->password);

        $user->update();

        return response()->json([
            'success' => true,
            'data' => null,
            'message' => 'password updated successfully'
        ]);
    }

    public function changePassword(Request $request)
    {
        $user = auth()->guard('sanctum')->user();
     
        if (is_null($user)) {
            return response()->json(
                [
                    'success' => false,
                    'data' => null,
                    'message' => 'User does not exist'
                ],
                404
            );
        }
        
        if (!Hash::check($request['old_password'], $user->password)) {
            return response()->json(
                [
                    'success' => false,
                    'data' => null,
                    'message' => 'Old password does not match'
                ],
                400
            );
        }
        
        if ($request['new_password'] !== $request['confirm_password']) {
            return response()->json(
                [

                    'success' => false,
                    'data' => null,
                    'message' => 'New password and Confirm password do not match'
                ],
                400
            );
        }
        
        DB::beginTransaction();
        
        try {
            $user->password = Hash::make($request['new_password']);
            $user->save();
            DB::commit();
        
            return response()->json(
                [
                    'success' => true,
                    'data' => $user,
                    'message' => 'Password updated successfully'
                ],
                200
            );
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json(
                [
                    'status' => 0,
                    'message' => 'Internal server error',
                    'error_message' => $th->getMessage()
                ],
                500
            );
        }
    }
    
}
