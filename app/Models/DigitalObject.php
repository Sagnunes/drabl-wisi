<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DigitalObject extends Model
{
    /** @use HasFactory<\Database\Factories\DigitalObjectFactory> */
    use HasFactory;

    public $timestamps = false;

    /*
   * Get the fund that owns the resource.
   */
    public function fund(): BelongsTo
    {
        return $this->belongsTo(Fund::class);
    }

    /*
     * Get the resource with the given fund.
     */
    public function scopeWithFund($query, $fund)
    {
        return $query->with('fund')->whereBelongsTo($fund);
    }

    /*
     * Get the resource with the given search.
     */
    public function scopeWithSearch($query, string $search, string $fund_id)
    {
        return $query->where(function ($q) use ($search, $fund_id) {
            $q->where('title', 'LIKE', "%{$search}%")
                ->orWhere('fund_id', 'LIKE', $fund_id)
                ->where('inventory_number', 'LIKE', "%{$search}%");
        });
    }

    /*
     * Order the resources by status and inventory number.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('status', 'desc')
            ->orderByRaw(
                'CAST(SUBSTR(inventory_number, INSTR(inventory_number, "/") + 1) AS INTEGER)'
            );
    }
}
