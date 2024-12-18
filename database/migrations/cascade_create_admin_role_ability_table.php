<?php

use App\Cascade\Trace\Eloquent\AdminRole\AbilityTrace as TheEloquentTrace;
use Handyfit\Framework\Foundation\Hook\Migration as TheHook;
use Handyfit\Framework\Trace\EloquentTrace;
use Handyfit\Framework\Hook\Migration as Hook;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Database Migration []
 *
 * @author KanekiYuto
 */
return new class extends Migration {

    /**
     * Eloquent model tracing class
     *
     * @var EloquentTrace
     */
    protected EloquentTrace $eloquentTrace;

    /**
     * Hook class
     *
     * @var Hook
     */
    protected Hook $hook;

    /**
     * Create a Migration instance
     *
     * @return void
     */
    public function __construct()
    {
        $this->eloquentTrace = new TheEloquentTrace();
        $this->hook = new TheHook();
    }

    /**
     * Get the migration connection name.
     *
     * @return string|null
     */
    public function getConnection(): ?string
    {
        return config('database.default');
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        // Perform the operations before the migration
        $this->hook->upBefore($this->eloquentTrace);

        Schema::create(TheEloquentTrace::TABLE, function (Blueprint $table) {
			$table->bigInteger(column: TheEloquentTrace::ID)->primary()->unique()->comment(comment: '角色能力 - [ID]');
			$table->bigInteger(column: TheEloquentTrace::ROLE_ID)->comment(comment: '角色 - [ID]');
			$table->bigInteger(column: TheEloquentTrace::ABILITY_ID)->comment(comment: '能力 - [ID]');
			$table->bigInteger(column: TheEloquentTrace::CREATED_AT)->comment(comment: '创建时间');
			$table->bigInteger(column: TheEloquentTrace::UPDATED_AT)->comment(comment: '修改时间');
		});

        // Perform operations after the migration
        $this->hook->upAfter($this->eloquentTrace);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        // Perform the operations before the migration rollback
        $this->hook->downBefore($this->eloquentTrace);

        Schema::dropIfExists(TheEloquentTrace::TABLE);

        // Perform operations after the migration rollback
        $this->hook->downAfter($this->eloquentTrace);
    }

};
