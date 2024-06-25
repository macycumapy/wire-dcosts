@props([
  'message',
  'placement' => 'right-start',
  'maxWidth' => 250,
  'onClick' => false,
])

<div x-data="{
    message: @toJs($message),
    placement: @toJs($placement),
    maxWidth: @toJs($maxWidth),
    trigger: @toJs($onClick ? 'click' : 'mouseenter'),
}" {{ $attributes->merge(['class' => 'w-max']) }}>
    <span x-tooltip="{
        content: message,
        placement: placement,
        delay: 100,
        maxWidth: maxWidth,
        theme:'light-border',
        interactive: true,
        trigger: trigger,
    }">{{ $slot }}</span>
</div>
