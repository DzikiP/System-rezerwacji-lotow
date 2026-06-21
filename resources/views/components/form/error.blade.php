@php
    $messages = collect($errors->getMessages());

    $error = null;

    foreach ($messages as $key => $list) {
        $normalizedKey = preg_replace('/\.[a-f0-9\-]{36}\./', '.', $key);

        if (str_contains($normalizedKey, str_replace('*', '', $field))) {
            $error = $list[0] ?? null;
            break;
        }
    }
@endphp

@if ($error)
    <p class="text-red-400 text-sm mt-1">
        {{ $error }}
    </p>
@endif
