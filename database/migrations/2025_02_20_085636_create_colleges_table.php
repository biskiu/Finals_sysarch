<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('colleges', function (Blueprint $table) {
            $table->id('CollegeID');
            $table->string('CollegeName');
            $table->string('CollegeCode')->unique();
            $table->boolean('IsActive')->default(1);
            $table->timestamps();

            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('colleges');
    }
};
