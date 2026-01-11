<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\WalletModel;
use App\Models\WalletTransactionModel;

class WalletController extends BaseController
{
    protected $walletModel;
    protected $walletTrxModel;
    
    public function __construct()
    {
        $this->walletModel = new WalletModel();
        $this->walletTrxModel = new WalletTransactionModel();
    }
    
    /**
     * Wallet page
     * GET /wallet
     */
    public function index()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }
        
        $userId = session()->get('user_id');
        
        $wallet = $this->walletModel->getOrCreateWallet($userId);
        $history = $this->walletTrxModel->getUserHistory($userId);
        
        $data = [
            'wallet' => $wallet,
            'history' => $history
        ];
        
        return view('v_wallet', $data);
    }
    
    /**
     * Withdraw (Placeholder - not implemented)
     */
    public function withdraw()
    {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Fitur penarikan saldo belum tersedia'
        ]);
    }
}