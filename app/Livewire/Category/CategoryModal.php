<?php

declare(strict_types=1);

namespace App\Livewire\Category;

use App\Livewire\Traits\AsModal;
use Illuminate\View\View;
use Livewire\Component;

class CategoryModal extends Component
{
    use AsModal;

    public $listeners = [
        CategoryForm::CATEGORY_SAVED_EVENT => 'closeModal'
    ];

    public function render(): View
    {
        return view('livewire.category.category-modal');
    }
}
