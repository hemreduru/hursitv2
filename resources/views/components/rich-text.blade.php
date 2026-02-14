@props(['id', 'label' => null, 'placeholder' => __('messages.type_something')])

<div wire:ignore>
    @if($label)
        <label for="{{ $id }}" class="block text-sm font-medium mb-1">{{ $label }}</label>
    @endif
    <div
        id="{{ $id }}"
        x-data="{
            content: @entangle($attributes->wire('model')),
            editor: null,
            init() {
                // Initialize Quill
                this.editor = new Quill(this.$refs.editor, {
                    theme: 'snow',
                    placeholder: '{{ $placeholder }}',
                    modules: {
                        toolbar: [
                            ['bold', 'italic', 'underline', 'strike'],
                            ['blockquote', 'code-block'],
                            [{ 'header': 1 }, { 'header': 2 }],
                            [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                            [{ 'script': 'sub'}, { 'script': 'super' }],
                            [{ 'indent': '-1'}, { 'indent': '+1' }],
                            [{ 'direction': 'rtl' }],
                            [{ 'size': ['small', false, 'large', 'huge'] }],
                            [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                            [{ 'color': [] }, { 'background': [] }],
                            [{ 'align': [] }],
                            ['clean']
                        ]
                    }
                });

                // Set initial content
                if (this.content) {
                    this.editor.root.innerHTML = this.content;
                }

                // Update Livewire on change
                this.editor.on('text-change', () => {
                    let html = this.editor.root.innerHTML;
                    if (html === '<p><br></p>') html = ''; // Clean empty content
                    this.content = html;
                });

                // Watch for external changes
                this.$watch('content', (value) => {
                    if (value !== this.editor.root.innerHTML && value !== '') {
                        this.editor.root.innerHTML = value;
                    }
                });
            }
        }"
        class="w-full text-slate-900 dark:text-gray-100"
    >
        <div x-ref="editor" class="bg-white dark:bg-card-dark rounded-b-lg"></div>
    </div>
</div>
