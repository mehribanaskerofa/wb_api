<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class BaseCommand // extends Command
{
    protected function validateDate($date)
    {
        if (!strtotime($date)) {
            $this->error('Geçersiz tarih formatı. Tarih formatı Y-m-d olmalıdır.');
            return false;
        }

        return true;
    }

//if (!$this->validateDate($dateFrom) || !$this->validateDate($dateTo)) {
//return;
//} extends BaseCommand

}
