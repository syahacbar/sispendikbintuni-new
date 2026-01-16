<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Carbon\Carbon;

class VerifySpecificEmailsSeeder extends Seeder
{
    /**
     * List email yang auto-verified (tidak perlu verifikasi)
     */
    protected $autoVerifiedEmails = [
        'superadmin@sispendikbintuni.cloud',
        'admindinas@sispendikbintuni.cloud',
        '60403663@sispendikbintuni.cloud',
        '60401962@sispendikbintuni.cloud',
        '60401955@sispendikbintuni.cloud',
        '60401950@sispendikbintuni.cloud',
        '60401956@sispendikbintuni.cloud',
        '60401954@sispendikbintuni.cloud',
        '60401938@sispendikbintuni.cloud',
        '60401880@sispendikbintuni.cloud',
        '60401899@sispendikbintuni.cloud',
        '60401900@sispendikbintuni.cloud',
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $updated = User::whereIn('email', $this->autoVerifiedEmails)
            ->whereNull('email_verified_at')
            ->update([
                'email_verified_at' => Carbon::now()
            ]);

        $this->command->info("✅ {$updated} email akun telah diverifikasi otomatis.");

        // Info akun yang sudah verified sebelumnya
        $alreadyVerified = User::whereIn('email', $this->autoVerifiedEmails)
            ->whereNotNull('email_verified_at')
            ->count();

        $this->command->info("ℹ️  {$alreadyVerified} email sudah terverifikasi sebelumnya.");
    }
}
