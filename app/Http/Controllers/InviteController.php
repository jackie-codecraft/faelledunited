<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class InviteController extends Controller
{
    /** Show the accept-invite / set-password page. */
    public function show(string $token)
    {
        $user = $this->resolveToken($token);

        if (! $user) {
            return view('invite.invalid', ['reason' => 'not_found']);
        }

        if ($user->invite_accepted_at) {
            return view('invite.invalid', ['reason' => 'already_accepted']);
        }

        if ($user->isInviteExpired()) {
            return view('invite.invalid', ['reason' => 'expired']);
        }

        return view('invite.accept', compact('user', 'token'));
    }

    /** Handle password submission and activate the account. */
    public function accept(Request $request, string $token)
    {
        $user = $this->resolveToken($token);

        if (! $user || $user->invite_accepted_at || $user->isInviteExpired()) {
            return redirect()->route('invite.show', $token);
        }

        $request->validate([
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        $user->update([
            'password'           => Hash::make($request->password),
            'invite_accepted_at' => now(),
            'invite_token'       => null,
        ]);

        Auth::login($user);

        return redirect('/admin');
    }

    private function resolveToken(string $token): ?User
    {
        return User::where('invite_token', $token)->first();
    }
}
