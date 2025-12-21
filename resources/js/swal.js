import Swal from 'sweetalert2';

window.confirmAction = function(element, method, params = []) {
    const title = element.getAttribute('data-title') || 'Are you sure?';
    const text = element.getAttribute('data-text') || "You won't be able to revert this!";
    const confirmButtonText = element.getAttribute('data-confirm-text') || 'Yes, delete it!';
    const cancelButtonText = element.getAttribute('data-cancel-text') || 'Cancel';
    const icon = element.getAttribute('data-icon') || 'warning';

    Swal.fire({
        title: title,
        text: text,
        icon: icon,
        showCancelButton: true,
        confirmButtonColor: '#135bec', // Primary color
        cancelButtonColor: '#d33',
        confirmButtonText: confirmButtonText,
        cancelButtonText: cancelButtonText,
        background: document.documentElement.classList.contains('dark') ? '#161e2c' : '#ffffff',
        color: document.documentElement.classList.contains('dark') ? '#ffffff' : '#0f172a',
    }).then((result) => {
        if (result.isConfirmed) {
            // Check if it's a Livewire component call
            // Try to find the component ID from the element or its parents
            let componentId = element.getAttribute('wire:id');
            if (!componentId) {
                const parent = element.closest('[wire\\:id]');
                if (parent) {
                    componentId = parent.getAttribute('wire:id');
                }
            }

            console.log('Swal Debug: Component ID found:', componentId);

            if (componentId && window.Livewire) {
                const component = window.Livewire.find(componentId);
                console.log('Swal Debug: Livewire Component found:', component);

                if (component) {
                    console.log('Swal Debug: Calling method:', method, 'with params:', params);
                    component.call(method, ...params);
                } else {
                    console.error('Livewire component instance not found for ID:', componentId);
                }
            } else if (element.__livewire) {
                 // Fallback for older Livewire versions or direct attachment
                element.__livewire.call(method, ...params);
            } else {
                // Fallback for non-Livewire (if needed) or trigger custom event
                 console.warn('Livewire component not found on element.');
            }
        }
    });
};

// Alternative: Listen for a global event if preferred
window.addEventListener('swal:confirm', event => {
    Swal.fire({
        title: event.detail.title,
        text: event.detail.text,
        icon: event.detail.icon,
        showCancelButton: true,
        confirmButtonColor: '#135bec',
        cancelButtonColor: '#d33',
        confirmButtonText: event.detail.confirmButtonText,
        cancelButtonText: event.detail.cancelButtonText
    }).then((result) => {
        if (result.isConfirmed) {
            window.Livewire.find(event.detail.id).call(event.detail.method, event.detail.params);
        }
    });
});
