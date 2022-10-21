<?php

namespace App\Notifications;

use App\Http\Controllers\Auth\ForgotPasswordController;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use App\Http\Controllers\Auth\ResetPasswordController;
use Illuminate\Support\Facades\Session;

class ResetPassword extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $email = Session::get('emailResetPassword');

        $password = $this->createResetPassword($email);

        Session::put('passwordReset', $password);

        return (new MailMessage)
            ->subject(Lang::get('Mail đặt lại mật khẩu'))
            ->view('vendor.notifications.email',compact('password'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }

    /**
     * Create reset password with form "Name@" + 6 random numbers.
     *
     * @param $email
     * @return string
     * @throws \Exception
     */
    private function createResetPassword($email){
        $name = DB::table('users')->where('email', '=', $email)->get('firstname');
        $name = ucfirst($name[0]->firstname);
        return $name . "@" . random_int(100000, 999999);
    }
}
