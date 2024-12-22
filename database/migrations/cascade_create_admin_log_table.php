<?php

use App\Cascade\Summaries\Admin\LogSummary as TheSummary;
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
            $table->bigInteger(column: TheSummary::ID)->primary()->unique()->comment(comment: '管理员日志ID');
            $table->bigInteger(column: TheSummary::ADMIN_ID)->comment(comment: '管理员ID');
            $table->string(column: TheSummary::API, length: 128)->comment(comment: 'API名称');
            $table->ipAddress(column: TheSummary::IPADDRESS)->comment(comment: '请求IP');
            $table->json(column: TheSummary::PAYLOAD)->comment(comment: '请求荷载');
            $table->json(column: TheSummary::HEADERS)->comment(comment: '请求头');
            $table->json(column: TheSummary::RESPONSE)->comment(comment: '响应参数');
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
