<?php

namespace App\Mail;


use App\Models\Order;
use Illuminate\Bus\Queueable;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderCreated extends Mailable
{
    use Queueable, SerializesModels;

    protected $name;
    protected $order;
    protected $phone;

    /**
     * OrderCreated constructor.
     * @param $name
     * @param $basket
     */
    public function __construct($name,$phone, Order $order)
    {
        $this->name = $name;
        $this->order = $order;
        $this->phone=$phone;
    }


    /**
     * Create a new message instance.
     *
     * @return void


    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $fullSum=$this->order->calculateFullSum();
        return $this->view('mail.order_created', [
            'name'=>$this->name,
            'fullSum'=>$fullSum,
            'order'=>$this->order,
            'phone'=>$this->phone,
        ]);
    }
}
