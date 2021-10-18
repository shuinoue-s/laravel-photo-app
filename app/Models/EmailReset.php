<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Notifications\ChangeEmail;
use App\Http\Requests\EmailChangeRequest;

class EmailReset extends Model
{
    use Notifiable;

    protected $guarded = ['id', 'created_at', 'updated_at'];

 /**
     * メールアドレス確定メールを送信
     *
     * @param [type] $token
     *
     */
    public function sendEmailResetNotification($token)
    {
        $this->notify(new ChangeEmail($token));
    }

    /**
     * 新しいメールアドレスあてにメールを送信する
     *
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return string
     */
    public function routeNotificationForMail($notification)
    {
        return $this->new_email;
    }
}
