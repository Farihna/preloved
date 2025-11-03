<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

use App\Models\UserModel;

class AuthController extends BaseController
{
    protected $user;
    function __construct() {
        helper('form');
        $this->user = new UserModel();
    }

    public function login()
    {
        if ($this->request->getPost()) {
            $rules = [
                'username' => 'required|min_length[6]',
                'password' => 'required|min_length[7]',
            ];

            if ($this->validate($rules)) {
                $username = $this->request->getVar('username');
                $password = $this->request->getVar('password');

                $dataUser = $this->user->where(['username' => $username])->first(); //pasw 1234567

                if ($dataUser) {
                    if (password_verify($password, $dataUser['password'])) {
                        session()->set([
                            'username' => $dataUser['username'],
                            'user_id' => $dataUser['id'],
                            'hp' => $dataUser['hp'],
                            'role' => $dataUser['role'],
                            'isLoggedIn' => TRUE,
                            'img_profile' => $dataUser['img_profile'] ?? 'no_profile.jpg'
                        ]);

                        return redirect()->to(base_url('/'));
                    } else {
                        session()->setFlashdata('failed', 'Kombinasi Username & Password Salah');
                        return redirect()->back();
                    }
                } else {
                    session()->setFlashdata('failed', 'Username Tidak Ditemukan');
                    return redirect()->back();
                }
            } else {
                session()->setFlashdata('failed', $this->validator->listErrors());
                return redirect()->back();
            }
        }

        return view('auth/v_login');
    }

    public function register()
    {
        if ($this->request->getPost()) {
            $rules = [
                'username' => 'required|min_length[6]|is_unique[user.username]',
                'email'    => 'required|valid_email|is_unique[user.email]',
                'hp'       => 'required|min_length[10]|max_length[13]|is_unique[user.hp]|numeric',
                'password' => 'required|min_length[7]'
            ];

            if ($this->validate($rules)) {
                $dataForm = [
                    'username' => $this->request->getVar('username'),
                    'email'    => $this->request->getVar('email'),
                    'hp'       => $this->request->getVar('hp'),
                    'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
                    'role'     => 'user', 
                    'created_at' => date("Y-m-d H:i:s"),
                ];

                $this->user->insert($dataForm);

                session()->setFlashdata('success', 'Akun berhasil dibuat. Silahkan login.');
                return redirect()->to(base_url('login'));
            } else {
                session()->setFlashdata('failed', $this->validator->listErrors());
                return redirect()->back()->withInput();
            }
        }

        return view('auth/v_register');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('login');
    }   
}
