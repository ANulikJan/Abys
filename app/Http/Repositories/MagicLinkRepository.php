<?php

namespace App\Http\Repositories;

use Illuminate\Support\Facades\DB;

class MagicLinkRepository
{

    public function createLinkToken($email, $token, $expiresAt)
    {
        DB::table('magic_links')->insert([
            'email' => $email,
            'token' => $token,
            'expires_at' => $expiresAt,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }

    public function fetchTokenByEmail($email)
    {
        return DB::table('magic_links')->where('email', $email)->first();
    }

    public function fetchToken($token)
    {
        return DB::table('magic_links')->where('token', $token)->first();
    }

    public function deleteToken($token)
    {
        return DB::table('magic_links')->where('token', $token)->delete();
    }

}
