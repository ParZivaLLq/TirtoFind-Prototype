<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class DatabaseRestoreCommand extends Command
{
    protected $signature = 'backup:restore {file : SQL backup file} {--force : Skip confirmation}';
    protected $description = 'Restore the database from a backup';

    public function handle(): int
    {
        $file = (string) $this->argument('file');
        if (!is_file($file)) {
            $this->error("File backup tidak ditemukan: {$file}");
            return self::FAILURE;
        }

        if (!$this->option('force') && !$this->confirm('Restore akan menimpa data saat ini. Lanjutkan?')) {
            return self::INVALID;
        }

        $connection = config('database.default');
        $database = config("database.connections.{$connection}");
        if ($connection !== 'mysql') {
            $this->error('Restore command saat ini mendukung driver mysql. Untuk sqlite, ganti file database secara manual setelah backup diverifikasi.');
            return self::FAILURE;
        }

        $process = new Process([
            (string) env('MYSQL_BINARY', 'mysql'),
            '--host=' . $database['host'],
            '--port=' . $database['port'],
            '--user=' . $database['username'],
            '--password=' . $database['password'],
            $database['database'],
        ]);
        $process->setInput(file_get_contents($file));
        $process->run();

        if (!$process->isSuccessful()) {
            $this->error($process->getErrorOutput());
            return self::FAILURE;
        }

        $this->info('Database berhasil dipulihkan.');
        return self::SUCCESS;
    }
}
