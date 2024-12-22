<?php

use App\Cascade\Summaries\Admin\AbilitySummary as TheSummary;
use Handyfit\Framework\Foundation\Hook\Migration as TheHook;
use Handyfit\Framework\Hook\Migration as Hook;
use Handyfit\Framework\Summary\Summary;
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
            $table->bigInteger(column: TheSummary::ID)->primary()->unique()->comment(comment: '能力 - [ID]');
            $table->string(column: TheSummary::NAME, length: 32)->comment(comment: '能力名称');
            $table->string(column: TheSummary::EXPLAIN, length: 64)->nullable()->comment(comment: '能力解释');
            $table->bigInteger(column: TheSummary::PARENT_ID)->comment(comment: '父级 - ID');
            $table->json(column: TheSummary::SERVER_ROUTING)->comment(comment: '服务端路由');
            $table->string(column: TheSummary::CLIENT_ROUTING, length: 128)->comment(comment: '客户端路由');
            $table->json(column: TheSummary::OPERATION)->comment(comment: '允许操作的权限');
            $table->enum(column: TheSummary::TYPE, allowed: ['group', 'menu', 'ability'])->comment(comment: '能力类型');
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
