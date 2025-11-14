@props([
'type' => 'success', // success | error | warning | info
'message' => '',
])

@php
$styles = [
'success' => 'bg-green-600 text-white border-green-500',
'error' => 'bg-red-600 text-white border-red-500',
'warning' => 'bg-warning text-white border-amber-500',
'info' => 'bg-blue-600 text-white border-blue-500',
];

$icons = [
'success' => 'check-circle',
'error' => 'x-circle',
'warning' => 'exclamation-triangle',
'info' => 'information-circle',
];
@endphp

@if($message)
<div
    id="toast"
    class="fixed bottom-5 right-5 z-[9999]
           flex items-center gap-3 px-5 py-3 font-medium rounded-lg shadow-xl border-l-4
           opacity-0 translate-x-10
           transition-all duration-300 ease-out
           {{ $styles[$type] }}">


    <x-dynamic-component
        :component="'heroicon-o-' . $icons[$type]"
        class="w-6 h-6 opacity-90" />

    <span>{{ $message }}</span>

    <button
        id="toast-close"
        class="ml-3 text-white/70 hover:text-white text-xl leading-none font-bold">
        ×
    </button>
</div>
@endif


@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const toast = document.getElementById("toast");
        const closeBtn = document.getElementById("toast-close");

        if (!toast) return;

        requestAnimationFrame(() => {
            toast.classList.remove("opacity-0", "translate-x-10");
            toast.classList.add("opacity-100", "translate-x-0");
        });

        const hideToast = () => {
            toast.classList.remove("opacity-100", "translate-x-0");
            toast.classList.add("opacity-0", "translate-x-10");

            setTimeout(() => toast.remove(), 300);
        };

        setTimeout(hideToast, 5000);

        closeBtn.addEventListener("click", hideToast);
    });
</script>
@endpush