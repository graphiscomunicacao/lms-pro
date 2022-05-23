<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('crud.learning_paths.index_title')
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-partials.card>
                <div class="mb-5 mt-4">
                    <div class="flex flex-wrap justify-between">
                        <div class="md:w-1/2">
                            <form>
                                <div class="flex items-center w-full">
                                    <x-inputs.text
                                        name="search"
                                        value="{{ $search ?? '' }}"
                                        placeholder="{{ __('crud.common.search') }}"
                                        autocomplete="off"
                                    ></x-inputs.text>

                                    <div class="ml-1">
                                        <button
                                            type="submit"
                                            class="button button-primary"
                                        >
                                            <i class="icon ion-md-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="md:w-1/2 text-right">
                            @can('create', App\Models\LearningPath::class)
                            <a
                                href="{{ route('learning-paths.create') }}"
                                class="button button-primary"
                            >
                                <i class="mr-1 icon ion-md-add"></i>
                                @lang('crud.common.create')
                            </a>
                            @endcan
                        </div>
                    </div>
                </div>

                <div class="block w-full overflow-auto scrolling-touch">
                    <table class="w-full max-w-full mb-4 bg-transparent">
                        <thead class="text-gray-700">
                            <tr>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.learning_paths.inputs.name')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.learning_paths.inputs.description')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.learning_paths.inputs.start_time')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.learning_paths.inputs.end_time')
                                </th>
                                <th class="px-4 py-3 text-right">
                                    @lang('crud.learning_paths.inputs.availability_time')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.learning_paths.inputs.cover_path')
                                </th>
                                <th class="px-4 py-3 text-right">
                                    @lang('crud.learning_paths.inputs.tries')
                                </th>
                                <th class="px-4 py-3 text-right">
                                    @lang('crud.learning_paths.inputs.passing_score')
                                </th>
                                <th class="px-4 py-3 text-right">
                                    @lang('crud.learning_paths.inputs.approval_goal')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.learning_paths.inputs.certificate_id')
                                </th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600">
                            @forelse($learningPaths as $learningPath)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-left">
                                    {{ $learningPath->name ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ $learningPath->description ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ $learningPath->start_time ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ $learningPath->end_time ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-right">
                                    {{ $learningPath->availability_time ?? '-'
                                    }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    <x-partials.thumbnail
                                        src="{{ $learningPath->cover_path ? \Storage::url($learningPath->cover_path) : '' }}"
                                    />
                                </td>
                                <td class="px-4 py-3 text-right">
                                    {{ $learningPath->tries ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-right">
                                    {{ $learningPath->passing_score ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-right">
                                    {{ $learningPath->approval_goal ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{
                                    optional($learningPath->certificate)->name
                                    ?? '-' }}
                                </td>
                                <td
                                    class="px-4 py-3 text-center"
                                    style="width: 134px;"
                                >
                                    <div
                                        role="group"
                                        aria-label="Row Actions"
                                        class="
                                            relative
                                            inline-flex
                                            align-middle
                                        "
                                    >
                                        @can('update', $learningPath)
                                        <a
                                            href="{{ route('learning-paths.edit', $learningPath) }}"
                                            class="mr-1"
                                        >
                                            <button
                                                type="button"
                                                class="button"
                                            >
                                                <i
                                                    class="icon ion-md-create"
                                                ></i>
                                            </button>
                                        </a>
                                        @endcan @can('view', $learningPath)
                                        <a
                                            href="{{ route('learning-paths.show', $learningPath) }}"
                                            class="mr-1"
                                        >
                                            <button
                                                type="button"
                                                class="button"
                                            >
                                                <i class="icon ion-md-eye"></i>
                                            </button>
                                        </a>
                                        @endcan @can('delete', $learningPath)
                                        <form
                                            action="{{ route('learning-paths.destroy', $learningPath) }}"
                                            method="POST"
                                            onsubmit="return confirm('{{ __('crud.common.are_you_sure') }}')"
                                        >
                                            @csrf @method('DELETE')
                                            <button
                                                type="submit"
                                                class="button"
                                            >
                                                <i
                                                    class="
                                                        icon
                                                        ion-md-trash
                                                        text-red-600
                                                    "
                                                ></i>
                                            </button>
                                        </form>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="11">
                                    @lang('crud.common.no_items_found')
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="11">
                                    <div class="mt-10 px-4">
                                        {!! $learningPaths->render() !!}
                                    </div>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </x-partials.card>
        </div>
    </div>
</x-app-layout>
