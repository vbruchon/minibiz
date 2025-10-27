@props([
'type' => 'success',
'message' => '',
])

@if($message)
<div
    id="toast"
    class="fixed bottom-5 right-5 z-[9999] text-white font-medium
           px-5 py-3 rounded-md shadow-lg transition-opacity duration-500
           {{ $type === 'success' ? 'bg-primary' : 'bg-destructive' }}">
    {{ $message }}
</div>

<script>
    setTimeout(() => {
        const toast = document.getElementById("toast");
        if (toast) {
            toast.style.opacity = "0";
            setTimeout(() => toast.remove(), 500);
        }
    }, 3000);
</script>
@endif