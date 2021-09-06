<?php

namespace App\Http\Livewire;

use App\Models\Stock;
use Livewire\Component;
use App\Models\Company;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CompanyStocksDetail extends Component
{
    use AuthorizesRequests;

    public Company $company;
    public Stock $stock;

    public $selected = [];
    public $editing = false;
    public $allSelected = false;
    public $showingModal = false;

    public $modalTitle = 'New Stock';

    protected $rules = [
        'stock.name' => ['required', 'max:255', 'string'],
        'stock.price' => ['required', 'numeric'],
        'stock.quantity' => ['required', 'numeric'],
        'stock.total' => ['required', 'numeric'],
        'stock.stock' => ['required', 'numeric'],
    ];

    public function mount(Company $company)
    {
        $this->company = $company;
        $this->resetStockData();
    }

    public function resetStockData()
    {
        $this->stock = new Stock();

        $this->dispatchBrowserEvent('refresh');
    }

    public function newStock()
    {
        $this->editing = false;
        $this->modalTitle = trans('crud.company_stocks.new_title');
        $this->resetStockData();

        $this->showModal();
    }

    public function editStock(Stock $stock)
    {
        $this->editing = true;
        $this->modalTitle = trans('crud.company_stocks.edit_title');
        $this->stock = $stock;

        $this->dispatchBrowserEvent('refresh');

        $this->showModal();
    }

    public function showModal()
    {
        $this->resetErrorBag();
        $this->showingModal = true;
    }

    public function hideModal()
    {
        $this->showingModal = false;
    }

    public function save()
    {
        $this->validate();

        if (!$this->stock->company_id) {
            $this->authorize('create', Stock::class);

            $this->stock->company_id = $this->company->id;
        } else {
            $this->authorize('update', $this->stock);
        }

        $this->stock->save();

        $this->hideModal();
    }

    public function destroySelected()
    {
        $this->authorize('delete-any', Stock::class);

        Stock::whereIn('id', $this->selected)->delete();

        $this->selected = [];
        $this->allSelected = false;

        $this->resetStockData();
    }

    public function toggleFullSelection()
    {
        if (!$this->allSelected) {
            $this->selected = [];
            return;
        }

        foreach ($this->company->stocks as $stock) {
            array_push($this->selected, $stock->id);
        }
    }

    public function render()
    {
        return view('livewire.company-stocks-detail', [
            'stocks' => $this->company->stocks()->paginate(20),
        ]);
    }
}
