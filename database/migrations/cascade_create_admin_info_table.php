<?php

use App\Cascade\Trace\Eloquent\Admin\InfoTrace as TheEloquentTrace;
use Handyfit\Framework\Foundation\Hook\Migration as TheHook;
use Handyfit\Framework\Trace\EloquentTrace;
use Handyfit\Framework\Hook\Migration as Hook;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Database Migration [测试]
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
			$table->bigInteger(column: TheEloquentTrace::ID)->primary()->unique()->comment(comment: '管理员ID');
			$table->string(column: TheEloquentTrace::ACCOUNT, length: 32)->comment(comment: '账号');
			$table->bigInteger(column: TheEloquentTrace::ADMIN_ROLE_ID)->index()->comment(comment: '角色ID');
			$table->string(column: TheEloquentTrace::EMAIL, length: 32)->comment(comment: '邮箱');
			$table->string(column: TheEloquentTrace::PASS, length: 512)->comment(comment: '密码');
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
