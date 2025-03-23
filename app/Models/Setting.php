<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;
    protected $fillable = [
        'sitename',
        'company_name',
        'refer_com',
        'user_register_switch',
        'user_login_switch',
        'admin_mail',
        'cur_text',
        'cur_sym',
        'email_from',
        'email_template',
        'sms_api',
        'last_cron',
        'mail_config',
        'whatsapp_n'
        
    ];
}
