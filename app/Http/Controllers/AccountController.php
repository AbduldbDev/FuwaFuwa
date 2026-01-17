<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Auth\StoreRequest;
use App\Http\Requests\Auth\UpdateRequest;
use App\Services\AuthService;
use App\Models\User;

class AccountController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function index()
    {
        $items = User::where('status', 'active')->get();

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
        try {
            $this->authService->createAccount($request->validated());

            return redirect()->route('user-management.index')->with('success', 'Account created successfully.');
        } catch (\Throwable $e) {
            return redirect()->back()->withInput()->withErrors([
                'system' => $e->getMessage(),
            ]);
        }
    }

    public function update(UpdateRequest $request, $id)
    {
        try {
            $this->authService->updateAccount($request->validated(), $id);

            return redirect()->route('user-management.index')->with('success', 'Account updated successfully.');
        } catch (\Throwable $e) {
            return redirect()->back()->withInput()->withErrors([
                'system' => $e->getMessage(),
            ]);
        }
    }

    public function delete($id)
    {
        try {
            $this->authService->deleteAccount($id);

            return redirect()->route('user-management.index')->with('success', 'Account Deleted successfully.');
        } catch (\Throwable $e) {
            return redirect()->back()->withInput()->withErrors([
                'system' => $e->getMessage(),
            ]);
        }
    }
}
