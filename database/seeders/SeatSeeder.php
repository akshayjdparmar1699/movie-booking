<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Seat;
use App\Models\Screen;

class SeatSeeder extends Seeder
{
    public function run()
    {
        $screenIds = Screen::pluck('id');
        if ($screenIds->isEmpty()) {
            $this->command->info('No screens found, cannot seed seats.');
            return;
        }

        foreach ($screenIds as $screenId) {
            $rows = ['A', 'B', 'C', 'D'];
            $columns = 5;

            foreach ($rows as $row) {
                for ($i = 1; $i <= $columns; $i++) {
                    Seat::create([
                        'screen_id' => $screenId,
                        'seat_number' => $row . $i,
                    ]);
                    $this->command->info("Created seat {$row}{$i} for screen ID {$screenId}");
                }
            }
        }
    }
}
