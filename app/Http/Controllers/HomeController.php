<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use App\Models\AccessCard;
use Illuminate\Support\Facades\DB;
use App\Models\Peminjaman;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
  
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(): View
    {
        return view('home');
    }

  
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function adminHome(): View
    {
          $totalUsers = User::count();
        $totalAccessCards = AccessCard::count();
        $availableAccessCards = AccessCard::where('status', 'tersedia')->count();
        $borrowedAccessCards = AccessCard::where('status', 'dipinjam')->count();
        $goneAccessCard = AccessCard::where('status', 'hilang')->count();
        $totalPeminjaman = Peminjaman::count();
        $completedPeminjaman = Peminjaman::where('status', 'completed')->count();

        return view('adminHome', compact(
            'totalUsers',
            'totalAccessCards',
            'availableAccessCards',
            'borrowedAccessCards',
            'totalPeminjaman',
            'completedPeminjaman',
            'goneAccessCard'
        ));
    }
  
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function managerHome(): View
    {
        return view('managerHome');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function hcHome(): View
    {
              $totalUsers = User::count();
        $totalAccessCards = AccessCard::count();
        $availableAccessCards = AccessCard::where('status', 'tersedia')->count();
        $borrowedAccessCards = AccessCard::where('status', 'dipinjam')->count();
        $goneAccessCard = AccessCard::where('status', 'hilang')->count();
        $totalPeminjaman = Peminjaman::count();
        $completedPeminjaman = Peminjaman::where('status', 'completed')->count();
        $latestPeminjaman = Peminjaman::orderBy('created_at', 'desc')->take(5)->get();

        return view('hc.home', compact(
            'totalUsers',
            'totalAccessCards',
            'availableAccessCards',
            'borrowedAccessCards',
            'totalPeminjaman',
            'completedPeminjaman',
            'goneAccessCard', 
            'latestPeminjaman'
        ));
    }

    public function sekreHome(): View
    {
              $totalUsers = User::count();
        $totalAccessCards = AccessCard::count();
        $availableAccessCards = AccessCard::where('status', 'tersedia')->count();
        $borrowedAccessCards = AccessCard::where('status', 'dipinjam')->count();
        $goneAccessCard = AccessCard::where('status', 'hilang')->count();
        $totalPeminjaman = Peminjaman::count();
        $completedPeminjaman = Peminjaman::where('status', 'completed')->count();
        $latestPeminjaman = Peminjaman::orderBy('created_at', 'desc')->take(5)->get();

        return view('sekretaris.home', compact(
            'totalUsers',
            'totalAccessCards',
            'availableAccessCards',
            'borrowedAccessCards',
            'totalPeminjaman',
            'completedPeminjaman',
            'goneAccessCard',
            'latestPeminjaman'
        ));
    }
}
