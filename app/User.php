<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Balance;
use App\Models\Historic;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'image'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
        
    public function balance(){
        return $this->hasOne(Balance::class);
    }

    public function historics(){
        return $this->hasMany(Historic::class);
    }

    public function getSender($sender){
        return $this->where('name', 'LIKE', "%$sender%")
                ->orWhere('email',$sender)
                ->get()
                ->first();
    }

    public function insertCli($data){

        $id = $this->max('id');
        
        if(!$id){
            $id=3;
        }else{
            $id=++$id;
        }

        if($data['pessoa']=='J'){
            $name = $data['razsoc']; 
        }else{
            $name = $data['nome'];
        }
        
        $this->insert(
            [   
            'id'=>$id,
            'idcli'=>$data['id'],
            'name'=>$name,
            'nivel'=>'CLI',
            'email'=>$data['email'],
            'password'=>$data['password'],
            ]
        );
    }

    public function insertCob($data){

        $id = $this->max('id');
        
        if(!$id){
            $id=3;
        }else{
            $id=++$id;
        }

        if($data['pessoa']=='J'){
            $name = $data['razsoc']; 
        }else{
            $name = $data['nome'];
        }
        
        $this->insert(
            [   
            'id'=>$id,
            'idcob'=>$data['id'],
            'name'=>$name,
            'nivel'=>'COB',
            'email'=>$data['email'],
            'password'=>$data['password'],
            ]
        );
    }

    public function insertAdm($data){

        $id = $this->max('id');
        
        if(!$id){
            $id=3;
        }else{
            $id=++$id;
        }

        if($data['pessoa']=='J'){
            $name = $data['razsoc']; 
        }else{
            $name = $data['nome'];
        }
        
        $this->insert(
            [   
            'id'=>$id,
            'idadm'=>$data['id'],
            'name'=>$name,
            'nivel'=>'ADM',
            'email'=>$data['email'],
            'password'=>$data['password'],
            ]
        );
    }

    public function insertAdmaster($data){

        $id = $this->max('id');
        
        if(!$id){
            $id=3;
        }else{
            $id=++$id;
        }

        if($data['pessoa']=='J'){
            $name = $data['razsoc']; 
        }else{
            $name = $data['nome'];
        }
        
        $this->insert(
            [   
            'id'=>$id,
            'idmas'=>$data['id'],
            'name'=>$name,
            'nivel'=>'MAS',
            'email'=>$data['email'],
            'password'=>$data['password'],
            ]
        );
    }

    public function insertCeo($data){

        $id = $this->max('id');
        
        if(!$id){
            $id=3;
        }else{
            $id=++$id;
        }

        if($data['pessoa']=='J'){
            $name = $data['razsoc']; 
        }else{
            $name = $data['nome'];
        }
        
        $this->insert(
            [   
            'id'=>$id,
            'idceo'=>$data['idceo'],
            'name'=>$name,
            'nivel'=>'CEO',
            'email'=>$data['email'],
            'password'=>$data['password'],
            ]
        );
    }

    public function deleteCli($id){
        $this
            ->where('idcli', $id)
            ->update(['password' => 'inativo']);
    }

    public function deleteCob($id){
        $this
            ->where('idcob', $id)
            ->update(['password' => 'inativo']);
    }

    public function deleteAdm($id){
        $this
            ->where('idadm', $id)
            ->update(['password' => 'inativo']);
    }

    public function deleteAdmaster($id){
        $this
            ->where('idmas', $id)
            ->update(['password' => 'inativo']);
    }

    public function deleteCeo($id){
        $this
            ->where('idceo', $id)
            ->update(['password' => 'inativo']);
    }

    public function updateUsr($data){
        $id = $data['id'];
        unset($data['id']);
        $dataInsert = [];
        if(isset($data['nome'])){
            $dataInsert = ["name"=>$data['nome']];
        }
        if(isset($data['email'])){
            $dataInsert += ["email"=>$data['email']];
        }

        if(count($dataInsert)>=1)
            $this
                ->where('id', $id)
                ->update($dataInsert);
    }

    public function mailVer($mail){
        $mailVer = $this
                    ->where('email','=',$mail)
                    ->get();

        if (isset($mailVer[0]['email'])){       
            return true;
        }else{
            return false;
        }
    }

}

