<?php

use App\Cascade\Trace\Eloquent\Admin\LogTrace as TheEloquentTrace;
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
			$table->bigInteger(column: TheEloquentTrace::ID)->primary()->unique()->comment(comment: '管理员日志ID');
			$table->bigInteger(column: TheEloquentTrace::ADMIN_ID)->comment(comment: '管理员ID');
			$table->string(column: TheEloquentTrace::API, length: 128)->comment(comment: 'API名称');
			$table->ipAddress(column: TheEloquentTrace::IPADDRESS)->comment(comment: '请求IP');
			$table->json(column: TheEloquentTrace::PAYLOAD)->comment(comment: '请求荷载');
			$table->json(column: TheEloquentTrace::HEADERS)->comment(comment: '请求头');
			$table->json(column: TheEloquentTrace::RESPONSE)->comment(comment: '响应参数');
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
