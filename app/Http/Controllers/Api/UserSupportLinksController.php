<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SupportLinkResource;
use App\Http\Resources\SupportLinkCollection;

class UserSupportLinksController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, User $user)
    {
        $this->authorize('view', $user);

        $search = $request->get('search', '');

        $supportLinks = $user
            ->supportLinks()
            ->search($search)
            ->latest()
            ->paginate();

        return new SupportLinkCollection($supportLinks);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user)
    {
        $this->authorize('create', SupportLink::class);

        $validated = $request->validate([
            'name' => ['required', 'max:255', 'string'],
            'url' => ['required', 'url'],
            'same_tab' => ['required', 'boolean'],
        ]);

        $supportLink = $user->supportLinks()->create($validated);

        return new SupportLinkResource($supportLink);
    }
}
