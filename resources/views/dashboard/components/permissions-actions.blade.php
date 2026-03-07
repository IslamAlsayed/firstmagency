<div class="flex items-center gap-1">
    @if (isset($record) && $record && isset($models) && $models)
        @if (getActiveUser()->can($models . '-read') || getActiveUser()->can($models . '-view'))
            @include('dashboard.components.show-button', [
                'models' => 'dashboard.' . $models,
                'id' => $record->id,
            ])
        @endif
        @if (getActiveUser()->can($models . '-update'))
            @include('dashboard.components.edit-button', [
                'models' => 'dashboard.' . $models,
                'id' => $record->id,
            ])
        @endif
        @if (getActiveUser()->can($models . '-delete'))
            @include('dashboard.components.delete-form', ['id' => $record->id, 'model' => 'dashboard.' . $models])
        @endif
        @if (getActiveUser()->can($models . '-force-delete'))
            @include('dashboard.components.force-delete-form', ['id' => $record->id, 'model' => 'dashboard.' . $models])
        @endif
    @endif
</div>
