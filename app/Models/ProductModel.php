<?php 
namespace App\Models;

use CodeIgniter\Model;


class ProductModel extends Model
{
	protected $table = 'product'; 
	protected $primaryKey = 'id';
	protected $allowedFields = [
		'nama','harga','deskripsi','status','foto','created_at','updated_at','id_user'
	];  

}