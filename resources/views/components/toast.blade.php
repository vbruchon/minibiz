@props([
'type' => 'success',
'message' => '',
])

<style>
    .toast {
        position: fixed;
        bottom: 20px;
        right: 20px;
        color: white;
        padding: 12px 20px;
        border-radius: 6px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
        font-weight: 500;
        z-index: 9999;
        transition: opacity 0.5s ease;
    }

    .toast-success {
        background-color: #16a34a;
    }

    .toast-error {
        background-color: #dc2626;
    }
</style>
@if($message)
<div id="toast" class="toast {{ $type === 'success' ? 'toast-success' : 'toast-error' }}">
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