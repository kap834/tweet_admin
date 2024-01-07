<?php

namespace App\Http\Controllers\Api;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class ApiController extends Controller
{
    public function register(Request $request){
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ];
        User::create($data);
        $user = User::where('email', $request->email)->first();
        return response()->json([
            'user' => $user,
            'token' => $user->createToken(time())->plainTextToken
        ], 200);
    }

    public function login(Request $request){
        $user = User::where('email', $request->email)->first();
        if(isset($user)){
            if(Hash::check($request->password, $user->password)){
                return response()->json([
                    'user' => $user,
                    'token' => $user->createToken(time())->plainTextToken
                ], 200);
            }else{
                return response()->json([
                    'user' => 'null',
                    'token' => 'null'
                ], 200);
            }
        }else{
            return response()->json([
            'user' => 'null',
            'token' => 'null'
        ], 200);
        }
    }
    public function post(Request $request){
        $data = [
            'user_id' => $request->userId,
            'text' => $request->text
        ];
        if($request->hasFile('image')){
            $imgName = uniqid() . $request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('public', $imgName);
            $data['image'] = $imgName ;
        }
        Post::create($data);
        return response()->json([
            'status' => 'success'
        ]);
    }
    public function posts(){
        $posts = Post::select('posts.*', 'users.name as userName' , 'users.image as userImage')
                       ->leftJoin('users','posts.user_id','users.id')
                       ->orderBy('posts.created_at', 'desc')->get();
        return response()->json([
            'posts' => $posts
        ], 200);
    }
}
