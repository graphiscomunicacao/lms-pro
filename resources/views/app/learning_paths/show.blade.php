<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('crud.learning_paths.show_title')
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-partials.card>
                <x-slot name="title">
                    <a href="{{ route('learning-paths.index') }}" class="mr-4"
                        ><i class="mr-1 icon ion-md-arrow-back"></i
                    ></a>
                </x-slot>

                <div class="mt-4 px-4">
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.learning_paths.inputs.name')
                        </h5>
                        <span>{{ $learningPath->name ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.learning_paths.inputs.description')
                        </h5>
                        <span>{{ $learningPath->description ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.learning_paths.inputs.start_time')
                        </h5>
                        <span>{{ $learningPath->start_time ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.learning_paths.inputs.end_time')
                        </h5>
                        <span>{{ $learningPath->end_time ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.learning_paths.inputs.availability_time')
                        </h5>
                        <span
                            >{{ $learningPath->availability_time ?? '-' }}</span
                        >
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.learning_paths.inputs.cover_path')
                        </h5>
                        <x-partials.thumbnail
                            src="{{ $learningPath->cover_path ? \Storage::url($learningPath->cover_path) : '' }}"
                            size="150"
                        />
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.learning_paths.inputs.tries')
                        </h5>
                        <span>{{ $learningPath->tries ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.learning_paths.inputs.passing_score')
                        </h5>
                        <span>{{ $learningPath->passing_score ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.learning_paths.inputs.approval_goal')
                        </h5>
                        <span>{{ $learningPath->approval_goal ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.learning_paths.inputs.certificate_id')
                        </h5>
                        <span
                            >{{ optional($learningPath->certificate)->name ??
                            '-' }}</span
                        >
                    </div>
                </div>

                <div class="mt-10">
                    <a
                        href="{{ route('learning-paths.index') }}"
                        class="button"
                    >
                        <i class="mr-1 icon ion-md-return-left"></i>
                        @lang('crud.common.back')
                    </a>

                    @can('create', App\Models\LearningPath::class)
                    <a
                        href="{{ route('learning-paths.create') }}"
                        class="button"
                    >
                        <i class="mr-1 icon ion-md-add"></i>
                        @lang('crud.common.create')
                    </a>
                    @endcan
                </div>
            </x-partials.card>
        </div>
    </div>
</x-app-layout>
