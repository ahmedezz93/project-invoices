<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CreatInvoice extends Notification
{
    use Queueable;
    private $create_user;
    private $invoices_number;
    private $invoice_id;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($create_user,$invoices_number,$invoice_id)
    {

         $this->create_user=$create_user;
         $this->invoices_number=$invoices_number;
         $this->invoice_id=$invoice_id;


    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
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
       
                "create_user"=>$this->create_user,

                "invoices_number"=>$this->invoices_number,

                "invoice_id"=>$this->invoice_id,


         ];
    }
}
