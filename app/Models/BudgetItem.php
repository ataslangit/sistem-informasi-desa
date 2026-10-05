<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BudgetItem extends Model
{
    use Auditable, HasFactory;

    public const TYPE_REVENUE = 'revenue';

    public const TYPE_EXPENDITURE = 'expenditure';

    public const TYPE_FINANCING = 'financing';

    // --- Standarisasi 5 Bidang Belanja Baku (Permendagri No. 20/2018) ---
    public const BIDANG_PEMERINTAHAN = 'bidang_1';

    public const BIDANG_PEMBANGUNAN = 'bidang_2';

    public const BIDANG_PEMBINAAN = 'bidang_3';

    public const BIDANG_PEMBERDAYAAN = 'bidang_4';

    public const BIDANG_BENCANA_DARURAT = 'bidang_5';

    public const EXPENDITURE_FIELDS = [
        self::BIDANG_PEMERINTAHAN => [
            'code' => '1',
            'name' => 'Bidang Penyelenggaraan Pemerintahan Desa',
            'short_name' => 'Penyelenggaraan Pemerintahan',
            'icon' => '🏛️',
            'color' => 'indigo',
        ],
        self::BIDANG_PEMBANGUNAN => [
            'code' => '2',
            'name' => 'Bidang Pelaksanaan Pembangunan Desa',
            'short_name' => 'Pelaksanaan Pembangunan',
            'icon' => '🏗️',
            'color' => 'emerald',
        ],
        self::BIDANG_PEMBINAAN => [
            'code' => '3',
            'name' => 'Bidang Pembinaan Kemasyarakatan Desa',
            'short_name' => 'Pembinaan Kemasyarakatan',
            'icon' => '👥',
            'color' => 'blue',
        ],
        self::BIDANG_PEMBERDAYAAN => [
            'code' => '4',
            'name' => 'Bidang Pemberdayaan Masyarakat Desa',
            'short_name' => 'Pemberdayaan Masyarakat',
            'icon' => '🌱',
            'color' => 'amber',
        ],
        self::BIDANG_BENCANA_DARURAT => [
            'code' => '5',
            'name' => 'Bidang Penanggulangan Bencana, Keadaan Darurat dan Mendesak Desa',
            'short_name' => 'Penanggulangan Bencana & Mendesak',
            'icon' => '🚨',
            'color' => 'rose',
        ],
    ];

    // --- Restrukturisasi Pos Pembiayaan Desa (Permendagri No. 20/2018) ---
    public const FINANCING_RECEIPT = 'receipt';       // Penerimaan Pembiayaan (Akun 6.1: SiLPA tahun sebelumnya, dll)

    public const FINANCING_EXPENDITURE = 'expenditure'; // Pengeluaran Pembiayaan (Akun 6.2: Penyertaan Modal BUMDes, dll)

    public const FINANCING_TYPES = [
        self::FINANCING_RECEIPT => [
            'code' => '6.1',
            'name' => 'Penerimaan Pembiayaan',
            'description' => 'Sisa Lebih Perhitungan Anggaran (SiLPA) tahun sebelumnya, pencairan dana cadangan, hasil penjualan kekayaan desa yang dipisahkan',
            'icon' => '📥',
            'color' => 'teal',
        ],
        self::FINANCING_EXPENDITURE => [
            'code' => '6.2',
            'name' => 'Pengeluaran Pembiayaan',
            'description' => 'Pembentukan dana cadangan, penyertaan modal BUMDes',
            'icon' => '📤',
            'color' => 'purple',
        ],
    ];

    protected $fillable = [
        'budget_id',
        'type',
        'sub_type',
        'code',
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

    /**
     * Memeriksa apakah item merupakan Penerimaan Pembiayaan (SiLPA dll).
     */
    public function isFinancingReceipt(): bool
    {
        if ($this->type !== self::TYPE_FINANCING) {
            return false;
        }

        if ($this->sub_type === self::FINANCING_RECEIPT) {
            return true;
        }

        $lower = strtolower($this->category);

        return str_contains($lower, 'penerimaan') || str_contains($lower, 'silpa');
    }

    /**
     * Memeriksa apakah item merupakan Pengeluaran Pembiayaan (Penyertaan Modal BUMDes dll).
     */
    public function isFinancingExpenditure(): bool
    {
        if ($this->type !== self::TYPE_FINANCING) {
            return false;
        }

        if ($this->sub_type === self::FINANCING_EXPENDITURE) {
            return true;
        }

        $lower = strtolower($this->category);

        return str_contains($lower, 'pengeluaran') || str_contains($lower, 'penyertaan') || str_contains($lower, 'bumdes');
    }

    /**
     * Mendapatkan informasi bidang belanja baku sesuai Permendagri No. 20/2018.
     *
     * @return array{code: string, name: string, short_name: string, icon: string, color: string}|null
     */
    public function getExpenditureFieldInfoAttribute(): ?array
    {
        if ($this->type !== self::TYPE_EXPENDITURE) {
            return null;
        }

        if ($this->sub_type && isset(self::EXPENDITURE_FIELDS[$this->sub_type])) {
            return self::EXPENDITURE_FIELDS[$this->sub_type];
        }

        // Resolusi fallback cerdas berbasis nama kategori untuk kompatibilitas data lama
        $lower = strtolower($this->category);
        if (str_contains($lower, 'pemerintahan')) {
            return self::EXPENDITURE_FIELDS[self::BIDANG_PEMERINTAHAN];
        }
        if (str_contains($lower, 'pembangunan')) {
            return self::EXPENDITURE_FIELDS[self::BIDANG_PEMBANGUNAN];
        }
        if (str_contains($lower, 'pembinaan')) {
            return self::EXPENDITURE_FIELDS[self::BIDANG_PEMBINAAN];
        }
        if (str_contains($lower, 'pemberdayaan')) {
            return self::EXPENDITURE_FIELDS[self::BIDANG_PEMBERDAYAAN];
        }
        if (str_contains($lower, 'bencana') || str_contains($lower, 'darurat') || str_contains($lower, 'mendesak')) {
            return self::EXPENDITURE_FIELDS[self::BIDANG_BENCANA_DARURAT];
        }

        return null;
    }

    /**
     * Label sub tipe / bidang baku.
     */
    public function getSubtypeLabelAttribute(): string
    {
        if ($this->type === self::TYPE_EXPENDITURE) {
            return $this->expenditure_field_info['short_name'] ?? $this->category;
        }

        if ($this->type === self::TYPE_FINANCING) {
            if ($this->isFinancingReceipt()) {
                return 'Penerimaan Pembiayaan (SiLPA)';
            }
            if ($this->isFinancingExpenditure()) {
                return 'Pengeluaran Pembiayaan (BUMDes)';
            }
        }

        return $this->sub_type ?? '-';
    }
}
