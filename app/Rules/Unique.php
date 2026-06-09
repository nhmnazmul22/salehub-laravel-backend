<?php

namespace App\Rules;

use AllowDynamicProperties;
use Closure;
use DB;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;
use Schema;

#[AllowDynamicProperties]
class Unique implements ValidationRule
{

    /**
     * Create a new rule instance.
     */
    public function __construct(string $table, string $column, ?int $ignoreId = null, ?string $ignorePrimaryKey = 'id')
    {
        $this->table = $table;
        $this->column = $column;
        $this->ignoreId = $ignoreId;
        $this->ignorePrimaryKey = $ignorePrimaryKey;
    }

    /**
     * Run the validation rule.
     *
     * @param Closure(string, ?string=): PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {

        if (blank($value)) {
            return;
        }

        $query = DB::table($this->table)
            ->where($this->column, $value)
            ->when($this->ignoreId, fn($q) => $q->where($this->ignorePrimaryKey, '!=', $this->ignoreId)
            );

        if (Schema::hasColumn($this->table, 'deleted_at')) {
            $query->whereNull('deleted_at');
        }

        $exists = $query->exists();

        if ($exists) {
            $fail(__('validation.unique'));
        }
    }
}
