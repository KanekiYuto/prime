<?php

namespace App\Cascade\Models\Admin;

use Illuminate\Database\Eloquent\Builder;
use Handyfit\Framework\Summary\Summary;
use Handyfit\Framework\Hook\Eloquent as Hook;
use App\Cascade\Summaries\Admin\AbilitySummary as TheSummary;
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
     * Table name
     *
     * @var string
     */
    protected $table = TheSummary::TABLE;

    /**
     * Primary key
     *
     * @var string
     */
    protected $primaryKey = TheSummary::PRIMARY_KEY;

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
    protected $hidden = TheSummary::HIDDEN;

    /**
     * Attributes that can be filled
     *
     * @var array<string>
     */
    protected $fillable = TheSummary::FILLABLE;

    /**
     * Create an Eloquent model instance
     *
     * @return void
     */
    public function __construct()
    {
        $this->summary = new TheSummary();
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
			TheSummary::ID => 'string',
			TheSummary::SERVER_ROUTING => 'json',
			TheSummary::OPERATION => 'json',
			TheSummary::CREATED_AT => AutoTimezoneCastPackage::class,
			TheSummary::UPDATED_AT => AutoTimezoneCastPackage::class,
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
        if (!$this->hook->performInsert($this, $query, $this->summary)) {
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
        if (!$this->hook->performUpdate($this, $query, $this->summary)) {
            return false;
        }

        return parent::performUpdate($query);
    }

}
