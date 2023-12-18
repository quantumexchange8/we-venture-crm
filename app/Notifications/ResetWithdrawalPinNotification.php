<?php

namespace App\Notifications;

use App\Models\ResetWithdrawalToken;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Password;

class ResetWithdrawalPinNotification extends Notification
{
    public function __construct()
    {
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        $token = Password::createToken(\Auth::user());
        $email = \Auth::user()->email;

        ResetWithdrawalToken::create([
            'email' => $email,
            'token' => $token
        ]);

        return (new MailMessage)
            ->subject('Reset Withdrawal Pin Link')
            ->line('You are receiving this email because we received a withdrawal pin reset request for your account.')
            ->action('Reset Pin', route('withdrawal_pin_reset', [
                'token' => $token,
                'email' => $email,
            ]))
            ->line('This withdrawal pin reset link will expire in 60 minutes.')
            ->line('If you did not request withdrawal a pin reset, no further action is required.')
            ->line('Thank you for using our application!');
    }

    public function toArray($notifiable): array
    {
        return [];
    }
}
