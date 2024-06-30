@error($name)
    <p {{ $attributes->class('mt-2 text-sm text-negative-500') }}>
        {{ $message }}
    </p>
@enderror
