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
        @include('dashboard.components.delete-button', ['id' => $record->id])
    @endif
    @if (getActiveUser()->can($models . '-force-delete'))
        @include('dashboard.components.forceDelete-button', ['id' => $record->id])
    @endif
@endif
