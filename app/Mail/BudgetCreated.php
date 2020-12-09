<?php

namespace App\Mail;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use App\Budget;
use PDF;

class BudgetCreated extends Mailable
{
    use Queueable, SerializesModels;
    protected $budget_id;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($budget_id)
    {
        $this->budget_id = $budget_id;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $budget = Budget::where('id', $this->budget_id)->first();
        $pdf = PDF::loadView('mails.budget_mail_pdf', ['budget'=>$budget]);
        return $this->view('mails.budget_notify')
                    ->attachData($pdf->output(), 'Presupuesto.pdf', ['mime' => 'application/pdf']);
;
    }
}
