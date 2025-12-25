<div class="max-w-xl mx-auto py-10">

    <h1 class="text-2xl font-bold mb-6">{{ $title }}</h1>

    @if (session()->has('success'))
        <div class="mb-4 text-green-600">
            {{ session('success') }}
        </div>
    @endif

    <form
        method="POST"
        action="{{ $action }}"
        class="space-y-4"
    >
        @csrf
        @if ($method !== 'POST')
            @method($method)
        @endif

        @foreach ($fields as $name => $type)
            <div>
                <label class="block mb-1 font-medium">
                    {{ ucfirst(str_replace('_', ' ', $name)) }}
                </label>

                @if ($type === 'textarea')
                    <textarea
                        name="{{ $name }}"
                        class="w-full border border-line rounded-md px-3 py-2"
                    >{{ old($name, $model->$name) }}</textarea>
                @else
                    <input
                        type="{{ $type }}"
                        name="{{ $name }}"
                        value="{{ old($name, $model->$name) }}"
                        class="w-full border border-line rounded-md px-3 py-2"
                    />
                @endif

                @error($name)
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
        @endforeach

        <div class="flex gap-3 pt-4">
            <button
                type="submit"
                class="bg-primary hover:opacity-80 text-white px-4 py-2 rounded-md"
            >
                Update
            </button>

            @if ($redirectRoute)
                <a
                    href="{{ route($redirectRoute) }}"
                    class="px-4 py-2 border hover:opacity-80 border-line rounded-md"
                >
                    Cancel
                </a>
            @endif
        </div>

    </form>

</div>
