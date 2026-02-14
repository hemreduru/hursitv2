@props(['placeholder' => __('messages.select_placeholder'), 'multiple' => false, 'label' => '', 'id' => null])

<div
    x-data="{
        model: @entangle($attributes->wire('model')),
        initSelect2() {
            let check = setInterval(() => {
                if (window.jQuery && window.jQuery(this.$refs.select).select2) {
                    clearInterval(check);
                    let el = $(this.$refs.select);
                    el.select2({
                        placeholder: '{{ $placeholder }}',
                        allowClear: true,
                        width: '100%'
                    });

                    el.on('change', function () {
                        this.model = el.val();
                    }.bind(this));

                    this.$watch('model', (value) => {
                        el.val(value).trigger('change.select2');
                    });
                }
            }, 50);
        }
    }"
    x-init="initSelect2()"
    wire:ignore
    class="space-y-4"
>
    @if($label)
        <label for="{{ $id ?? 'select2-'.uniqid() }}" class="block text-sm font-medium">{{ $label }}</label>
    @endif

    <select x-ref="select" {{ $multiple ? 'multiple' : '' }} class="w-full rounded-lg border-border-light dark:border-border-dark bg-white dark:bg-card-dark" style="width: 100%">
        {{ $slot }}
    </select>
</div>
