<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Budget extends Model
{
    use Auditable, HasFactory;

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
        return $this->items()->where('type', BudgetItem::TYPE_REVENUE);
    }

    public function expenditures(): HasMany
    {
        return $this->items()->where('type', BudgetItem::TYPE_EXPENDITURE);
    }

    public function financings(): HasMany
    {
        return $this->items()->where('type', BudgetItem::TYPE_FINANCING);
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_PUBLISHED);
    }

    public function getTotalBudgetedRevenueAttribute(): int
    {
        return (int) $this->items->where('type', BudgetItem::TYPE_REVENUE)->sum('budgeted_amount');
    }

    public function getTotalRealizedRevenueAttribute(): int
    {
        return (int) $this->items->where('type', BudgetItem::TYPE_REVENUE)->sum('realized_amount');
    }

    public function getTotalBudgetedExpenditureAttribute(): int
    {
        return (int) $this->items->where('type', BudgetItem::TYPE_EXPENDITURE)->sum('budgeted_amount');
    }

    public function getTotalRealizedExpenditureAttribute(): int
    {
        return (int) $this->items->where('type', BudgetItem::TYPE_EXPENDITURE)->sum('realized_amount');
    }

    public function getTotalBudgetedFinancingAttribute(): int
    {
        return (int) $this->items->where('type', BudgetItem::TYPE_FINANCING)->sum('budgeted_amount');
    }

    public function getTotalRealizedFinancingAttribute(): int
    {
        return (int) $this->items->where('type', BudgetItem::TYPE_FINANCING)->sum('realized_amount');
    }

    // --- Restrukturisasi Pos Pembiayaan Desa (Permendagri No. 20/2018) ---

    /**
     * Kumpulan item Penerimaan Pembiayaan (SiLPA tahun sebelumnya, dll).
     *
     * @return Collection<int, BudgetItem>
     */
    public function getFinancingReceiptsAttribute(): Collection
    {
        return $this->items->filter(fn (BudgetItem $item) => $item->isFinancingReceipt())->values();
    }

    /**
     * Kumpulan item Pengeluaran Pembiayaan (Penyertaan Modal BUMDes, dll).
     *
     * @return Collection<int, BudgetItem>
     */
    public function getFinancingExpendituresAttribute(): Collection
    {
        return $this->items->filter(fn (BudgetItem $item) => $item->isFinancingExpenditure())->values();
    }

    public function getTotalBudgetedFinancingReceiptAttribute(): int
    {
        return (int) $this->financing_receipts->sum('budgeted_amount');
    }

    public function getTotalRealizedFinancingReceiptAttribute(): int
    {
        return (int) $this->financing_receipts->sum('realized_amount');
    }

    public function getTotalBudgetedFinancingExpenditureAttribute(): int
    {
        return (int) $this->financing_expenditures->sum('budgeted_amount');
    }

    public function getTotalRealizedFinancingExpenditureAttribute(): int
    {
        return (int) $this->financing_expenditures->sum('realized_amount');
    }

    /**
     * Pembiayaan Netto = Penerimaan Pembiayaan - Pengeluaran Pembiayaan.
     */
    public function getNetFinancingBudgetedAttribute(): int
    {
        return $this->total_budgeted_financing_receipt - $this->total_budgeted_financing_expenditure;
    }

    public function getNetFinancingRealizedAttribute(): int
    {
        return $this->total_realized_financing_receipt - $this->total_realized_financing_expenditure;
    }

    public function getSurplusDeficitBudgetedAttribute(): int
    {
        return $this->total_budgeted_revenue - $this->total_budgeted_expenditure;
    }

    public function getSurplusDeficitRealizedAttribute(): int
    {
        return $this->total_realized_revenue - $this->total_realized_expenditure;
    }

    /**
     * Sisa Lebih Pembiayaan Anggaran (SiLPA) Akhir Tahun = Surplus/Defisit + Pembiayaan Netto.
     */
    public function getSilpaBudgetedAttribute(): int
    {
        return $this->surplus_deficit_budgeted + $this->net_financing_budgeted;
    }

    public function getSilpaRealizedAttribute(): int
    {
        return $this->surplus_deficit_realized + $this->net_financing_realized;
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

    /**
     * Ringkasan agregat belanja per 5 Bidang Baku Permendagri No. 20/2018.
     *
     * @return array<string, array{code: string, name: string, short_name: string, icon: string, color: string, budgeted: int, realized: int, percentage: float, items: Collection<int, BudgetItem>}>
     */
    public function getExpendituresByStandardFieldsAttribute(): array
    {
        $fields = BudgetItem::EXPENDITURE_FIELDS;
        $result = [];

        foreach ($fields as $key => $meta) {
            $matchedItems = $this->items->filter(function (BudgetItem $item) use ($key, $meta) {
                return $item->type === BudgetItem::TYPE_EXPENDITURE &&
                    (($item->sub_type === $key) || ($item->expenditure_field_info !== null && $item->expenditure_field_info['code'] === $meta['code']));
            })->values();

            $budgeted = (int) $matchedItems->sum('budgeted_amount');
            $realized = (int) $matchedItems->sum('realized_amount');
            $percentage = $budgeted > 0 ? round(($realized / $budgeted) * 100, 1) : 0.0;

            $result[$key] = array_merge($meta, [
                'budgeted' => $budgeted,
                'realized' => $realized,
                'percentage' => $percentage,
                'items' => $matchedItems,
            ]);
        }

        return $result;
    }
}
