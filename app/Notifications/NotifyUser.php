<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Notifications\NotificationEnum;

class NotifyUser extends Notification implements ShouldQueue, NotificationEnum
{
    use Queueable;


    private $usermsg;

    /**
     * Create a new notification instance.
     *``
     * @return void
     */
    public function __construct($usermsg)
    {
        $this->usermsg = $usermsg;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail','database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {

        $title = 'Information';

        switch($this->usermsg['type']){
            case self::WARNING : $title = 'Warning'; break;
            case self::SUCCESS : $title = 'Success'; break;
            case self::INFO : $title = 'Information'; break;
            case self::ERROR : $title = 'Error'; break;
            case self::ALERT : $title = 'Alert!'; break;

        }

        return [
            'group' => $this->usermsg['group'],
            'type' => $this->usermsg['type'],
            'title' => $title,
            'message'   =>  $this->usermsg['message'],
        ];
    }
}
