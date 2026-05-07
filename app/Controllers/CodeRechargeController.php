<?php

namespace App\Models;

use App\Controllers\BaseController;
use App\Models\WalletModel;
use App\Models\CodeRechargeModel;


class CodeRechargeController extends BaseController
{
    public function saisieCode()
    {
        $walletModel = new WalletModel();
        $codeRechargeModel = new CodeRechargeModel();
        $code = $this->request->getGet('code');
        $userID = session()->get('id');
        $wallet = $walletModel->where('user_id', $userID)->first();

        $codeData = $codeRechargeModel->where('code', $code)->first();

        if($codeData['used_by'] != null && $codeData['used_at'] != null)
        {
            return redirect()
                ->back()
                ->with(
                    'error',
                    'Code déjà utilisé'
                );
        }
        $walletModel->update(
            $wallet['id'],
            [
                'solde' =>
                $wallet['solde'] + $codeData['montant']
            ]
        );
        

    }
}


