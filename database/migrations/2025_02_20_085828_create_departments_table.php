<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('departments', function (Blueprint $table) {
            $table->id('DepartmentID');
            $table->foreignId('CollegeID')->constrained('colleges', 'CollegeID')->onDelete('cascade');
            $table->string('DepartmentName');
            $table->string('DepartmentCode')->unique();
            $table->boolean('IsActive')->default(1);
            $table->timestamps();

            $table->softDeletes(); // Adds deleted_at column
        });
    }

    public function down()
    {
        Schema::dropIfExists('departments');
    }
};

