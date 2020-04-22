<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->id()->unsigned();
            $table->string('name');
            $table->string('address');
            $table->string('city');
            $table->string('zip');
            $table->string('phone');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->text('settings');
            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('users')
                ->onUpdate('set null')->onDelete('set null');
        });

        // Set default setting value
        DB::table('locations')->update([
            'settings' => json_encode([
                ['key' => 'default_cash_offload', 'value' => 40000]
            ])
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('locations');
    }
}
