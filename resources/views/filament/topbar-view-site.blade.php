<a href="{{ url('/') }}"
   target="_blank"
   class="flex items-center gap-1.5 px-3 py-1.5 text-sm font-medium rounded-lg
          text-gray-600 dark:text-gray-300
          hover:bg-gray-100 dark:hover:bg-white/5
          hover:text-gray-900 dark:hover:text-white
          transition-colors duration-150"
   title="{{ app()->getLocale() === 'da' ? 'Se hjemmeside' : 'View site' }}">
    <x-heroicon-o-arrow-top-right-on-square class="w-4 h-4 shrink-0" />
    <span class="hidden sm:inline">
        {{ app()->getLocale() === 'da' ? 'Se hjemmeside' : 'View site' }}
    </span>
</a>
