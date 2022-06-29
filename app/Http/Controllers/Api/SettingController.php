<?php

namespace App\Http\Controllers\Api;

use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SettingResource;
use App\Http\Resources\SettingCollection;
use App\Http\Requests\SettingStoreRequest;
use App\Http\Requests\SettingUpdateRequest;

class SettingController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Setting::class);

        $search = $request->get('search', '');

        $settings = Setting::search($search)
            ->latest()
            ->paginate();

        return new SettingCollection($settings);
    }

    /**
     * @param \App\Http\Requests\SettingStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(SettingStoreRequest $request)
    {
        $this->authorize('create', Setting::class);

        $validated = $request->validated();

        $setting = Setting::create($validated);

        return new SettingResource($setting);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Setting $setting
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Setting $setting)
    {
        $this->authorize('view', $setting);

        return new SettingResource($setting);
    }

    /**
     * @param \App\Http\Requests\SettingUpdateRequest $request
     * @param \App\Models\Setting $setting
     * @return \Illuminate\Http\Response
     */
    public function update(SettingUpdateRequest $request, Setting $setting)
    {
        $this->authorize('update', $setting);

        $validated = $request->validated();

        $setting->update($validated);

        return new SettingResource($setting);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Setting $setting
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Setting $setting)
    {
        $this->authorize('delete', $setting);

        $setting->delete();

        return response()->noContent();
    }
}
