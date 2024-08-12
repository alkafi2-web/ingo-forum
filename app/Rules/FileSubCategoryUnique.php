<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use App\Models\FileCategory;

class FileSubCategoryUnique implements ValidationRule
{
    protected $subCatName;

    /**
     * Create a new rule instance.
     *
     * @param  string  $subCatName
     * @return void
     */
    public function __construct($subCatName)
    {
        $this->subCatName = $subCatName;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Fetch the category from the database where name = $this->subCatName and parent_id != 0
        $category = FileCategory::where('name', $this->subCatName)
            ->where('parent_id', '!=', 0)
            ->first();

        if ($category) {
            $fail('The :attribute must be unique within the same subcategory.');
        }
    }
}
