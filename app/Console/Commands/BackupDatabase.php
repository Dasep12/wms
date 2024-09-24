<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;

class BackupDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:backup-database';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Define the filename and path
        $filename = "backup-" . Carbon::now()->format('Y-m-d') . ".sql";
        $path = storage_path("app/backups/{$filename}");

        // Database credentials
        $database = env('DB_DATABASE');
        $username = env('DB_USERNAME');
        $password = env('DB_PASSWORD');
        $host = env('DB_HOST');
        $port = env('DB_PORT');


        // Command to run mysqldump
        $command = "mysqldump --user={$username} --password={$password} --host={$host} --port={$port} {$database} > {$path}";

        // Execute the command
        $result = null;
        $output = null;
        exec($command, $output, $result);

        if ($result === 0) {
            $this->info("Backup completed successfully: {$filename}");
        } else {
            $this->error("Backup failed.");
        }
    }
}
