@php $editing = isset($learningPath) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <x-inputs.text
            name="name"
            label="Name"
            value="{{ old('name', ($editing ? $learningPath->name : '')) }}"
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
            >{{ old('description', ($editing ? $learningPath->description : ''))
            }}</x-inputs.textarea
        >
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.datetime
            name="start_time"
            label="Start Time"
            value="{{ old('start_time', ($editing ? optional($learningPath->start_time)->format('Y-m-d\TH:i:s') : '')) }}"
            max="255"
        ></x-inputs.datetime>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.datetime
            name="end_time"
            label="End Time"
            value="{{ old('end_time', ($editing ? optional($learningPath->end_time)->format('Y-m-d\TH:i:s') : '')) }}"
            max="255"
        ></x-inputs.datetime>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.number
            name="availability_time"
            label="Availability Time"
            value="{{ old('availability_time', ($editing ? $learningPath->availability_time : '')) }}"
            max="255"
            placeholder="Availability Time"
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <div
            x-data="imageViewer('{{ $editing && $learningPath->cover_path ? \Storage::url($learningPath->cover_path) : '' }}')"
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

    <x-inputs.group class="w-full">
        <x-inputs.number
            name="tries"
            label="Tries"
            value="{{ old('tries', ($editing ? $learningPath->tries : '')) }}"
            max="255"
            placeholder="Tries"
            required
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.number
            name="passing_score"
            label="Passing Score"
            value="{{ old('passing_score', ($editing ? $learningPath->passing_score : '')) }}"
            max="255"
            placeholder="Passing Score"
            required
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.number
            name="approval_goal"
            label="Approval Goal"
            value="{{ old('approval_goal', ($editing ? $learningPath->approval_goal : '')) }}"
            max="255"
            placeholder="Approval Goal"
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.select name="certificate_id" label="Certificate" required>
            @php $selected = old('certificate_id', ($editing ? $learningPath->certificate_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Certificate</option>
            @foreach($certificates as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>
</div>
