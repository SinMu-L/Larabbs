<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Handlers\ImageUploadHandler;

class UsersController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth',['except'=>'show']);
    }

    public function show(User $user)
    {
        return view('users.show',compact('user'));
    }

    public function edit(User $user)
    {
        $this->authorize('update',$user);
        return view('users.edit',compact('user'));
    }

    public function update(UserRequest $request, User $user, ImageUploadHandler $uploader)
    {
        // 这里的$request->avatar 是一个对象

        //  Illuminate\Http\UploadedFile {#1309 ▼
        //     -test: false
        //     -originalName: "avatar.jpg"
        //     -mimeType: "image/jpeg"
        //     -error: 0
        //     #hashName: null
        //     path: "D:\xampp\tmp"
        //     filename: "phpFE5B.tmp"
        //     basename: "phpFE5B.tmp"
        //     pathname: "D:\xampp\tmp\phpFE5B.tmp"
        //     extension: "tmp"
        //     realPath: "D:\xampp\tmp\phpFE5B.tmp"
        //     aTime: 2022-03-04 15:36:20
        //     mTime: 2022-03-04 15:36:20
        //     cTime: 2022-03-04 15:36:20
        //     inode: 1125899907389898
        //     size: 34690
        //     perms: 0100666
        //     owner: 0
        //     group: 0
        //     type: "file"
        //     writable: true
        //     readable: true
        //     executable: false
        //     file: true
        //     dir: false
        //     link: false
        //     linkTarget: "D:\xampp\tmp\phpFE5B.tmp"
        //     }
        $data = $request->all();
        if($request->avatar){
            $result = $uploader->save($request->avatar,'avatars',$user->id,416);
            if($result) {
                $data['avatar'] = $result['path'];
            }
        }
        $user->update($data);
        return redirect()->route('users.show',$user->id)->with('success','个人资料更新成功!');
    }
}
