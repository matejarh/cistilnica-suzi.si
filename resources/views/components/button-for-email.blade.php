@props([
    'url',
    'color' => 'primary',
    'align' => 'center',
])

<a href="{!! $url !!}" class="button" style="display: inline-block;
    padding: 10px 20px;
    font-size: 16px;
    color: #ffffff !important;
    background-color: {{$color === 'primary' ? '#0ea5e9' : '#6b7280'}};
    text-decoration: none;
    border-radius: 5px;
    margin-top: 20px;">
        {{ $slot }}
</a>
