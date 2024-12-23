<?php

use App\Cascade\Summaries\Personal\AccessTokensSummary as TheSummary;
use Handyfit\Framework\Foundation\Hook\Migration as TheHook;
use Handyfit\Framework\Summary\Summary;
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
     * Summary class
     *
     * @var Summary
     */
    protected Summary $summary;

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
        $this->summary = new TheSummary();
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
        $this->hook->upBefore($this->summary);

        Schema::create(TheSummary::TABLE, function (Blueprint $table) {
			$table->bigInteger(column: TheSummary::ID)->comment(comment: '私人访问令牌ID');
			$table->morphs(name: TheSummary::TOKENABLE);
			$table->string(column: TheSummary::NAME)->comment(comment: '令牌名称');
			$table->string(column: TheSummary::TOKEN, length: 64)->unique()->comment(comment: '令牌内容');
			$table->text(column: TheSummary::ABILITIES)->nullable()->comment(comment: '令牌能力');
			$table->timestamp(column: TheSummary::LAST_USED_AT)->nullable()->comment(comment: '令牌最终使用时间');
			$table->timestamp(column: TheSummary::EXPIRES_AT)->nullable()->comment(comment: '令牌过期时间');
			$table->bigInteger(column: TheSummary::CREATED_AT)->comment(comment: '创建时间');
			$table->bigInteger(column: TheSummary::UPDATED_AT)->comment(comment: '修改时间');
		});

        // Perform operations after the migration
        $this->hook->upAfter($this->summary);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        // Perform the operations before the migration rollback
        $this->hook->downBefore($this->summary);

        Schema::dropIfExists(TheSummary::TABLE);

        // Perform operations after the migration rollback
        $this->hook->downAfter($this->summary);
    }

};
