<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Post extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [ 'name','description'];
    protected $table = 'posts';
    public function getAllPosts()
    {
        return DB::table($this->table)->get();
    }
    public function getOnePost($id)
    {
        $posts = DB::table($this->table)
            ->find($id);
        return $posts;
    }
    public function create($data)
    {
        return DB::table($this->table)->insert($data);
    }
    public function updatePost($data,$id){
        return DB::table($this->table)->where('id', $id)->update($data);
    }
    public function deletePost($id){
        return DB::table($this->table)->where('id', $id)->delete();
    }
}
