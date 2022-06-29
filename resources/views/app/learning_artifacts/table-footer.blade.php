<td colspan="6" class="px-4 py-3 filament-tables-text-column">
    Tamanho Total:
</td>
<td colspan="1" class="px-4 py-3 filament-tables-text-column text-center">
    <div>
       {{
        \App\Models\LearningArtifact::formatSize($this->getTableRecords()->sum('size'))
       }}
    </div>
</td>
<td>

</td>
