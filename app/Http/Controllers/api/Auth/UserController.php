<?php

namespace App\Http\Controllers\api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ApiUserRegisterRequest;
use App\Models\Address;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class UserController extends Controller
{
    public function getLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "username" => "required",
            "password" => "required"
        ], [
            "username.required" => "Tài khoản không được để trống",
            "password.required" => "Mật khẩu không được để trống",
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors(),
            ], ResponseAlias::HTTP_BAD_REQUEST);
        }

        $credentials = request(['username', 'password']);
        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Tài khoản hoặc mật khẩu không đúng.'
            ], ResponseAlias::HTTP_UNAUTHORIZED);
        }

        $user = Auth::user();
        $tokenResult = $user->createToken('Personal Access Token ' . Str::random(10));
        $token = $tokenResult->token;
        $token->save();

        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse($tokenResult->token->expires_at)->toDateTimeString(),
        ]);
    }

    public function getRegister(ApiUserRegisterRequest $request){
        try {
            $newUser = User::query()->create([
                'partner_id' => 1,
                'username' => $request->username,
                'email' => $request->email, 
                'phone' => $request->phone,
                'password' => bcrypt($request->password),
                'uid' => 0
            ]); 
          
            Address::query()->create([
                'user_id' => $newUser->id,
                'name' => $newUser->username,
                'province' => $request->selectedProvince,
                'district' => $request->selectedDistrict,
                'ward' => $request->selectedWard,
                'note' => $request->addressNote,
                'phone' => $newUser->phone,
            ]);
            return response()->json("Đăng kí tài khoản thành công");
        } catch (Exception $th) {
            return response()->json('Có lỗi xảy ra, vui lòng thử lại sau', 500);
        }
    }

    public function getUserInfo(){
        return response()->json(Auth::user());
    }
}
