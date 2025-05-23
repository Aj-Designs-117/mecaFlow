<x-layouts.app.sidebar :title="$title ?? null">
    <style>
        #toast-container > .toast {
            font-size: 14px !important;
        }
    </style>

    <flux:main>
        {{ $slot }}
    </flux:main>
    
    @stack('js')

    <script>
    document.addEventListener('livewire:init', () => {
        const toastrConfig = {
            "closeButton": false,
            "debug": false,
            "newestOnTop": false,
            "progressBar": false,
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

        Livewire.on('success', ({ message }) => {
            toastr.options = toastrConfig;
            toastr.success(event.detail[0].message);
        });

        Livewire.on('error', ({ message }) => {
            toastr.options = toastrConfig;
            toastr.error(event.detail[0].message);
        });

        Livewire.on('info', ({ message }) => {
            toastr.options = toastrConfig;
            toastr.info(event.detail[0].message);
        });

        Livewire.on('warning', ({ message }) => {
            toastr.options = toastrConfig;
            toastr.warning(event.detail[0].message);
        });
    });
</script>
</x-layouts.app.sidebar>