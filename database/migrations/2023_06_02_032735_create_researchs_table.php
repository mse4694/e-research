<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */

    // corresponding_author[
    //  {'name':'xx', 'order':1},
    //  {'name':'yy', 'order':2},
    //  {'name':'zz', 'order':3},
    // ]
    public function up(): void
    {
// ของเดิมที่ใช้ ในการ seed ข้อมูลก่อนทำการ import จาก excel ไฟล์
//        Schema::create('researchs', function (Blueprint $table) {
//            $table->id();
//            $table->string('title', 500)->nullable();
//            $table->longText('abstract')->nullable();
//            $table->string('first_author');
//            $table->longText('corresponding_author')->nullable();
//            $table->string('journal_name', 500)->nullable();
//            $table->string('isbn')->nullable();
//            $table->string('issn')->nullable();
//            $table->string('doi');
//            $table->longText('tags')->nullable();
//            $table->unsignedBigInteger('person_id');
//            $table->dateTime('publish_date');
//            $table->json('other')->nullable();
//            $table->timestamps();
//        });

        Schema::create('researchs', function (Blueprint $table) {
            $table->id();
            $table->string('full_name', 500);
            $table->string('author', 2000);
            $table->string('author_id', 2000);
            $table->unsignedBigInteger('year')->default('0');
            $table->string('month', 100)->default('-');
            $table->string('title', 1000)->nullable();
            $table->longText('abstract')->nullable();
            $table->unsignedSmallInteger('volume')->nullable();
            $table->unsignedSmallInteger('issue')->nullable();
            $table->string('doi')->default('-');
            $table->string('link', 2000)->nullable();
            $table->longText('author_keyword')->nullable();
            $table->string('isbn')->nullable();
            $table->string('issn')->nullable();
            $table->unsignedBigInteger('person_id');
            $table->json('other')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('researchs');
    }
};
