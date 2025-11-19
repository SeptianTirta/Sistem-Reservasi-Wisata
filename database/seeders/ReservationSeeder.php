<?php

namespace Database\Seeders;

use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ReservationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Generate 50+ reservasi dengan tanggal dari Jan 2025 - Nov 2025
     */
    public function run(): void
    {
        $customerNames = [
            'Budi Santoso', 'Siti Nurhaliza', 'Edi Prasetyo', 'Ratna Dewi', 'Hendra Wijaya',
            'Susanto Prabowo', 'Yuni Handoko', 'Bambang Irawan', 'Dwi Cahyo', 'Erwin Sutanto',
            'Farah Annisa', 'Gita Wijaya', 'Haris Gunawan', 'Ika Putri', 'Jaka Pratama',
            'Karina Sela', 'Lina Marlina', 'Mita Kusuma', 'Nita Wijaya', 'Omar Faruq',
            'Putri Ayu', 'Quirah Nanda', 'Rina Susanti', 'Sandro Wijaya', 'Tari Gede',
            'Udin Hartono', 'Vina Cahyani', 'Wahyu Kusuma', 'Xena Pratama', 'Yohanes Hartadi',
            'Zahra Ismawati', 'Ahmad Riyadi', 'Bima Kusuma', 'Citra Dewi', 'Dimas Bagus',
            'Elsa Puspita', 'Fajar Santoso', 'Gina Wijaya', 'Hendra Gunawan', 'Irene Kusuma',
            'Joko Widodo', 'Kiki Agustina', 'Lenny Marlina', 'Maulana Arkan', 'Nova Wijaya',
        ];

        $notes = [
            'Paket wisata keluarga',
            'Liburan akhir pekan',
            'Perjalanan bisnis',
            'Honeymoon package',
            'Gathering kantor',
            'Liburan sekolah',
            'Backpacker adventure',
            'Photography tour',
            'Retreat pribadi',
            'Anniversary trip',
            'Liburan panjang',
            'Team building',
            'Hiking expedition',
            'Beach vacation',
            'Mountain retreat',
            null, null, null, // Beberapa dengan notes null
        ];

        $statuses = ['pending', 'confirmed', 'cancelled'];
        $prices = [450000, 500000, 600000, 750000, 300000];

        // Generate reservasi dari Januari 2025 sampai November 2025
        $startDate = Carbon::create(2025, 1, 1);
        $endDate = Carbon::create(2025, 11, 30);
        $currentDate = $startDate->copy();
        $reservationCount = 0;
        $maxReservations = 60;

        while ($currentDate <= $endDate && $reservationCount < $maxReservations) {
            // Random number of reservations per day (0-2)
            $reservationsPerDay = rand(0, 2);

            for ($i = 0; $i < $reservationsPerDay; $i++) {
                if ($reservationCount >= $maxReservations) break;

                $destinationId = rand(1, 5);
                $quantity = rand(1, 6);
                $price = $prices[array_rand($prices)];
                $totalPrice = $price * $quantity;
                $status = $statuses[array_rand($statuses)];

                Reservation::create([
                    'customer_name' => $customerNames[array_rand($customerNames)],
                    'customer_email' => 'customer' . ($reservationCount + 1) . '@email.com',
                    'customer_phone' => '0' . rand(81, 89) . rand(100000000, 999999999),
                    'destination_id' => $destinationId,
                    'reservation_date' => $currentDate->copy()->addDays(rand(0, 30)),
                    'quantity' => $quantity,
                    'total_price' => $totalPrice,
                    'status' => $status,
                    'notes' => $notes[array_rand($notes)],
                    'created_at' => $currentDate->copy()->addHours(rand(0, 23))->addMinutes(rand(0, 59)),
                    'updated_at' => $currentDate->copy()->addHours(rand(0, 23))->addMinutes(rand(0, 59)),
                ]);

                $reservationCount++;
            }

            $currentDate->addDay();
        }

        // Extra: Tambah beberapa reservasi dengan tanggal past yang sudah completed
        $historicalReservations = [
            ['name' => 'Ahmad Gunawan', 'dest' => 1, 'qty' => 2, 'date' => '2025-01-15', 'status' => 'confirmed'],
            ['name' => 'Budiman Sutrisno', 'dest' => 2, 'qty' => 3, 'date' => '2025-02-20', 'status' => 'confirmed'],
            ['name' => 'Cahyono Wibowo', 'dest' => 3, 'qty' => 1, 'date' => '2025-03-10', 'status' => 'confirmed'],
            ['name' => 'Dedi Gunawan', 'dest' => 4, 'qty' => 4, 'date' => '2025-04-25', 'status' => 'confirmed'],
            ['name' => 'Endy Wijaya', 'dest' => 5, 'qty' => 2, 'date' => '2025-05-15', 'status' => 'confirmed'],
            ['name' => 'Fahrur Rozi', 'dest' => 1, 'qty' => 5, 'date' => '2025-06-30', 'status' => 'cancelled'],
            ['name' => 'Galang Permana', 'dest' => 2, 'qty' => 3, 'date' => '2025-07-12', 'status' => 'confirmed'],
            ['name' => 'Hendro Cahyo', 'dest' => 3, 'qty' => 2, 'date' => '2025-08-22', 'status' => 'confirmed'],
            ['name' => 'Indra Kusuma', 'dest' => 4, 'qty' => 1, 'date' => '2025-09-05', 'status' => 'confirmed'],
            ['name' => 'Jendra Wijaya', 'dest' => 5, 'qty' => 4, 'date' => '2025-10-18', 'status' => 'confirmed'],
        ];

        foreach ($historicalReservations as $hist) {
            Reservation::create([
                'customer_name' => $hist['name'],
                'customer_email' => strtolower(str_replace(' ', '.', $hist['name'])) . '@email.com',
                'customer_phone' => '0' . rand(81, 89) . rand(100000000, 999999999),
                'destination_id' => $hist['dest'],
                'reservation_date' => $hist['date'],
                'quantity' => $hist['qty'],
                'total_price' => $prices[$hist['dest'] - 1] * $hist['qty'],
                'status' => $hist['status'],
                'notes' => 'Reservasi historis',
                'created_at' => Carbon::parse($hist['date'])->subDays(rand(5, 20)),
                'updated_at' => Carbon::parse($hist['date'])->subDays(rand(0, 5)),
            ]);
        }
    }
}
