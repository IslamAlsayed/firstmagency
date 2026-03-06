<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\FAQ\StoreRequest;
use App\Http\Requests\FAQ\UpdateRequest;
use App\Models\FAQ;
use App\Traits\GlobalDestroyTrait;
use Illuminate\Support\Facades\Auth;

class FAQController extends Controller
{
    use GlobalDestroyTrait;

    public function index()
    {
        $this->authorize('viewAny', FAQ::class);
        $faqs = FAQ::with(['creator', 'updater'])->latest()->paginate(25);
        return view('dashboard.faqs.index', compact('faqs'));
    }

    public function create()
    {
        $this->authorize('create', FAQ::class);
        return view('dashboard.faqs.create', ['categories' => FAQ::CATEGORIES]);
    }

    public function store(StoreRequest $request)
    {
        $this->authorize('create', FAQ::class);
        $validated = $request->validated();
        $validated['created_by'] = Auth::id();
        $validated['updated_by'] = Auth::id();
        $faq = FAQ::create($validated);
        return redirect()->route('dashboard.faqs.show', $faq)->withSuccess(__('messages.type_created_successfully', ['type' => __('main.faq')]));
    }

    public function show(FAQ $faq)
    {
        $this->authorize('view', $faq);
        $faq->load(['creator', 'updater']);
        return view('dashboard.faqs.show', compact('faq'));
    }

    public function edit(FAQ $faq)
    {
        $this->authorize('update', $faq);
        return view('dashboard.faqs.edit', ['faq' => $faq, 'categories' => FAQ::CATEGORIES]);
    }

    public function update(UpdateRequest $request, $id)
    {
        $faq = FAQ::find($id);
        if (!$faq)
            return redirect()->route('dashboard.faqs.index')->withError(__('messages.type_not_found', ['type' => __('main.faq')]));
        $this->authorize('update', $faq);
        $validated = $request->validated();
        $validated['updated_by'] = Auth::id();
        $faq->update($validated);
        return redirect()->route('dashboard.faqs.show', $faq)->withSuccess(__('messages.type_updated_successfully', ['type' => __('main.faq')]));
    }

    public function destroy(FAQ $faq)
    {
        $this->authorize('delete', $faq);
        $faq->delete();
        return redirect()->route('dashboard.faqs.index')->withSuccess(__('messages.type_deleted_successfully', ['type' => __('main.faq')]));
    }
}
