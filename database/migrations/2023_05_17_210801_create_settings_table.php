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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('sitename')->nullable();
            $table->string('company_name')->nullable();
            $table->string('site_url',50)->nullable();
            $table->string('admin_mail',191)->nullable();
           
            
            $table->decimal('refer_com',18,2)->default(10);
            $table->boolean('user_register_switch')->default(true);
            $table->boolean('user_login_switch')->default(0);
            $table->boolean('whatsapp_n')->default(0);
        
    

            $table->string('cur_text')->nullable();
            $table->string('cur_sym')->nullable();
            $table->string('email_from')->nullable();
            $table->text('email_template')->nullable();
            $table->string('sms_api')->nullable();
            $table->string('last_cron')->nullable();
            $table->text('mail_config')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
