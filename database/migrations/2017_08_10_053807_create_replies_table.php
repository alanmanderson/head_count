<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRepliesTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('replies', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id', false, true);
            $table->integer('occurrence_id', false, true);
            $table->decimal('likelihood', 2, 1);
            $table->timestamps();
            $table->unique(['user_id', 'occurrence_id']);
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('occurrence_id')->references('id')->on('occurrences');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('replies');
    }
}
