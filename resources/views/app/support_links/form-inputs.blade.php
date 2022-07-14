@php $editing = isset($supportLink) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <x-inputs.text
            name="name"
            label="Name"
            value="{{ old('name', ($editing ? $supportLink->name : '')) }}"
            maxlength="255"
            placeholder="Name"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.url
            name="url"
            label="Url"
            value="{{ old('url', ($editing ? $supportLink->url : '')) }}"
            maxlength="255"
            placeholder="Url"
            required
        ></x-inputs.url>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.checkbox
            name="same_tab"
            label="Same Tab"
            :checked="old('same_tab', ($editing ? $supportLink->same_tab : 0))"
        ></x-inputs.checkbox>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <div
            x-data="imageViewer('{{ $editing && $supportLink->cover_path ? \Storage::url($supportLink->cover_path) : '' }}')"
        >
            <x-inputs.partials.label
                name="cover_path"
                label="Cover Path"
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
                    name="cover_path"
                    id="cover_path"
                    @change="fileChosen"
                />
            </div>

            @error('cover_path') @include('components.inputs.partials.error')
            @enderror
        </div>
    </x-inputs.group>
</div>
