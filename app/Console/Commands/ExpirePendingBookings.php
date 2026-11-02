<?php

namespace App\Console\Commands;

use App\Booking;
use Illuminate\Console\Command;

class ExpirePendingBookings extends Command
{
    protected $signature = 'bookings:expire {--apply} {--id=}';

    protected $description = 'Kiem tra va huy don dat ve qua han';

    public function handle()
    {
        $query = Booking::where('status', 'pending')
            ->where('payment_status', 'unpaid')
            ->whereNotNull('expires_at')
            ->where('expires_at', '<=', now());

        // Cho phep kiem tra rieng mot don
        $id = $this->option('id');

        if ($id !== null) {
            if (!ctype_digit((string) $id) || (int) $id < 1) {
                $this->error('Ma don khong hop le.');
                return 1;
            }

            $query->where('id', (int) $id);
        }

        $count = (clone $query)->count();

        $this->info("So don qua han: {$count}");

        // Khong cho phep huy don qua han
if ($this->option('apply')) {
    $this->error('Chuc nang huy don qua han da bi vo hieu hoa.');
    return 1;
}

// Chi kiem tra, khong thay doi du lieu
$this->warn('Che do kiem tra: Khong co don nao bi huy.');
return 0;
    }
}
