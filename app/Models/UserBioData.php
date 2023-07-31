<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserBioData extends Model
{
    protected $guarded = ['id'];
    use HasFactory;


    public function getUserBioDataCountry(){
       return $this->belongsTo(Country::class, 'country', 'id');
    }
    public function getUserBioDataNationality(){
       return $this->belongsTo(Country::class, 'nationality', 'id');
    }
    public function getUserBioDataHightEducationGeneral(){
       return $this->belongsTo(UserEducationGeneral::class, 'hightEducationGeneral', 'id');
    }
    public function getUserBioDataHightEducationIslamic(){
       return $this->belongsTo(UserEducationIslamic::class, 'hightEducationIslamic', 'id');
    }
    public function getUserBioDataPartnerEducationGeneral(){
       return $this->belongsTo(UserEducationGeneral::class, 'partnerEducationGeneral', 'id');
    }
    public function getUserBioDataPartnerEducationIslamic(){
       return $this->belongsTo(UserEducationIslamic::class, 'hightEducationIslamic', 'id');
    }
    public function getUserBioDataKnowledgeOfQuran(){
       return $this->belongsTo(UserKnowledgeOfQuran::class, 'knowledgeOfQuran', 'id');
    }
    public function getUserBioDataBodyType(){
       return $this->belongsTo(UserBodyType::class, 'bodyType', 'id');
    }
    public function getUserBioDataHairColor(){
       return $this->belongsTo(UserHairColor::class, 'hairColor', 'id');
    }
    public function getUserBioDataBodyColor(){
       return $this->belongsTo(BodyColor::class, 'bodycolor', 'id'); 
    }
    public function getUserBioDataEyeColor(){
       return $this->belongsTo(UserEyeColor::class, 'eyeColor', 'id');
    }
    public function getUserBioDataDisabilities(){
       return $this->belongsTo(UserDisability::class, 'disabilities', 'id');
    }
    public function getUserBioDataPrayers(){
       return $this->belongsTo(UserPrayers::class, 'prayers', 'id');
    }
    public function getUserBioDataZakat(){
       return $this->belongsTo(UserZakat::class, 'zakat', 'id');
    }
    public function getUserBioDataHajj(){
       return $this->belongsTo(UserHajj::class, 'hajj', 'id');
    }
    public function getUserBioDataUmrahHajj(){
       return $this->belongsTo(UserUmrahHajj::class, 'umrahHajj', 'id');
    }

    public function getUserBioDataUser(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
