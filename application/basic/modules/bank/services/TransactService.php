<?php

namespace app\modules\bank\services;


class TransactService
{
    public static function transact(&$transaction, &$donator, &$acceptor, $balance){

        $donator->balance -= $balance;
        $acceptor->balance += $balance;
        
        $donator->save();
        $acceptor->save();

        if ($donator->hasErrors() OR $acceptor->hasErrors()) {
            $transaction->rollback();
            return false;
        }
        
        $transaction->commit();
        return true;
    }
}