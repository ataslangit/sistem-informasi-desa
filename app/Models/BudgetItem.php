<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BudgetItem extends Model
{
    use HasFactory;

    public const TYPE_REVENUE = 'revenue';

    public const TYPE_EXPENDITURE = 'expenditure';

    public const TYPE_FINANCING = 'financing';

    protected $fillable = [
        'budget_id',
        'type',
        'category',
        'budgeted_amount',
        'realized_amount',
        'notes',
        'sort_order',
    ];

    protected $casts = [
        'budget_id' => 'integer',
        'budgeted_amount' => 'integer',
        'realized_amount' => 'integer',
        'sort_order' => 'integer',
    ];

    public function budget(): BelongsTo
    {
        return $this->belongsTo(Budget::class);
    }

    public function getRealizationPercentageAttribute(): float
    {
        if ($this->budgeted_amount === 0) {
            return 0.0;
        }

        return round(($this->realized_amount / $this->budgeted_amount) * 100, 1);
    }

    public function getTypeLabelAttribute(): string
    {
        return match ($this->type) {
            self::TYPE_REVENUE => 'Pendapatan',
            self::TYPE_EXPENDITURE => 'Belanja',
            self::TYPE_FINANCING => 'Pembiayaan',
            default => ucfirst($this->type),
        };
    }
}
