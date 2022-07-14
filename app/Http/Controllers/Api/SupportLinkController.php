<?php

namespace App\Http\Controllers\Api;

use App\Models\SupportLink;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\SupportLinkResource;
use App\Http\Resources\SupportLinkCollection;
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
            ->paginate();

        return new SupportLinkCollection($supportLinks);
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

        return new SupportLinkResource($supportLink);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\SupportLink $supportLink
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, SupportLink $supportLink)
    {
        $this->authorize('view', $supportLink);

        return new SupportLinkResource($supportLink);
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

        return new SupportLinkResource($supportLink);
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

        return response()->noContent();
    }
}
