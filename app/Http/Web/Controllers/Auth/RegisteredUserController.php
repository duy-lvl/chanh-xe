<?php

namespace App\Http\Web\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rules;
use App\Http\Web\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Web\Requests\Auth\RegisterRequest;
use Domain\Auth\Actions\Write\RegisterNewUser;
use Domain\Auth\DataTransferObjects\NewUserData;

class RegisteredUserController extends Controller
{
    public function __construct(
        private readonly RegisterNewUser $action
    )
    {}

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(RegisterRequest $request): Response
    {
        $validated = $request->validated();

        $payload = new NewUserData(
            name: $validated->name,
            email: $validated->email,
            password: $validated->password
        );

        $user = $this->action->handle($payload);

        Auth::login($user);

        return response()->noContent();
    }
}
