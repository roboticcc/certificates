<?php

use App\Models\Certificate;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Carbon;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();

            $table->string('buyer_name');
            $table->string('buyer_surname');
            $table->string('buyer_email');
            $table->string('tree');
            $table->string('amount');
            $table->string('cost');
            $table->boolean('status')->default(0);
            $table->string('activation_key');
            $table->timestamps();

            $table->softDeletes();
        });

        Certificate::insert([
            [
                'buyer_name' => 'Ivan',
                'buyer_surname' => 'Ivanov',
                'buyer_email' => 'ivan@ivan.com',
                'tree' => 'India 2021',
                'amount' => '3',
                'cost' => '117',
                'status' => 1,
                'activation_key' => Str::random(10),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'buyer_name' => 'Nikita',
                'buyer_surname' => 'Petrov',
                'buyer_email' => 'petrov@nikita.com',
                'tree' => 'Bali 2015',
                'amount' => '4',
                'cost' => '156',
                'status' => 1,
                'activation_key' => Str::random(10),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('certificates');
    }
};
