<?php

namespace App\Http\Controllers\Api;

use App\Models\Certificate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\CertificateResource;
use App\Http\Resources\CertificateCollection;
use App\Http\Requests\CertificateStoreRequest;
use App\Http\Requests\CertificateUpdateRequest;

class CertificateController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Certificate::class);

        $search = $request->get('search', '');

        $certificates = Certificate::search($search)
            ->latest()
            ->paginate();

        return new CertificateCollection($certificates);
    }

    /**
     * @param \App\Http\Requests\CertificateStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CertificateStoreRequest $request)
    {
        $this->authorize('create', Certificate::class);

        $validated = $request->validated();
        if ($request->hasFile('background_path')) {
            $validated['background_path'] = $request
                ->file('background_path')
                ->store('public');
        }

        $certificate = Certificate::create($validated);

        return new CertificateResource($certificate);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Certificate $certificate
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Certificate $certificate)
    {
        $this->authorize('view', $certificate);

        return new CertificateResource($certificate);
    }

    /**
     * @param \App\Http\Requests\CertificateUpdateRequest $request
     * @param \App\Models\Certificate $certificate
     * @return \Illuminate\Http\Response
     */
    public function update(
        CertificateUpdateRequest $request,
        Certificate $certificate
    ) {
        $this->authorize('update', $certificate);

        $validated = $request->validated();

        if ($request->hasFile('background_path')) {
            if ($certificate->background_path) {
                Storage::delete($certificate->background_path);
            }

            $validated['background_path'] = $request
                ->file('background_path')
                ->store('public');
        }

        $certificate->update($validated);

        return new CertificateResource($certificate);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Certificate $certificate
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Certificate $certificate)
    {
        $this->authorize('delete', $certificate);

        if ($certificate->background_path) {
            Storage::delete($certificate->background_path);
        }

        $certificate->delete();

        return response()->noContent();
    }
}
