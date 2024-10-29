<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DropAllTables extends Command
{
    protected $signature = 'db:drop-all-tables';
    protected $description = 'Drop all tables in the database';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        Schema::disableForeignKeyConstraints();

        $databaseName = env('DB_DATABASE');
        $tables = DB::select('SHOW TABLES');

        foreach ($tables as $table) {
            $tableName = "Tables_in_{$databaseName}";
            if (isset($table->$tableName)) {
                Schema::drop($table->$tableName);
            }
        }

        Schema::enableForeignKeyConstraints();

        $this->info('All tables dropped successfully!');
    }
}
