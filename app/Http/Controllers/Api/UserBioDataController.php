<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BodyColor;
use App\Models\Country;
use App\Models\User;
use App\Models\UserBioData;
use App\Models\UserBodyType;
use App\Models\UserDisability;
use App\Models\UserEducationGeneral;
use App\Models\UserEducationIslamic;
use App\Models\UserEyeColor;
use App\Models\UserHairColor;
use App\Models\UserHajj;
use App\Models\UserKnowledgeOfQuran;
use App\Models\UserPrayers;
use App\Models\UserUmrahHajj;
use App\Models\UserZakat;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserBioDataController extends Controller
{
    //user country
    public function country(){

       $country = Country::all();

        return response()->json([
            'country' => $country,
            'status'  => true
        ],200);
    }

    public function bodyType(){

        $bodytype = UserBodyType::all();

        return response()->json([
            'bodytype' => $bodytype,
            'status'  => true
        ],200);
    }
    public function hairColor(){

        $haircolor = UserHairColor::all();

        return response()->json([
            'haircolor' => $haircolor,
            'status'  => true
        ],200);
    }
    public function eyeColor(){

        $eyecolor = UserEyeColor::all();

        return response()->json([
            'eyecolor' => $eyecolor,
            'status'  => true
        ],200);
    }
    public function bodyColor(){

        $bodycolor = BodyColor::all();

        return response()->json([
            'eyecolor' => $bodycolor,
            'status'  => true
        ],200);
    }
    public function disabilities(){

        $disabilities = UserDisability::all();

        return response()->json([
            'disabilities' => $disabilities,
            'status'  => true
        ],200);
    }
    public function prayers(){

        $prayers = UserPrayers::all();

        return response()->json([
            'prayers' => $prayers,
            'status'  => true
        ],200);
    }
    public function eductionGeneral(){

        $eductionGeneral = UserEducationGeneral::all();

        return response()->json([
            'eductionGeneral' => $eductionGeneral,
            'status'  => true
        ],200);
    }
    public function eductionIslamic(){

        $eductionIslamic = UserEducationIslamic::all();

        return response()->json([
            'eductionIslamic' => $eductionIslamic,
            'status'  => true
        ],200);
    }
    public function hajj(){

        $hajj = UserHajj::all();

        return response()->json([
            'hajj' => $hajj,
            'status'  => true
        ],200);
    }
    public function umrahhajj(){

        $umrahhajj = UserUmrahHajj::all();

        return response()->json([
            'umrahhajj' => $umrahhajj,
            'status'  => true
        ],200);
    }
    public function knowledgeOfQuran(){

        $knowledgeOfQuran = UserKnowledgeOfQuran::all();

        return response()->json([
            'knowledgeOfQuran' => $knowledgeOfQuran,
            'status'  => true
        ],200);
    }
    public function zakat(){

        $zakat = UserZakat::all();

        return response()->json([
            'zakat' => $zakat,
            'status'  => true
        ],200);
    }

    public function userBioData($user_id){

        $userBioData = UserBioData::where('user_id',$user_id)->get();

        $userBirthDate = User::find($user_id);


        $data = [];

        foreach($userBioData as $userBioData){
            $data[]= [
            'id' => $userBioData->id,
            'fullName' => $userBioData->fullName,
            'birthDate' =>$userBirthDate->birthDate ?? '',
            'height' => $userBioData->height,
            'weight' => $userBioData->weight,
            'language' => $userBioData->language,
            'religion' => $userBioData->religion,
            'nationality' => $userBioData->getUserBioDataNationality->nationality ?? '' ,
            //family information
            'fatherName' => $userBioData->fatherName,
            'fatherOccupation' => $userBioData->fatherOccupation,
            'motherName' => $userBioData->motherName,
            'motherOccupation' => $userBioData->motherOccupation,
            'numberOfSiblings' => $userBioData->numberOfSiblings,
            'familyBackground' => $userBioData->familyBackground,
             //education
            'insituteName' => $userBioData->insituteName,
            'hightEducationGeneral' => $userBioData->getUserBioDataHightEducationGeneral->education ?? '',
            'hightEducationIslamic' => $userBioData->getUserBioDataHightEducationIslamic->education ?? '',
            'admissionYear' => $userBioData->admissionYear,
            'passingYear' => $userBioData->passingYear,
            //job information
            'jobTitle' => $userBioData->jobTitle,
            'companyName' => $userBioData->companyName,
            'workExperience' => $userBioData->workExperience,
            //personal
            'bodyType' => $userBioData->getUserBioDataBodyType->type ?? '',
            'hairColor' => $userBioData->getUserBioDataHairColor->color ?? '',
            'eyeColor' => $userBioData->getUserBioDataEyeColor->color ?? '',
            'bodyColor' => $userBioData->getUserBioDataBodyColor->color ?? '',
            'disabilities' => $userBioData->getUserBioDataDisabilities->disabilities ?? '',
            'explainDisabilities' => $userBioData->explainDisabilities,
            'hobbiesAndInterests' => $userBioData->hobbiesAndInterests,
            //islam
            'prayers' => $userBioData->getUserBioDataPrayers->prayers ?? '',
            'zakat' => $userBioData->getUserBioDataZakat->zakat ?? '',
            'hajj' => $userBioData->getUserBioDataHajj->hajj ?? '',
            'numberHajj' => $userBioData->numberHajj,
            'umrahHajj' => $userBioData->getUserBioDataUmrahHajj->umrahHajj ?? '',
            'numberUmrahHajj' => $userBioData->numberUmrahHajj,
            'knowledgeOfQuran' => $userBioData->getUserBioDataKnowledgeOfQuran->knowledgeOfQuran ?? '',
            //location
            'streetOne' => $userBioData->streetOne,
            'streetTwo' => $userBioData->streetTwo,
            'state' => $userBioData->state,
            'postalCode' => $userBioData->postalCode,
            'present_address' => $userBioData->present_address,
            'parmanent_address' => $userBioData->parmanent_address,
            'country' => $userBioData->getUserBioDataCountry->country ?? '',
            //wantedpatner
            'partnerReligion' => $userBioData->partnerReligion,
            'partnerHeight' => $userBioData->partnerHeight,
            'partnerWeight' => $userBioData->partnerWeight,
            'partnerEducationGeneral' => $userBioData->getUserBioDataPartnerEducationGeneral->education ?? '',
            'partnerEducationIslamic' => $userBioData->getUserBioDataPartnerEducationIslamic->education ?? '',

            ];

        }

        return  response()->json([
            'userBioData' => $data,
            'status'  => true
        ], 200);

    }

    public function userBioDataStore(Request $request){

        // $request->validate([
        //     'fullName' => 'required',
        //     'numberOfSiblings' => 'integer',
        //     'numberHajj' => 'integer',
        //     'numberUmrahHajj' => 'integer',

        // ]);

        $finduserid = UserBioData::where('user_id', $request->user_id)->get();

        if(count($finduserid) == 0){

            $userBioDataStoreAndUpdate = new UserBioData();
            $userBioDataStoreAndUpdate->create($request->except('_token')+['created_at' => Carbon::now()]);
            return response()->json([
                'message' => 'Bio Data  successfully Store',
                'status'  => true
            ],200);
        }

        elseif(count($finduserid) == 1){

            foreach($finduserid as $finduserid){

                $userBioDataStoreAndUpdate =UserBioData::find($finduserid->id);
                $userBioDataStoreAndUpdate->update($request->except('_token')+['updated_at' => Carbon::now()]);

                return response()->json([
                    'message' => 'Bio Data  successfully updated',
                    'status'  => true
                ],200);
            }
        }
        else{

            return response()->json([
                'error' => 'Something Error',
            ]);
        }


    }


}
