<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // RLS用のロールがあれば削除
        $r = DB::select('SELECT * FROM pg_roles WHERE rolname = \'tenant\'');
        if (count($r) > 0) {
            DB::statement('REVOKE ALL ON ALL TABLES IN SCHEMA public FROM tenant');
            DB::statement('REVOKE ALL ON ALL SEQUENCES IN SCHEMA public FROM tenant');
            DB::statement('REVOKE USAGE ON SCHEMA public FROM tenant');
            DB::statement('DROP ROLE tenant');
        }
        
        $sqls = file_get_contents('init.sql');
        array_map(function ($sql) {
            DB::statement($sql);
        }, explode(';', $sqls));
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
