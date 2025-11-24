<x-button variant="outline" size="icon" id="theme-toggle-button">
  <x-heroicon-s-sun id="theme-icon-sun" class="size-4 text-muted-foreground hidden" />
  <x-heroicon-s-moon id="theme-icon-moon" class="size-4 text-muted hidden" />
</x-button>

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', () => {
    const html = document.documentElement;

    const btn = document.getElementById('theme-toggle-button');
    const sun = document.getElementById('theme-icon-sun');
    const moon = document.getElementById('theme-icon-moon');

    function updateIcons() {
      const isDark = html.classList.contains('dark');
      moon.classList.toggle('hidden', !isDark);
      sun.classList.toggle('hidden', isDark);
    }

    updateIcons();

    btn?.addEventListener('click', () => {
      html.classList.toggle('dark');
      localStorage.setItem('theme', html.classList.contains('dark') ? 'dark' : 'light');
      updateIcons();
    });
  });
</script>
@endpush