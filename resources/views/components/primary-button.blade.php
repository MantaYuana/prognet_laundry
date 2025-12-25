<button
    {{ $attributes->merge([
        'type' => 'submit',
        'class' => '
            inline-flex items-center justify-center
            px-5 py-2.5
            bg-primary text-white
            text-sm font-semibold tracking-wide
            rounded-md
            shadow-sm

            hover:bg-primary-dark hover:shadow-md
            active:bg-primary-dark active:scale-[0.98]

            focus:outline-none
            focus:ring-2 focus:ring-primary focus:ring-offset-2

            transition-all duration-200 ease-in-out
        '
    ]) }}
>
    {{ $slot }}
</button>
