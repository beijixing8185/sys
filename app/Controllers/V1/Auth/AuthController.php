<?php

namespace App\Controllers\V1\Auth;

use App\Models\Admin\AdminSite;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{

    /**
     * 注册获取token
     * 用于后台生成站点信息
     */
    public function register(Request $req){

        $this->validate($req,[
            'name'=>'required|string',
            'password'=>'required|string',
        ]);

        $user = AdminSite::create([
            'site_name'=>$req['name'],
            'email'=>uniqid(),
            'password'=>Hash::make($req['password'])
        ]);

        if($user){
            $token = JWTAuth::fromUser($user);//拿着用户信息给用户分配token
            return response()->json(['access_token'=>$token]);
        }
    }

    /**
     * Get a JWT via given credentials.
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $req)
    {
        $credentials = $req->only(['mobile', 'password']);

        if (! $token = Auth::attempt($credentials)) {
            return response()->json(['code'=>401,'message' => 'Unauthorized','data'=>'']);
        }

        return $this->respondWithToken($token);
    }
    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        Auth::logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(Auth::refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60
        ]);
    }

    /**
     * 获取用户信息
     */
    public function getUserInfo(){
        try{
            //解析传过来的token,因为token是用用户信息生成的,所以里面包含的用户信息
            if(!$user = JWTAuth::parseToken()->authenticate()){
                return $this->response()->error('user not found',404);
            }
        }catch (JWTException $e){
            return $this->response()->error('服务器错误',500);
        }
        return response()->json(compact('user'));
    }
}
