<?php

namespace App\Cascade\Models\Admin;

use Illuminate\Database\Eloquent\Builder;
use Handyfit\Framework\Trace\EloquentTrace;
use Handyfit\Framework\Hook\Eloquent as Hook;
use App\Cascade\Trace\Eloquent\Admin\AbilityTrace as TheEloquentTrace;
use Handyfit\Framework\Foundation\Hook\Eloquent as TheHook;
use Illuminate\Database\Eloquent\Model as Model;

use Handyfit\Framework\Foundation\Database\Eloquent\Casts\AutoTimezone as AutoTimezoneCastPackage;

/**
 * 
 *
 * @author KanekiYuto
*/
class AbilityModel extends Model
{

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
     * Table name
     *
     * @var string
     */
    protected $table = TheEloquentTrace::TABLE;

    /**
     * Primary key
     *
     * @var string
     */
    protected $primaryKey = TheEloquentTrace::PRIMARY_KEY;

    /**
     * The primary key increases automatically
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * Indicates whether the model actively maintains a timestamp
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Column properties that need to be hidden
     *
     * @var array<int, string>
     */
    protected $hidden = TheEloquentTrace::HIDDEN;

    /**
     * Attributes that can be filled
     *
     * @var array<string>
     */
    protected $fillable = TheEloquentTrace::FILLABLE;

    /**
     * Create an Eloquent model instance
     *
     * @return void
     */
    public function __construct()
    {
        $this->eloquentTrace = new TheEloquentTrace();
        $this->hook = new TheHook();

        parent::__construct();
    }

    /**
     * Gets the property that should be cast
     *
     * @return array
     */
    public function casts(): array
    {
        return array_merge(parent::casts(), [
			TheEloquentTrace::ID => 'string',
			TheEloquentTrace::SERVER_ROUTING => 'json',
			TheEloquentTrace::OPERATION => 'json',
			TheEloquentTrace::CREATED_AT => AutoTimezoneCastPackage::class,
			TheEloquentTrace::UPDATED_AT => AutoTimezoneCastPackage::class,
		]);
    }

    /**
     * Operations performed before creation
     *
     * @param  Builder  $query
     *
     * @return bool
     */
    protected function performInsert(Builder $query): bool
    {
        if (!$this->hook->performInsert($this, $query, $this->eloquentTrace)) {
            return false;
        }

        return parent::performInsert($query);
    }

    /**
     * The operation performed before the update
     *
     * @param  Builder  $query
     *
     * @return bool
     */
    protected function performUpdate(Builder $query): bool
    {
        if (!$this->hook->performUpdate($this, $query, $this->eloquentTrace)) {
            return false;
        }

        return parent::performUpdate($query);
    }

}
