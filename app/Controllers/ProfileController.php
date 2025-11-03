<?php

namespace App\Controllers;

use App\Models\UserModel; 

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class ProfileController extends BaseController
{
    protected $userModel;

    function __construct(){
        $this->userModel = new UserModel(); 
    }

    public function index()
    {
        $user_id = session()->get('user_id');

        $profileData = $this->userModel->find($user_id);
        
        if (!$profileData) {
            return redirect()->to('/login')->with('error', 'User not found.');
        }

        session()->set([
            'img_profile' => $profileData['img_profile'] ?? 'no_profile.jpg',
            'username'    => $profileData['username'],
        ]);

        $data['profile'] = $profileData;
        

        return view('v_profile', $data);
    }

    public function edit($id)
    {
        $userData = $this->userModel->find($id);

        if (!$userData) {
            return redirect()->to('/profile')->with('error', 'Data pengguna tidak ditemukan.');
        }

        $dataUpdate = [
            'username'   => $this->request->getPost('username'),
            'hp'         => $this->request->getPost('hp'),
            'email'      => $this->request->getPost('email'),
            'updated_at' => date("Y-m-d H:i:s")
        ];

        if ($this->request->getPost('check') == 1) {
            
            $fileFoto = $this->request->getFile('img_profile');
            
            $fotoLama = $userData['img_profile'] ?? 'no_profile.jpg';

            if ($fileFoto->isValid() && ! $fileFoto->hasMoved()) {

                if ($fotoLama != 'no_profile.jpg' && file_exists("img/" . $fotoLama)) {
                    unlink("img/" . $fotoLama);
                }

                $namaFileBaru = $fileFoto->getRandomName();
                $fileFoto->move('img', $namaFileBaru);

                $dataUpdate['img_profile'] = $namaFileBaru;
            } 
            else {
                 $dataUpdate['img_profile'] = $fotoLama;
            }

            $this->userModel->update($id, $dataUpdate);

            $updatedUserData = $this->userModel->find($id);

            if ($updatedUserData) {
             session()->set([
                'img_profile' => $updatedUserData['img_profile'] ?? 'no_profile.jpg', 
                'username'    => $updatedUserData['username'], 
                'hp'          => $updatedUserData['hp'],
            ]);
            }

            // Redirect ke halaman profile dengan pesan sukses
            return redirect()->to('/profile')->with('success', 'Profile berhasil diperbarui!');
        }
        
        // Jika tidak ada 'check' == 1 (error atau request tidak sesuai), redirect
        return redirect()->to('/profile')->with('error', 'Gagal memperbarui profile.');
    }
}