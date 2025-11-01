<?php

namespace App\Controllers;

use App\Models\UserModel; 

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class ProfileController extends BaseController
{
    protected $userModel; // Ganti $user_id menjadi $userModel

    function __construct(){
        $this->userModel = new UserModel(); // Instansiasi UserModel
    }

    public function index()
    {
        // Ambil ID user dari session
        $user_id = session()->get('user_id');

        // Cari data user berdasarkan ID
        $profileData = $this->userModel->find($user_id);
        
        // Cek apakah data user ditemukan
        if (!$profileData) {
            // Jika user tidak ditemukan, Anda bisa mengarahkan ke halaman error atau login
            return redirect()->to('/login')->with('error', 'User not found.');
        }

        // Siapkan data untuk dikirim ke view
        $data['profile'] = $profileData; // Kirim satu baris data user, bukan array of users
        
        // Debugging: echo "<pre>"; print_r($data); echo "</pre>";

        return view('v_profile', $data);
    }

    public function edit($id)
    {
        $dataUser = $this->userModel->find($id);

        $dataForm = [
            'username' => $this->request->getPost('username'),
            'hp' => $this->request->getPost('hp'),
            'email' => $this->request->getPost('email'),
            'updated_at' => date("Y-m-d H:i:s")
        ];

        $this->userModel->update($id, $dataForm);

        return redirect('profile')->with('success', 'Data Berhasil Diubah');
    }
}