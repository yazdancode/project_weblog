<?php

namespace App;

use System\Database\ORM\Model;
use System\Database\Traits\HasSoftDelete;

class Category extends Model
{
    use HasSoftDelete;

    protected $table = "categories";
    protected $fillable = ['name', 'parent_id'];
    protected $primaryKey = 'id';
    protected $deletedAt = 'deleted_at';
    protected string $sql = '';
    protected $collection = [];


    public function parent()
    {
        return $this->belongsTo('\App\Category', 'parent_id', 'id');
    }
}
