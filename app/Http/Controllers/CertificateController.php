<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
            ->paginate(5)
            ->withQueryString();

        return view(
            'app.certificates.index',
            compact('certificates', 'search')
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Certificate::class);

        return view('app.certificates.create');
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

        return redirect()
            ->route('certificates.edit', $certificate)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Certificate $certificate
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Certificate $certificate)
    {
        $this->authorize('view', $certificate);

        return view('app.certificates.show', compact('certificate'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Certificate $certificate
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Certificate $certificate)
    {
        $this->authorize('update', $certificate);

        return view('app.certificates.edit', compact('certificate'));
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

        return redirect()
            ->route('certificates.edit', $certificate)
            ->withSuccess(__('crud.common.saved'));
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

        return redirect()
            ->route('certificates.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
