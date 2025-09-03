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
    $latestPeminjaman = Peminjaman::orderBy('updated_at', 'desc')->take(5)->get();

    // 🔹 Statistik per bulan
    $year = Carbon::now()->year;
    $months = collect(range(1, 12))->map(function ($m) {
        return Carbon::create()->month($m)->translatedFormat('F');
    });

    // Ambil data per status
    $approvedPerMonth = Peminjaman::selectRaw('MONTH(tanggal_peminjaman) as bulan, COUNT(*) as total')
        ->where('status', 'approved')
        ->whereYear('tanggal_peminjaman', $year)
        ->groupBy('bulan')
        ->pluck('total', 'bulan');

    $pendingPerMonth = Peminjaman::selectRaw('MONTH(tanggal_peminjaman) as bulan, COUNT(*) as total')
        ->where('status', 'pending')
        ->whereYear('tanggal_peminjaman', $year)
        ->groupBy('bulan')
        ->pluck('total', 'bulan');

    $rejectedPerMonth = Peminjaman::selectRaw('MONTH(tanggal_peminjaman) as bulan, COUNT(*) as total')
        ->where('status', 'rejected')
        ->whereYear('tanggal_peminjaman', $year)
        ->groupBy('bulan')
        ->pluck('total', 'bulan');
    $completedPerMonth = Peminjaman::selectRaw('MONTH(tanggal_peminjaman) as bulan, COUNT(*) as total')
        ->where('status', 'completed')
        ->whereYear('tanggal_peminjaman', $year)
        ->groupBy('bulan')
        ->pluck('total', 'bulan');

    // Siapkan data chart (isi 0 jika tidak ada data di bulan tsb)
    $approvedData = [];
    $pendingData = [];
    $rejectedData = [];
    $completedData = [];

    foreach (range(1, 12) as $bulan) {
        $approvedData[] = $approvedPerMonth[$bulan] ?? 0;
        $pendingData[] = $pendingPerMonth[$bulan] ?? 0;
        $rejectedData[] = $rejectedPerMonth[$bulan] ?? 0;
        $completedData[] = $completedPerMonth[$bulan] ?? 0;
    }

    return view('adminHome', compact(
        'totalUsers',
        'totalAccessCards',
        'availableAccessCards',
        'borrowedAccessCards',
        'goneAccessCard',
        'totalPeminjaman',
        'completedPeminjaman',
        'latestPeminjaman',
        'months',
        'approvedData',
        'pendingData',
        'rejectedData',
        'completedData'
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
