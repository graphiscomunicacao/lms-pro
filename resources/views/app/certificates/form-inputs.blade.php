@php $editing = isset($certificate) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <x-inputs.text
            name="name"
            label="Name"
            value="{{ old('name', ($editing ? $certificate->name : '')) }}"
            maxlength="255"
            placeholder="Name"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.textarea
            name="description"
            label="Description"
            maxlength="255"
            >{{ old('description', ($editing ? $certificate->description : ''))
            }}</x-inputs.textarea
        >
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <div
            x-data="imageViewer('{{ $editing && $certificate->background_path ? \Storage::url($certificate->background_path) : '' }}')"
        >
            <x-inputs.partials.label
                name="background_path"
                label="Background Path"
            ></x-inputs.partials.label
            ><br />

            <!-- Show the image -->
            <template x-if="imageUrl">
                <img
                    :src="imageUrl"
                    class="object-cover rounded border border-gray-200"
                    style="width: 100px; height: 100px;"
                />
            </template>

            <!-- Show the gray box when image is not available -->
            <template x-if="!imageUrl">
                <div
                    class="border rounded border-gray-200 bg-gray-100"
                    style="width: 100px; height: 100px;"
                ></div>
            </template>

            <div class="mt-2">
                <input
                    type="file"
                    name="background_path"
                    id="background_path"
                    @change="fileChosen"
                />
            </div>

            @error('background_path')
            @include('components.inputs.partials.error') @enderror
        </div>
    </x-inputs.group>
</div>
