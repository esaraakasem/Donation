<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Benwilkins\FCM\FcmMessage;
use App\Models\Donation;

class DonationRequest extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    protected $notif_content;
    protected $donation;
    // protected $fcm_android;

    public function __construct(Donation $donation)
    {
        $this->donation = $donation;
        // $this->fcm_android = $donation->user->fcm_android;
        $body = '';
        switch ($donation->status) {
            case 'accept':
                if ($donation->category == 'مال') {
                    $body = 'تم قبول الطلب وسيصلك مندوبنا '.period($donation->type);
                } else {
                    $body = 'تم قبول الطلب';
                }
                break;
            case 'refuse':
                $body = 'تم رفض الطلب'; 
                break;
            case 'visit':
                $body = 'برجاء الحضور للجنة لمراجعة اﻻوراق';
                break;
            default:
                $body = 'ﻻ يوجد';
                break;
        }
        $this->notif_content = [
            'title' => 'طلب '.$donation->category,
            'body' => $body,
            'type' => 'donation_request',
            'donation_id' => $donation->id
        ];
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database','fcm'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toDatabase($notifiable)
    {
        return $this->notif_content;
    }

    public function toFcm($notifiable) 
    {
        $message = new FcmMessage();
        $message->setHeaders([
            'project_id'    =>  "601199447444"   // FCM sender_id
        ])->content([
            'title'        => $this->notif_content['title'], 
            'body'         => $this->notif_content['body'], 
            'sound'        => '', // Optional 
            'icon'         => '', // Optional
            'click_action' => '' // Optional
        ])->data($this->notif_content)->priority(FcmMessage::PRIORITY_HIGH); // Optional - Default is 'normal'.
        
        return $message;
    }

}
