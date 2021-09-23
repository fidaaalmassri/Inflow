<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInfluencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('influences', function (Blueprint $table) {
            $table->id();
            $table->string('fname');
            $table->string('lname');
            $table->string('twitter')->nullable()->unique();
            $table->string('instagram')->nullable()->unique();
            $table->string('snapchat')->nullable()->unique();
            $table->string('youTube')->nullable()->unique();
            $table->string('tikTok')->nullable()->unique();
            $table->string('avater')->nullable();
            $table->enum('gender',['male','female']);
            $table->string('location')->nullable();
            $table->text('description')->nullable();
            $table->date('birthday')->nullable();
            // $table->string('password')->nullable();
            $table->bigInteger('interest_id')->unsigned();
            $table->foreign('interest_id')->references('id')->on('interests')->onDelete('cascade');
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('influences');
    }
}
