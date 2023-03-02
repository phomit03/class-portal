<?php

namespace App\Helpers;
use App\Http\Responses\Api;
use App\Mail\GeneralMail;
use App\Jobs\SendMailJob;
use Auth,DB;
use App\Models\Transaction;


class MailHelper
{
    /**
     * Send mail sign up
     *
     * @param Transaction $transaction
     */
    public static function sendMail($data)
    {
        //Send mail

        $subject = !empty($data['due_date']) ? 'first ' .$data['due_date'] : '';
        $data['subject'] = 'Notice you have a new assignment that needs to be completed '. $subject;

        $mailJob = new GeneralMail();
        $mailJob->setFromDefault()
                ->setView('emails.assignment', $data)
                ->setSubject($data['subject'])
                ->setTo($data['email']);
        dispatch(new SendMailJob($mailJob));
    }

}
