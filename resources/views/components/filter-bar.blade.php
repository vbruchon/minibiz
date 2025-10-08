@props([
'route' => route('customers.index'),
'currentStatus' => request('status'),
])

<div class="mb-4">
    <form action="{{ $route }}" method="GET" id="filterBar">
        <div>
            <label for="filterStatus" class="sr-only">Status</label>
            <select name="status" id="filterStatus"
                class="px-3 py-2 bg-gray-700 border border-gray-600 text-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary"
                onchange="submitStatusForm(this)">
                <option value="" {{ is_null($currentStatus) || $currentStatus === '' ? 'selected' : '' }}>Status</option>
                <option value="active" {{ $currentStatus === 'active' ? 'selected' : '' }}>Active</option>
                <option value="prospect" {{ $currentStatus === 'prospect' ? 'selected' : '' }}>Prospect</option>
                <option value="inactive" {{ $currentStatus === 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>
    </form>
</div>

<script>
    function submitStatusForm(select) {
        const form = select.form;
        const value = select.value;

        if (!value) {
            const url = new URL(form.action, window.location.origin);
            const params = new URLSearchParams(new FormData(form));

            params.delete('status');

            const queryString = params.toString();
            window.location.href = queryString ? url.pathname + '?' + queryString : url.pathname;
        } else {
            form.submit();
        }
    }
</script>