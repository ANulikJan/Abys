<?php

namespace App\Http\Services;

use App\Http\Repositories\MagicLinkRepository;
use App\Http\Repositories\UserRepository;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class LinkService
{

    private $linkRepository;
    private $userRepository;

    public function __construct(MagicLinkRepository $linkRepository, UserRepository $userRepository)
    {
        $this->linkRepository = $linkRepository;
        $this->userRepository = $userRepository;
    }

    public function generateLoginLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $email = $request->email;
        $token = Str::uuid();
        $expiresAt = now()->addMinutes(60);
        $link = url("/api/magic-login/{$token}"); //TODO change to frontend link

        $this->linkRepository->createLinkToken($email, $token, $expiresAt);

        Mail::raw("Click to login: $link", function ($message) use ($email) {
            $message->to($email)
                ->subject('Your Magic Login Link');
        });
    }

    public function checkUser($email)
    {
        return $this->userRepository->fetchUserByEmail($email);
    }

    public function fetchToken($token)
    {
        return $this->linkRepository->fetchToken($token);
    }

    public function deleteToken($token)
    {
        $this->linkRepository->deleteToken($token);
    }

}
