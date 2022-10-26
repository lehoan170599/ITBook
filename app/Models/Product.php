<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public $timestamps = false; //set time to false
    protected $fillable = [
    	'product_name', 'category_id', 'product_desc','product_content','product_price','product_qty','product_image','product_status','product_sold','product_cost'
    ];
    protected $primaryKey = 'product_id';
 	protected $table = 'tbl_product';	
}
