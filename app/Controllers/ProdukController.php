<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\CategoryModel;
use App\Models\UserModel;
use Dompdf\Dompdf;

class ProdukController extends BaseController
{
    protected $productModel;
    protected $categoryModel;
    protected $userModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->categoryModel = new CategoryModel();
        $this->userModel = new UserModel();
        helper(['form', 'url']);
    }

    /**
     * Menampilkan daftar produk (Admin & User)
     */
    public function index()
    {
        if (!session()->get('isLoggedIn')) { // Menggunakan key session Anda sebelumnya
            return redirect()->to('/login');
        }

        $userId = session()->get('user_id');
        $role = session()->get('role');

        // Logic pengambilan produk dengan join kategori
        if ($role == 'admin') {
            $products = $this->productModel
                            ->select('product.*, user.username, categories.name as category_name')
                            ->join('user', 'user.id = product.id_user')
                            ->join('categories', 'categories.id = product.category_id', 'left')
                            ->orderBy('product.created_at', 'DESC')
                            ->findAll();
        } else {
            $products = $this->productModel
                            ->select('product.*, categories.name as category_name')
                            ->join('categories', 'categories.id = product.category_id', 'left')
                            ->where('product.id_user', $userId)
                            ->orderBy('product.created_at', 'DESC')
                            ->findAll();
        }

        // Ambil kategori aktif untuk dropdown di Modal tambah/edit
        $categories = $this->categoryModel->where('is_active', 1)->findAll();

        $data = [
            'product' => $products,
            'categories' => $categories,
            'user_profile' => $this->userModel->find($userId)
        ];

        if ($role == 'admin') {
            return view('admin/v_produk', $data);
        } else {
            return view('v_produk', $data);
        }
    }

    /**
     * Simpan Produk Baru
     */
    public function create()
    {
        $dataFoto = $this->request->getFile('foto');
        $userId = session()->get('user_id');

        $dataForm = [
            'id_user'       => $userId,
            'category_id'   => $this->request->getPost('category_id'),
            'nama'          => $this->request->getPost('nama'),
            'harga'         => $this->request->getPost('harga'),
            'deskripsi'     => $this->request->getPost('deskripsi'),
            'status'        => $this->request->getPost('status') ?? 1,
            'weight'        => $this->request->getPost('weight') ?? 500,
            'is_negotiable' => $this->request->getPost('is_negotiable') ?? 1,
            'created_at'    => date("Y-m-d H:i:s")
        ];

        if ($dataFoto && $dataFoto->isValid()) {
            $fileName = $dataFoto->getRandomName();
            $dataForm['foto'] = $fileName;
            $dataFoto->move('img/', $fileName);
        }

        $this->productModel->insert($dataForm);
        return redirect()->to('produk')->with('success', 'Data Berhasil Ditambah');
    }

    /**
     * Edit Produk
     */
    public function edit($id)
    {
        $product = $this->productModel->find($id);

        $dataForm = [
            'category_id'   => $this->request->getPost('category_id'),
            'nama'          => $this->request->getPost('nama'),
            'harga'         => $this->request->getPost('harga'),
            'deskripsi'     => $this->request->getPost('deskripsi'),
            'status'        => $this->request->getPost('status'),
            'weight'        => $this->request->getPost('weight') ?? $product['weight'],
            'is_negotiable' => $this->request->getPost('is_negotiable') ?? $product['is_negotiable'],
            'updated_at'    => date("Y-m-d H:i:s")
        ];

        if ($this->request->getPost('check') == 1) {
            $dataFoto = $this->request->getFile('foto');
            if ($dataFoto && $dataFoto->isValid()) {
                // Hapus foto lama
                if ($product['foto'] && file_exists("img/" . $product['foto'])) {
                    unlink("img/" . $product['foto']);
                }
                $fileName = $dataFoto->getRandomName();
                $dataFoto->move('img/', $fileName);
                $dataForm['foto'] = $fileName;
            }
        }

        $this->productModel->update($id, $dataForm);
        return redirect()->to('produk')->with('success', 'Data Berhasil Diubah');
    }

    /**
     * Hapus Produk
     */
    public function delete($id)
    {
        $product = $this->productModel->find($id);

        if ($product['foto'] && file_exists("img/" . $product['foto'])) {
            unlink("img/" . $product['foto']);
        }

        $this->productModel->delete($id);
        return redirect()->to('produk')->with('success', 'Data Berhasil Dihapus');
    }

    /**
     * Download PDF (Fitur Admin)
     */
    public function download()
    {
        $product = $this->productModel
                        ->select('product.*, categories.name as category_name')
                        ->join('categories', 'categories.id = product.category_id', 'left')
                        ->findAll();

        $html = view('admin/v_produkPDF', ['product' => $product]);
        $filename = date('y-m-d-H-i-s') . '-produk';

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream($filename);
    }

    /**
     * Detail Produk (Sisi User)
     */
    public function detail($id)
    {
        $product = $this->productModel
                        ->select('product.*, categories.name as category_name, user.username, user.img_profile, user.hp')
                        ->join('categories', 'categories.id = product.category_id', 'left')
                        ->join('user', 'user.id = product.id_user')
                        ->where('product.id', $id)
                        ->first();

        if (!$product) {
            return redirect()->to('/')->with('failed', 'Product not found');
        }

        $data = [
            'product' => $product,
            'seller' => [
                'username' => $product['username'],
                'img_profile' => $product['img_profile'],
                'hp' => $product['hp']
            ]
        ];

        return view('v_product_detail', $data);
    }
}