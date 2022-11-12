<?php

namespace App\Http\Controllers\api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ApiUserRegisterRequest;
use App\Http\Requests\UserAddressRequest;
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
                'region_id' => $request->region_id,
                'is_default' => 1,
                'phone' => $newUser->phone,
            ]);
            return response()->json("Đăng kí tài khoản thành công");
        } catch (Exception $th) {
            return response()->json('Có lỗi xảy ra, vui lòng thử lại sau', 500);
        }
    }

    public function getUserInfo(){
    
        $address = Address::where('user_id',Auth::id())->first();
        Auth::user()->address = $address->province;
        Auth::user()->name = $address->name;
        return response()->json(Auth::user());
    }

    public function UpdateUser(Request $request){
        try {
             User::where('id',Auth::id())->update([
                'username' => $request->username,
                'email' => $request->email, 
                'phone' => $request->phone,
             ]);
          
             Address::where('id',Auth::id())->update([
                'address' => $request->address,
             ]);
            return response()->json("Chỉnh sửa thành công !");
        } catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                "message" => $th->getMessage()
            ]);
        }
    }

    public function newAddress(UserAddressRequest $request){
        try{
            $isDefault = null;
            $user = User::query()->find(Auth::id());
            if($request->is_default){
                $isDefault = 1;
                $resetCurrentDefault = Address::where('user_id', Auth::id())->where('is_default', 1)->update([
                    "is_default" => null
                ]);
            }
            Address::create([
                "user_id" => $user->id,
                "name"    => $user->username,
                "province" => $request->selectedProvince,
                "district" => $request->selectedDistrict,
                "ward"    => $request->selectedWard,
                "note"      => $request->addressNote,
                "phone"     => $user->phone,
                "region_id" => $request->region_id,
                "is_default" => $isDefault,
            ]);
            return response()->json("Thêm mới địa chỉ thành công!");
        } catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                "message" => $th->getMessage()
            ]);
        }

    }
}
