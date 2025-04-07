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
        $tableName = config('laravel_ticket.table_names.tickets', 'tickets');

        Schema::table($tableName, function (Blueprint $table) {
            $table->string('jira_issue_id')->nullable()->after('uuid');
            $table->string('jira_issue_key')->nullable()->after('jira_issue_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
