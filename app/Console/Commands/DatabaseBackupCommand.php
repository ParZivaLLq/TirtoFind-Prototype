<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Symfony\Component\Process\Process;

class DatabaseBackupCommand extends Command
{
    protected $signature = 'backup:run {--path= : Output SQL path}';
    protected $description = 'Create a database backup for recovery';

    public function handle(): int
    {
        $connection = config('database.default');
        $database = config("database.connections.{$connection}");
        $path = $this->option('path') ?: storage_path('app/private/backups/tirtofind-' . now()->format('Ymd-His') . '.sql');
        File::ensureDirectoryExists(dirname($path));

        if ($connection === 'sqlite') {
            File::copy($database['database'], $path);
        } elseif ($connection === 'mysql') {
            $process = new Process([
                (string) env('MYSQLDUMP_BINARY', 'mysqldump'),
                '--host=' . $database['host'],
                '--port=' . $database['port'],
                '--user=' . $database['username'],
                '--password=' . $database['password'],
                $database['database'],
            ]);
            $process->run();
            if (!$process->isSuccessful()) {
                $this->error($process->getErrorOutput());
                return self::FAILURE;
            }
            File::put($path, $process->getOutput());
        } else {
            $this->error("Backup belum mendukung driver {$connection}.");
            return self::FAILURE;
        }

        $this->info("Backup dibuat: {$path}");
        return self::SUCCESS;
    }
}
