<?php

namespace App\Http\Controllers;

use App\Models\SupportLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\SupportLinkStoreRequest;
use App\Http\Requests\SupportLinkUpdateRequest;

class SupportLinkController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', SupportLink::class);

        $search = $request->get('search', '');

        $supportLinks = SupportLink::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view(
            'app.support_links.index',
            compact('supportLinks', 'search')
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', SupportLink::class);

        return view('app.support_links.create');
    }

    /**
     * @param \App\Http\Requests\SupportLinkStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(SupportLinkStoreRequest $request)
    {
        $this->authorize('create', SupportLink::class);

        $validated = $request->validated();
        if ($request->hasFile('cover_path')) {
            $validated['cover_path'] = $request
                ->file('cover_path')
                ->store('public');
        }

        $supportLink = SupportLink::create($validated);

        return redirect()
            ->route('support-links.edit', $supportLink)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\SupportLink $supportLink
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, SupportLink $supportLink)
    {
        $this->authorize('view', $supportLink);

        return view('app.support_links.show', compact('supportLink'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\SupportLink $supportLink
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, SupportLink $supportLink)
    {
        $this->authorize('update', $supportLink);

        return view('app.support_links.edit', compact('supportLink'));
    }

    /**
     * @param \App\Http\Requests\SupportLinkUpdateRequest $request
     * @param \App\Models\SupportLink $supportLink
     * @return \Illuminate\Http\Response
     */
    public function update(
        SupportLinkUpdateRequest $request,
        SupportLink $supportLink
    ) {
        $this->authorize('update', $supportLink);

        $validated = $request->validated();
        if ($request->hasFile('cover_path')) {
            if ($supportLink->cover_path) {
                Storage::delete($supportLink->cover_path);
            }

            $validated['cover_path'] = $request
                ->file('cover_path')
                ->store('public');
        }

        $supportLink->update($validated);

        return redirect()
            ->route('support-links.edit', $supportLink)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\SupportLink $supportLink
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, SupportLink $supportLink)
    {
        $this->authorize('delete', $supportLink);

        if ($supportLink->cover_path) {
            Storage::delete($supportLink->cover_path);
        }

        $supportLink->delete();

        return redirect()
            ->route('support-links.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
