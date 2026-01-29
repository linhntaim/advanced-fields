@php
    $fieldWrapperView = $getFieldWrapperView();
    $extraAttributeBag = $getExtraAttributeBag();
    $extraInputAttributeBag = $getExtraInputAttributeBag();
    $id = $getId();
    $isDisabled = $isDisabled();
    $statePath = $getStatePath();
    $wireModelAttribute = $applyStateBindingModifiers('wire:model');
    $options = $getOptions();
    $rows = $getRows();
@endphp

<div x-load-css="[@js(\Filament\Support\Facades\FilamentAsset::getStyleHref('grid-fields', package: 'linhntaim/advanced-fields'))]">
    <x-dynamic-component
        :component="$fieldWrapperView"
        :field="$field"
        class="fi-fo-field-grid-wrp"
    >
        <x-filament::input.wrapper
            :disabled="$isDisabled"
            :valid="! $errors->has($statePath) && ! $errors->has($statePath . '*')"
            :attributes="
                \Filament\Support\prepare_inherited_attributes($extraAttributeBag)
                    ->class([
                        'fi-fo-radio',
                        'fi-fo-field-grid',
                    ]),
            "
        >
            <div class="fi-fo-field-grid-table-ctn">
                <table class="fi-fo-field-grid-table">
                    <thead>
                    <tr>
                        <th scope="col"></th>
                        @foreach ($options as $value => $label)
                            <th scope="col"{!! $isOptionDisabled($value, $label) ? ' class="fi-fo-field-grid-disabled"' : '' !!}>{{ $label }}</th>
                        @endforeach
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($rows as $rowValue => $rowLabel)
                        <tr>
                            <th scope="row">{{ $rowLabel }}</th>
                            @foreach ($options as $value => $label)
                                <td>
                                    <input
                                        type="radio"
                                        {{
                                            $extraInputAttributeBag
                                                ->merge([
                                                    'disabled' => $isDisabled || $isOptionDisabled($value, $label),
                                                    'id' => $id . '-' . $rowValue . '-' . $value,
                                                    'name' => $id . '.' . $rowValue,
                                                    'value' => $value,
                                                    'wire:loading.attr' => 'disabled',
                                                    $wireModelAttribute => $statePath . '.' . $rowValue,
                                                ], escape: false)
                                                ->class([
                                                    'fi-radio-input',
                                                    'fi-valid' => ! $errors->has($statePath),
                                                    'fi-invalid' => $errors->has($statePath),
                                                ])
                                        }}
                                    />
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </x-filament::input.wrapper>

        @if(!$isRequired())
            <div
                class="fi-fo-field-grid-clear-btn-ctn"
                x-show="{{ implode('||', array_map(fn($rowValue) => "\$wire.\$get('$statePath')['$rowValue']", array_keys($rows))) }}"
            >
                <button
                    class="fi-color fi-color-primary fi-text-color-700 dark:fi-text-color-400 fi-link fi-size-md fi-ac-link-action fi-fo-field-grid-clear-btn"
                    type="button"
                    x-on:click="$wire.$set('{{ $statePath }}', {})"
                >
                    {{ $getClearButtonLabel() }}
                </button>
            </div>
        @endif
    </x-dynamic-component>
</div>
