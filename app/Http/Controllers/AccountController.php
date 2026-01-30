<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Auth\StoreRequest;
use App\Http\Requests\Auth\UpdateRequest;
use App\Services\UserService;
use App\Models\User;

class AccountController extends Controller
{
    protected UserService $userService;


    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        if (!user()->canAccess('User', 'read')) {
            abort(403, 'Unauthorized');
        }

        $items = User::get();

        $counts = User::selectRaw("
            COUNT(*) as total,
            SUM(status = 'active') as active,
            SUM(status = 'inactive') as inactive
        ")->first();

        return view('Pages/users', [
            'items'    => $items,
            'active'   => $counts->active,
            'inactive' => $counts->inactive,
            'total'    => $counts->total,
        ]);
    }

    public function store(StoreRequest $request)
    {
        if (!user()->canAccess('User', 'write')) {
            abort(403, 'Unauthorized');
        }

        try {
            $this->userService->createAccount($request->validated());

            return redirect()->route('user-management.index')->with('success', 'Account created successfully.');
        } catch (\Throwable $e) {
            return redirect()->back()->withInput()->withErrors([
                'system' => $e->getMessage(),
            ]);
        }
    }

    public function update(UpdateRequest $request, User $user)
    {
        if (!user()->canAccess('User', 'write')) {
            abort(403, 'Unauthorized');
        }

        try {
            $this->userService->updateAccount($request->validated(), $user);


            return redirect()->route('user-management.index')->with('success', 'Account updated successfully.');
        } catch (\Throwable $e) {
            return redirect()->back()->withInput()->withErrors([
                'system' => $e->getMessage(),
            ]);
        }
    }

    public function delete($id)
    {
        if (!user()->canAccess('User', 'write')) {
            abort(403, 'Unauthorized');
        }

        try {
            $this->userService->deleteAccount($id);

            return redirect()->route('user-management.index')->with('success', 'Account Deleted successfully.');
        } catch (\Throwable $e) {
            return redirect()->back()->withInput()->withErrors([
                'system' => $e->getMessage(),
            ]);
        }
    }
}
