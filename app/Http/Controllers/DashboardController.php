<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();
        $contactsCount = $user->contacts()->count();
        $recentContacts = $user->contacts()->orderBy('created_at', 'desc')->take(5)->get();

        return view('dashboard', compact('user', 'contactsCount', 'recentContacts'));
    }
}
