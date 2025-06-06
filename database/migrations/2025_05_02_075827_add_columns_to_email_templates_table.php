<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('email_templates', function (Blueprint $table) {
            $table->after('name', function ($table) {
                $table->string('sender_name')->nullable();           // nome visualizzato del mittente
                $table->string('sender_email')->nullable();          // mail_dat (solo email)
                $table->string('recipient_email')->nullable();       // maildest_dat
                $table->string('cc_recipients')->nullable();         // maildestcc_dat + maildestcc2_dat (comma-separated)
            });
            $table->after('signature', function ($table) {
                $table->boolean('attach_documents')->default(false); // noatt_dat
                $table->boolean('attach_receipt')->default(false);   // attquiet_dat
                $table->text('notes')->nullable();                   // keywords_dat
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('email_templates', function (Blueprint $table) {
            $table->dropColumn('attach_documents');
            $table->dropColumn('attach_receipt');
            $table->dropColumn('sender_name');
            $table->dropColumn('sender_email');
            $table->dropColumn('recipient_email');
            $table->dropColumn('cc_recipients');
            $table->dropColumn('notes');
        });
    }
};
