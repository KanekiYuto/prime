<?php

use App\Cascade\Trace\Eloquent\PersonalAccess\TokensTrace as TheEloquentTrace;
use Handyfit\Framework\Foundation\Hook\Migration as TheHook;
use Handyfit\Framework\Hook\Migration as Hook;
use Handyfit\Framework\Trace\EloquentTrace;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/*
 * Database Migration []
 *
 * @author KanekiYuto
 */
return new class() extends Migration {

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
            $table->bigInteger(column: TheEloquentTrace::ID)->comment(comment: '私人访问令牌ID');
            $table->morphs(name: TheEloquentTrace::TOKENABLE);
            $table->string(column: TheEloquentTrace::NAME)->comment(comment: '令牌名称');
            $table->string(column: TheEloquentTrace::TOKEN, length: 64)->unique()->comment(comment: '令牌内容');
            $table->text(column: TheEloquentTrace::ABILITIES)->nullable()->comment(comment: '令牌能力');
            $table->timestamp(column: TheEloquentTrace::LAST_USED_AT)->nullable()->comment(comment: '令牌最终使用时间');
            $table->timestamp(column: TheEloquentTrace::EXPIRES_AT)->nullable()->comment(comment: '令牌过期时间');
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
