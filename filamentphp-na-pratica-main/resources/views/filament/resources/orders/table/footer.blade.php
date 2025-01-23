<tr class="filament-tables-row transition hover:bg-gray-50 dark:hover:bg-gray-500/10 py-10">
    <td colspan="3" class="filament-tables-cell dark:text-white">
        <div class="filament-tables-column-wrapper">
            <div class="filament-tables-text-column px-4 py-3 font-bold">Total:</div>
        </div>
    </td>
    <td class="filament-tables-cell dark:text-white" colspan="1">
        <div class="filament-tables-column-wrapper">
            <div class="filament-tables-text-column px-4 py-3 font-bold">
                {{ $this->getTableRecords()->sum('items_count') }}
            </div>
        </div>
    </td>
    <td class="filament-tables-cell dark:text-white" colspan="3">
        <div class="filament-tables-column-wrapper">
            <div class="filament-tables-text-column px-4 py-3 font-bold">
                {{ money($this->getTableRecords()->sum('orderTotal'), 'BRL') }}
            </div>
        </div>
    </td>
</tr>
