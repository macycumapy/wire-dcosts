<?php

declare(strict_types=1);

namespace App\Actions\Category;

use App\Actions\Category\Data\UpdateCategoryData;

class UpdateCategoryAction
{
    public function exec(UpdateCategoryData $data): bool
    {
        $category = $data->category;
        $category->name = $data->name;

        return $category->save();
    }
}
