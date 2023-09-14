@error($name)
    <p {{ $attributes->merge(['class' => 'mt-2 text-sm text-negative-500']) }}>
        {{ $message }}
    </p>
@enderror
