<?php
// database/migrations/2024_01_01_000004_create_events_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->dateTime('event_date');
            $table->dateTime('end_date')->nullable();
            $table->string('venue');
            $table->string('address')->nullable();
            $table->enum('city', ['Sydney','Melbourne','Brisbane','Perth','Adelaide','Canberra','Other']);
            $table->string('organiser');
            $table->enum('category', ['cultural','social','business','sports','religious','education','other'])->default('cultural');
            $table->string('image')->nullable();
            $table->string('contact_email')->nullable();
            $table->boolean('is_free')->default(true);
            $table->decimal('ticket_price', 10, 2)->default(0.00);
            $table->string('ticket_link')->nullable();
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->boolean('is_approved')->default(false);
            $table->timestamps();

            $table->index(['event_date', 'city']);
            $table->index(['is_approved', 'event_date']);
        });

        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('article_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->text('body');
            $table->boolean('is_approved')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('comments');
        Schema::dropIfExists('events');
    }
};
