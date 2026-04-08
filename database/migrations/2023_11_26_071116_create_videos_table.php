<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('link'); // YouTube URL
            $table->string('thumbnail')->nullable(); // Custom thumbnail (optional)
            $table->text('description')->nullable(); // Video description (optional)
            $table->string('youtube_id', 20)->nullable()->index(); // YouTube video ID
            $table->integer('duration')->nullable(); // Duration in seconds
            $table->integer('views')->default(0); // View count
            $table->boolean('is_featured')->default(false); // Featured video flag
            $table->boolean('is_active')->default(true); // Active/inactive status
            $table->timestamps();
            $table->softDeletes(); // Soft delete support

            // Indexes for better query performance
            $table->index('created_at');
            $table->index('is_featured');
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('videos');
    }
};