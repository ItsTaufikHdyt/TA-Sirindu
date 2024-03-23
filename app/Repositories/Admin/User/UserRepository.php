<?php

namespace App\Repositories\Admin\User;

use App\Repositories\Admin\Core\User\UserRepositoryInterface;
use App\Models\User;

class UserRepository implements UserRepositoryInterface
{
    protected $user;

    public function __contruct(
        user $user
    ) {
        $this->user = $user;
    }

    public function storeUser($request)
    {
        $user = User::create([

            'name' => $request->name,
            'email' => $request->email,
            'type' => $request->type,
            'password' => bcrypt('sirindu123'),
        ]);
    }
    public function updateUser($request, $id)
    {
        $user = User::find($id);
        if ($request->password == null) {
            if ($request->id_kecx == null) {
                $user->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'type' => $request->type,
                ]);
            } else {
                $user->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'type' => $request->type,
                ]);
            }
        }else{
            if ($request->id_kecx == null) {
                $user->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'type' => $request->type,
                    'password' => bcrypt($request->password),
                ]);
            } else {
                $user->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'type' => $request->type,
                    'password' => bcrypt($request->password),
                ]);
            }
        }
        
    }
    public function destroyUser($id)
    {
        $user = User::find($id);
        $user->delete();
    }
}
