<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->integer('ref_id')->nullable();  
            $table->integer('pos_id')->nullable();
            $table->integer('position')->nullable();
            $table->string('user_rank')->nullable();
            $table->string('username')->unique();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('name')->nullable();
            
            
            $table->decimal('balance', 18, 8)->default(0);
            $table->decimal('purchase_balance', 18, 8)->default(0);
            $table->decimal('deposit', 18, 8)->default(0);
            $table->decimal('withdraw', 18, 8)->default(0);
            $table->decimal('roi', 18, 8)->default(0);
            $table->decimal('refer_com', 18, 8)->default(0); 
            $table->decimal('matching_bonus', 18, 8)->default(0); 
            $table->decimal('roi_gen_bonus', 18, 8)->default(0);
            $table->decimal('purchase_bonus', 18, 8)->default(0);
            $table->decimal('repurchase_gen_com', 18, 8)->default(0);
            $table->decimal('club_balance', 18, 8)->default(0);
            $table->decimal('honorarium_balance', 18, 8)->default(0);
            $table->decimal('rank_insentive_balance', 18, 8)->default(0);
            $table->decimal('rank_royality_balance', 18, 8)->default(0);

            $table->decimal('total_income', 18, 8)->default(0);
           
            //20

            $table->longText('roi_payable_count')->nullable();
            $table->longText('roi_next_date')->nullable();
            $table->longText('roi_stop')->nullable();
            $table->longText('roi_send')->nullable();

            
            $table->integer('access_id');
            $table->longText('access_permission')->nullable();

            
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->longText('address')->nullable();
            $table->string('uniqe_key_code')->nullable();
            $table->string('password');
            $table->string('trx_pin');
            $table->timestamp('email_verified_at')->nullable();
          
            $table->longText('invest_date_time')->nullable();
            $table->boolean('invest_status')->default(false);
            $table->boolean('status')->default(1);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
