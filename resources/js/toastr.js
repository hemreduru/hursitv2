import toastr from 'toastr';
import $ from 'jquery';

window.$ = window.jQuery = $;
window.toastr = toastr;

toastr.options = {
    "closeButton": true,
    "debug": false,
    "newestOnTop": true,
    "progressBar": true,
    "positionClass": "toast-top-right",
    "preventDuplicates": false,
    "onclick": null,
    "showDuration": "300",
    "hideDuration": "1000",
    "timeOut": "5000",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
};

window.addEventListener('show-toast', event => {
    // Livewire 3 dispatch sends details in event.detail
    // Standard format: event.detail = [{ type: 'success', message: '...' }]
    // Careful with array wrapping in Livewire 3
    const detail = Array.isArray(event.detail) ? event.detail[0] : event.detail;

    const type = detail.type || 'success';
    const message = detail.message || 'Action Completed';

    if (toastr[type]) {
        toastr[type](message);
    } else {
        toastr.success(message);
    }
});
