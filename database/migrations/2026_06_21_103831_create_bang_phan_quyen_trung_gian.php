<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
     public function up(): void
    {
        // Gán vai trò cho người dùng
        Schema::create('nguoi_dung_vai_tro', function (Blueprint $table) {
            $table->id();

            // Người dùng được gán vai trò
            $table->foreignId('nguoi_dung_id')
                ->constrained('users')
                ->cascadeOnDelete();

            // Vai trò được gán cho người dùng
            $table->foreignId('vai_tro_id')
                ->constrained('vai_tro')
                ->cascadeOnDelete();

            // Không cho gán trùng cùng 1 vai trò cho cùng 1 người dùng
            $table->unique(['nguoi_dung_id', 'vai_tro_id']);

            // Thời gian gán vai trò
            $table->timestamp('tao_luc')->useCurrent();
        });

        // Gán quyền cho vai trò
        Schema::create('vai_tro_quyen', function (Blueprint $table) {
            $table->id();

            // Vai trò được gán quyền
            $table->foreignId('vai_tro_id')
                ->constrained('vai_tro')
                ->cascadeOnDelete();

            // Quyền được gán cho vai trò
            $table->foreignId('quyen_id')
                ->constrained('quyen')
                ->cascadeOnDelete();

            // Không cho gán trùng cùng 1 quyền cho cùng 1 vai trò
            $table->unique(['vai_tro_id', 'quyen_id']);

            // Thời gian gán quyền
            $table->timestamp('tao_luc')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vai_tro_quyen');
        Schema::dropIfExists('nguoi_dung_vai_tro');
    }
};
