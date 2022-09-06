<?php

use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            // user_id
            // $table->foreignIdFor(User::class)
            //       ->constrained()
            //       ->cascadeOnUpdate()
            //       ->cascadeOnDelete();
            $table->foreignId('user_id')
                    ->nullable()
                    ->constrained('users')
                    ->cascadeOnUpdate()
                    ->nullOnDelete();

            $table->string('title');
            $table->json('context');
            $table->string('head');
            $table->string('preview');
            $table->integer('read_counts')->unsigned();
            $table->integer('comment_counts')->unsigned();
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
        Schema::dropIfExists('articles');
    }
};
