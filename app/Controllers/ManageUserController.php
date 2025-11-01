<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UserModel;

class ManageUserController extends BaseController
{
    protected $user;

    function __construct()
    {
        $this->user = new UserModel();
    }

    public function index()
    {
        $users = $this->user->findAll();
        $data['users'] = $users;
        return view('admin/v_manageUser', $data);
    }

    public function edit($id)
    {
        $dataForm = [
            'username' => $this->request->getPost('username'),
            'email' => $this->request->getPost('email'),
            'hp' => $this->request->getPost('hp'),
            'role' => $this->request->getPost('role'),
        ];

        $newPassword = $this->request->getPost('password');

        if($this->request->getPost('check') == 1 && !empty($newPassword)){
            $dataForm['password'] = password_hash($newPassword, PASSWORD_DEFAULT);
        }

        $this->user->update($id, $dataForm);

        return redirect('manage_user')->with('success', 'Data berhasil diubah');
    }

    public function delete($id)
    {
        $this->user->delete($id);
        return redirect('manage_user')->with('success', 'Data berhasil dihapus');
    }
}
