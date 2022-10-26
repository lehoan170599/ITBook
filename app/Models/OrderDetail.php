<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    public $timestamps = false; //set time to false
    protected $fillable = [
    	'order_code', 'product_id', 'product_name','product_price','product_sale_qty'
    ];
    protected $primaryKey = 'order_detail_id';
 	protected $table = 'tbl_order_detail';

 	public function product(){
 		return $this->belongsTo('App\Models\Product','product_id');
 	}
}
