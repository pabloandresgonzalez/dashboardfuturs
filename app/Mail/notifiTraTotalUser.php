<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class notifiTraTotalUser extends Mailable
{
    use Queueable, SerializesModels;

    public $message;
    public $user;
    public $type;
    public $totalPSIV;
    public $totalUSDT;
    public $balancePSIV;
    public $balanceUSDT;
    public $valotTotal;
    public $encanjePSIV;
    public $encanjeUSDT;
    public $trasladosPSIV;
    public $trasladosUSDT;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($message, $user, $type,
     $totalPSIV, $totalUSDT, $balancePSIV, $balanceUSDT,
     $valotTotal, $encanjePSIV, $encanjeUSDT, $trasladosPSIV, $trasladosUSDT)
    {
        $this->message = $message;        
        $this->user = $user;
        $this->type = $type;
        $this->totalPSIV = $totalPSIV;
        $this->totalUSDT = $totalUSDT;
        $this->balancePSIV = $balancePSIV;
        $this->balanceUSDT = $balanceUSDT;
        $this->valotTotal = $valotTotal;
        $this->encanjePSIV = $encanjePSIV;
        $this->encanjeUSDT = $encanjeUSDT;
        $this->trasladosPSIV = $trasladosPSIV;
        $this->trasladosUSDT = $trasladosUSDT;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        //return $this->view('view.name');
        return $this->markdown('mails.notificationTraTotalUser');
    }
}
