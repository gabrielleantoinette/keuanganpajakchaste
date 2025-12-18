<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Cek apakah kolom user_id sudah ada
        if (Schema::hasColumn('expenses', 'user_id')) {
            // Jika sudah ada, cek apakah ada foreign key
            $foreignKeys = DB::select("
                SELECT CONSTRAINT_NAME 
                FROM information_schema.KEY_COLUMN_USAGE 
                WHERE TABLE_SCHEMA = DATABASE() 
                AND TABLE_NAME = 'expenses' 
                AND COLUMN_NAME = 'user_id'
                AND CONSTRAINT_NAME != 'PRIMARY'
            ");
            
            // Hapus foreign key jika ada tapi belum benar
            if (count($foreignKeys) > 0) {
                foreach ($foreignKeys as $key) {
                    try {
                        Schema::table('expenses', function (Blueprint $table) use ($key) {
                            $table->dropForeign([$key->CONSTRAINT_NAME]);
                        });
                    } catch (\Exception $e) {
                        // Ignore jika gagal
                    }
                }
            }
            
            // Hapus kolom yang ada
            Schema::table('expenses', function (Blueprint $table) {
                $table->dropColumn('user_id');
            });
        }
        
        // Hapus semua data expenses yang sudah ada (karena tidak ada user_id yang valid)
        DB::table('expenses')->truncate();
        
        // Tambahkan kolom dan foreign key yang benar
        Schema::table('expenses', function (Blueprint $table) {
            $table->foreignId('user_id')->after('id')->constrained()->onDelete('cascade');
        });
    }

    public function down(): void
    {
        if (Schema::hasColumn('expenses', 'user_id')) {
            Schema::table('expenses', function (Blueprint $table) {
                $table->dropForeign(['user_id']);
                $table->dropColumn('user_id');
            });
        }
    }
};
