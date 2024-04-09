<?php

namespace App\Models;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'users';
    public function getAllUser()
    {
        return DB::table($this->table)->get();
    }
    public function getOneUser($id)
    {
        $posts = DB::table($this->table)
            ->find($id);
        return $posts;
    }
    public function createUser($data)
    {
        return DB::table($this->table)->insert($data);
    }
    public function updateUser($data,$id){
        return DB::table($this->table)->where('id', $id)->update($data);
    }
    public function deleteUser($id){
        return DB::table($this->table)->where('id', $id)->delete();
    }
}
