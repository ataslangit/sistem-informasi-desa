<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Budget extends Model
{
    use HasFactory;

    public const STATUS_DRAFT = 'draft';

    public const STATUS_PUBLISHED = 'published';

    public const STATUS_ARCHIVED = 'archived';

    protected $fillable = [
        'tenant_type',
        'tenant_id',
        'year',
        'title',
        'status',
        'description',
    ];

    protected $casts = [
        'year' => 'integer',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(BudgetItem::class)->orderBy('sort_order')->orderBy('id');
    }

    public function revenues(): HasMany
    {
        return $this->items()->where('type', 'revenue');
    }

    public function expenditures(): HasMany
    {
        return $this->items()->where('type', 'expenditure');
    }

    public function financings(): HasMany
    {
        return $this->items()->where('type', 'financing');
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_PUBLISHED);
    }

    public function getTotalBudgetedRevenueAttribute(): int
    {
        return (int) $this->items->where('type', 'revenue')->sum('budgeted_amount');
    }

    public function getTotalRealizedRevenueAttribute(): int
    {
        return (int) $this->items->where('type', 'revenue')->sum('realized_amount');
    }

    public function getTotalBudgetedExpenditureAttribute(): int
    {
        return (int) $this->items->where('type', 'expenditure')->sum('budgeted_amount');
    }

    public function getTotalRealizedExpenditureAttribute(): int
    {
        return (int) $this->items->where('type', 'expenditure')->sum('realized_amount');
    }

    public function getTotalBudgetedFinancingAttribute(): int
    {
        return (int) $this->items->where('type', 'financing')->sum('budgeted_amount');
    }

    public function getTotalRealizedFinancingAttribute(): int
    {
        return (int) $this->items->where('type', 'financing')->sum('realized_amount');
    }

    public function getSurplusDeficitBudgetedAttribute(): int
    {
        return $this->total_budgeted_revenue - $this->total_budgeted_expenditure;
    }

    public function getSurplusDeficitRealizedAttribute(): int
    {
        return $this->total_realized_revenue - $this->total_realized_expenditure;
    }

    public function getRevenueRealizationPercentageAttribute(): float
    {
        if ($this->total_budgeted_revenue === 0) {
            return 0.0;
        }

        return round(($this->total_realized_revenue / $this->total_budgeted_revenue) * 100, 1);
    }

    public function getExpenditureRealizationPercentageAttribute(): float
    {
        if ($this->total_budgeted_expenditure === 0) {
            return 0.0;
        }

        return round(($this->total_realized_expenditure / $this->total_budgeted_expenditure) * 100, 1);
    }
}
