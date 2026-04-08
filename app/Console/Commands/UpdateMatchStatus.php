<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Matches;

class UpdateMatchStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'matches:update-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update status pertandingan secara otomatis berdasarkan waktu';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Memulai update status pertandingan...');

        try {
            Matches::updateMatchStatuses();
            $this->info('Status pertandingan berhasil diupdate!');
        } catch (\Exception $e) {
            $this->error('Gagal update status: ' . $e->getMessage());
        }
    }
}