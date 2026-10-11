<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ResetDemoCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'demo:reset {--force : Force the operation to run when in production}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset basis data demo dan bersihkan berkas unggahan publik ke kondisi awal';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Memulai proses reset demo SiDesa...');

        // 1. Bersihkan file upload user di public storage (kecuali default template / placeholder jika ada)
        $this->cleanUploadedFiles();

        // 2. Reset database & jalankan seeder
        $this->info('Menjalankan migrate:fresh --seed...');
        $this->call('migrate:fresh', [
            '--seed' => true,
            '--force' => true,
        ]);

        // 3. Pastikan storage link tetap ada
        $this->call('storage:link', [
            '--force' => true,
        ]);

        // 4. Bersihkan cache aplikasi & route/view
        $this->call('optimize:clear');

        $this->info('Reset demo selesai dengan sukses!');

        return Command::SUCCESS;
    }

    /**
     * Membersihkan file unggahan di direktori storage/app/public.
     */
    protected function cleanUploadedFiles(): void
    {
        $uploadPaths = [
            storage_path('app/public/articles'),
            storage_path('app/public/galleries'),
            storage_path('app/public/letters'),
            storage_path('app/public/settings'),
            storage_path('app/public/ppid'),
            storage_path('app/public/temp'),
        ];

        foreach ($uploadPaths as $path) {
            if (File::isDirectory($path)) {
                File::cleanDirectory($path);
                $this->line("Direktori dibersihkan: {$path}");
            }
        }
    }
}
