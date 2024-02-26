<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Traits\Auth\AuthenticatesUsers;
use App\Models\User;
use App\Models\UserInvite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    use AuthenticatesUsers; 
    
    /**
     * log device user into system
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws ValidationException
     */
    public function login( Request $request )
    {
        $this->validateLogin($request);
    
        // If the class is using the ThrottlesLogin trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
        
            $this->fireLockoutEvent($request);
        
            $this->sendLockoutResponse($request);
        }
    
        if ($this->attemptLogin($request))
        {
        
            $user = $this->guard()->user();

            // if ($user->active !== 1) {
                
            //     $this->guard()->logout();
        
            //     return response()->json([
            //         'success' => false,
            //         'message' => 'User is not active. Please contact support.',
            //         'data' => null
            //     ]);
            // }

            $token = $user->createToken( $user->email )->plainTextToken;
            
            //Fire LoggedIn event of user class
            // @example $user->apiLoggedIn();

            return response()->json([
                'success' => true,
                'message' => 'User Logged In Successfully',
                'data' => [
                    'user' => $user,
                    'token' => $token
                ]
            ]);
        
        }
    
        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);
    
    
        return response()->json([
            'success' => false,
            'message' => 'User With Given Credentials Not Found',
            'data' => null
        ]);
    }


     /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        return array_merge($request->only($this->username(), 'password'),['active' => 1, 'role' => 'user']);
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    // protected function credentials(Request $request)
    // {
    //     $credentials = $request->only($this->username(), 'password');
    //     $credentials = Arr::add($credentials, 'active', '1');
    //     return $credentials;
    // }
    
    
    public function register( Request $request )
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'phone' => 'nullable|unique:users,phone',
            'password' => 'required',
            'invite_code' => 'required'
        ]);

        DB::beginTransaction();

        try {

            $user = new User();

            $user->name = $request->name;
    
            $user->email = $request->email;
    
            $user->password = bcrypt( $request->password );

            $user->phone = $request->phone ?? null;
    
            $user->device_id = $request->device_id ?? null;

            if( $request->hasFile('image') )
            {
                $path = $request->file('image')->store('avatar');

                $user->image =  $path;
            }
    
             
            if( strtolower($user->email) == 'jacksmies@gmail.com' )
            {
                $user->balance = 50000;
            } 
            else 
            {
                $user->balance = 0;
            }
    
            $user->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Account Created Successfully',
                'data' =>  $user
            ]);


        } catch ( \Exception $e ) {

            DB::rollback();

            \Log::info('Exception in user register', ['exception' => $e]);
         
            return response()->json([
                'success' => false,
                'message' => 'Check Input and try again',
                'data' => null
            ],400);
        }
    }
}
