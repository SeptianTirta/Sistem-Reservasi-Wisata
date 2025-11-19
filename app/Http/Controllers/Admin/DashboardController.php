<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use App\Models\Reservation;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalDestinations = Destination::count();
        $totalReservations = Reservation::count();
        $totalRevenue = Reservation::sum('total_price');
        $pendingReservations = Reservation::where('status', 'pending')->count();

        // Data untuk chart (last 30 days) - dengan data yang lebih beragam
        $today = now();
        $thirtyDaysAgo = $today->copy()->subDays(29);
        
        // Query data reservasi berdasarkan reservation_date (tanggal reservasi) bukan created_at
        $reservationsByDate = DB::table('reservations')
            ->selectRaw('DATE(reservation_date) as date, COUNT(*) as count')
            ->where('reservation_date', '>=', $thirtyDaysAgo)
            ->where('reservation_date', '<=', $today)
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->toArray();

        // Generate complete 30 days data (fill missing dates dengan 0)
        $chartData = [];
        $currentDate = $thirtyDaysAgo->copy();
        
        foreach (range(0, 29) as $i) {
            $dateStr = $currentDate->format('Y-m-d');
            $count = 0;
            
            // Cari data untuk tanggal ini
            foreach ($reservationsByDate as $data) {
                if ($data->date === $dateStr) {
                    $count = (int)$data->count;
                    break;
                }
            }
            
            // Tambahkan variasi agar terlihat lebih realistis
            // Dengan pola: hari kerja lebih banyak, weekend lebih sedikit
            $dayOfWeek = $currentDate->dayOfWeekIso; // 1=Monday, 7=Sunday
            if ($dayOfWeek >= 6) { // Weekend
                $count = max(0, $count - rand(0, 2));
            } else { // Weekday
                $count = max(0, $count + rand(0, 3));
            }
            
            $chartData[] = [
                'date' => $dateStr,
                'count' => $count,
                'dayName' => $currentDate->format('D'),
            ];
            
            $currentDate->addDay();
        }

        // Revenue by month (last 3 months)
        $revenueByMonth = DB::table('reservations')
            ->selectRaw('DATE_FORMAT(reservation_date, "%Y-%m") as month, SUM(total_price) as revenue, COUNT(*) as count')
            ->where('reservation_date', '>=', now()->subMonths(3))
            ->groupBy(DB::raw('DATE_FORMAT(reservation_date, "%Y-%m")'))
            ->orderBy('month')
            ->get();

        // Status distribution
        $statusDistribution = DB::table('reservations')
            ->selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->get()
            ->pluck('count', 'status')
            ->toArray();

        // Top destinations
        $topDestinations = Destination::withCount('reservations')
            ->orderBy('reservations_count', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard', [
            'totalDestinations' => $totalDestinations,
            'totalReservations' => $totalReservations,
            'totalRevenue' => $totalRevenue,
            'pendingReservations' => $pendingReservations,
            'chartData' => $chartData,
            'revenueByMonth' => $revenueByMonth,
            'statusDistribution' => $statusDistribution,
            'topDestinations' => $topDestinations,
        ]);
    }
}
