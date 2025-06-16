<?php

use App\Models\Fund;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /*
    * The status of the resource when it is not associated with a fund.
    *
    * withNoAssociation = 0
    * with an association but not published = 1
    * published = 2
    *
    */
    protected const withNoAssociation = 0;

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('digital_objects', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('image_name');
            $table->string('image_thumb');
            $table->string('image_derivative');
            $table->foreignIdFor(Fund::class)->constrained()->cascadeOnDelete()->cascadeOnUpdate();;
            $table->string('inventory_number')->nullable();
            $table->string('website_link')->nullable();
            $table->integer('status')->default(self::withNoAssociation);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('digital_objects');
    }
};
