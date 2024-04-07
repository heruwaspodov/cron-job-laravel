<?php

namespace App\Http\Controllers;

use App\Models\DailyRecord;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redis;

/**
 *
 */
class UserController extends Controller
{
    /**
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function index(): Application|Factory|View|\Illuminate\Foundation\Application
    {
        $users = User::all();
        $totalMale = Redis::get('male.count');
        $totalFemale = Redis::get('female.count');
        $dailyReports = DailyRecord::all();

        return view('welcome')
            ->with('users', $users)
            ->with('totalMale', $totalMale)
            ->with('totalFemale', $totalFemale)
            ->with('dailyReports', $dailyReports);
    }

    /**
     * @param User $user
     * @return RedirectResponse
     */
    public function destroy(User $user): RedirectResponse
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User successfully deleted.');
    }
}
