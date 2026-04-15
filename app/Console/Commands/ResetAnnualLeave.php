<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ResetAnnualLeave extends Command
{
    protected $signature = 'leave:reset-annual';
    protected $description = 'Reset annual leave for all employees on 1st April';

    public function handle()
    {
        DB::table('employees')->update([
            'total_annual_leave'  => 28,
            'used_annual_leave'   => 0,
            'remain_annual_leave' => 28,
        ]);

        $this->info('Annual leave reset done successfully!');
        return 0;
    }
}