<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_bio_data', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->string('fullName')->nullable();
            $table->string('height')->nullable();
            $table->string('weight')->nullable();
            $table->string('language')->nullable();
            $table->string('religion')->default('Islam');
            $table->integer('nationality')->nullable();//select
            //family information
            $table->string('fatherName')->nullable();
            $table->string('fatherOccupation')->nullable();
            $table->string('motherName')->nullable();
            $table->string('motherOccupation')->nullable();
            $table->integer('numberOfSiblings')->nullable();
            $table->longText('familyBackground')->nullable();
            //education
            $table->string('insituteName')->nullable();
            $table->integer('hightEducationGeneral')->nullable();//select
            $table->integer('hightEducationIslamic')->nullable();//select
            $table->date('admissionYear')->nullable();
            $table->date('passingYear')->nullable();
            //job information
            $table->string('jobTitle')->nullable();
            $table->string('companyName')->nullable();
            $table->integer('workExperience')->nullable();
            //personal
            $table->integer('bodyType')->nullable();//select
            $table->integer('hairColor')->nullable();//select
            $table->integer('eyeColor')->nullable();//select
            $table->integer('disabilities')->nullable();//select
            $table->text('explainDisabilities')->nullable();
            $table->string('hobbiesAndInterests')->nullable();
            //islam
            $table->integer('prayers')->nullable();//select
            $table->integer('zakat')->nullable();//select
            $table->integer('hajj')->nullable();//select
            $table->integer('numberHajj')->nullable();
            $table->integer('umrahHajj')->nullable();//select
            $table->integer('numberUmrahHajj')->nullable();
            $table->integer('knowledgeOfQuran')->nullable();//select
            //location
            $table->string('streetOne')->nullable();
            $table->string('streetTwo')->nullable();
            $table->string('state')->nullable();
            $table->string('postalCode')->nullable();
            $table->integer('country')->nullable();//select
            //wantedpatner
            $table->string('partnerReligion')->default('Islam');
            $table->string('partnerHeight')->nullable();
            $table->string('partnerWeight')->nullable();
            $table->integer('partnerEducationGeneral')->nullable();//select
            $table->integer('partnerEducationIslamic')->nullable();//select
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_bio_data');
    }
};
