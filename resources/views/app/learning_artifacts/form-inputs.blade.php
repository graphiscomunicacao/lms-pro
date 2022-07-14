@php $editing = isset($learningArtifact) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <x-inputs.text
            name="name"
            label="Name"
            value="{{ old('name', ($editing ? $learningArtifact->name : '')) }}"
            maxlength="255"
            placeholder="Name"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.select name="type" label="Type">
            @php $selected = old('type', ($editing ? $learningArtifact->type : '')) @endphp
            <option value="audio" {{ $selected == 'audio' ? 'selected' : '' }} >Audio</option>
            <option value="document" {{ $selected == 'document' ? 'selected' : '' }} >Document</option>
            <option value="interactive" {{ $selected == 'interactive' ? 'selected' : '' }} >Interactive</option>
            <option value="image" {{ $selected == 'image' ? 'selected' : '' }} >Image</option>
            <option value="video" {{ $selected == 'video' ? 'selected' : '' }} >Video</option>
            <option value="externo" {{ $selected == 'externo' ? 'selected' : '' }} >Externo</option>
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.partials.label
            name="path"
            label="Path"
        ></x-inputs.partials.label
        ><br />

        <input type="file" name="path" id="path" class="form-control-file" />

        @if($editing && $learningArtifact->path)
        <div class="mt-2">
            <a
                href="{{ \Storage::url($learningArtifact->path) }}"
                target="_blank"
                ><i class="icon ion-md-download"></i>&nbsp;Download</a
            >
        </div>
        @endif @error('path') @include('components.inputs.partials.error')
        @enderror
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.number
            name="size"
            label="Size"
            value="{{ old('size', ($editing ? $learningArtifact->size : '')) }}"
            max="255"
            step="0.01"
            placeholder="Size"
            required
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.textarea
            name="description"
            label="Description"
            maxlength="255"
            >{{ old('description', ($editing ? $learningArtifact->description :
            '')) }}</x-inputs.textarea
        >
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.checkbox
            name="external"
            label="External"
            :checked="old('external', ($editing ? $learningArtifact->external : 0))"
        ></x-inputs.checkbox>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.url
            name="url"
            label="Url"
            value="{{ old('url', ($editing ? $learningArtifact->url : '')) }}"
            maxlength="255"
            placeholder="Url"
        ></x-inputs.url>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="cover_path"
            label="Cover Path"
            value="{{ old('cover_path', ($editing ? $learningArtifact->cover_path : '')) }}"
            maxlength="255"
            placeholder="Cover Path"
        ></x-inputs.text>
    </x-inputs.group>
</div>
