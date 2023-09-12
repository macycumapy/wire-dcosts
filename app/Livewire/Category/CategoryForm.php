<?php

declare(strict_types=1);

namespace App\Livewire\Category;

use App\Actions\Category\CreateCategoryAction;
use App\Actions\Category\Data\CategoryData;
use App\Actions\Category\Data\UpdateCategoryData;
use App\Actions\Category\UpdateCategoryAction;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Livewire\Component;
use WireUi\Traits\Actions;

class CategoryForm extends Component
{
    use Actions;

    public const CATEGORY_SAVED_EVENT = 'categorySavedEvent';
    public ?Category $category = null;
    public CategoryData $data;

    public function mount(?int $id = null): void
    {
        if ($id) {
            $this->category = Category::findOrFail($id);
            $this->data = CategoryData::from($this->category);
        } else {
            $this->resetData();
        }
    }

    private function resetData(): void
    {
        $this->data = CategoryData::from([
            'user_id' => Auth::id(),
        ]);
    }

    public function create(CreateCategoryAction $action): void
    {
        $action->exec(CategoryData::validateAndCreate($this->data));
        $this->dispatch(self::CATEGORY_SAVED_EVENT);
        $this->notification()->success('Категория', 'Добавлена');
        $this->resetData();
    }

    public function update(UpdateCategoryAction $action): void
    {
        $action->exec(UpdateCategoryData::validateAndCreate([
            ...$this->data->toArray(),
            'category' => $this->category,
        ]));
        $this->dispatch(self::CATEGORY_SAVED_EVENT);
        $this->notification()->success('Категория', 'Изменена');
    }

    public function render(): View
    {
        return view('livewire.category.category-form');
    }
}
