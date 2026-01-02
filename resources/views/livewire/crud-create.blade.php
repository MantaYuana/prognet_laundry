<div class="max-w-xl mx-auto py-10">

    <h1 class="text-2xl font-bold mb-6">{{ $title }}</h1>

    @if (session()->has('success'))
        <div class="mb-4 text-green-600">
            {{ session('success') }}
        </div>
    @endif

    <form wire:submit.prevent="save" class="space-y-4">

        @foreach($fields as $name => $type)
            <div>
                <label class="block mb-1 font-medium">
                    {{ ucfirst(str_replace('_', ' ', $name)) }}
                </label>

                @if($type === 'textarea')
                    <textarea
                        wire:model.defer="form.{{ $name }}"
                        class="w-full border border-line rounded-md px-3 py-2"
                    ></textarea>
                @else
                    <input
                        type="{{ $type }}"
                        wire:model.defer="form.{{ $name }}"
                        class="w-full border border-line rounded-md px-3 py-2"
                    />
                @endif

                @error("form.$name")
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
        @endforeach

        <div class="flex gap-3 pt-4">
            <button
                type="submit"
                class="bg-primary text-white px-4 py-2 rounded-md cursor-pointer hover:opacity-80"
            >
                + Create
            </button>

            @if($redirectRoute)
                <a
                    href="{{ route($redirectRoute) }}"
                    class="px-4 py-2 border rounded-md cursor-pointer border-line hover:opacity-80"
                >
                    Cancel
                </a>
            @endif
        </div>

    </form>

</div>
