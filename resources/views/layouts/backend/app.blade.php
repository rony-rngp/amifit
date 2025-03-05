<!doctype html>

<html lang="en" class="light-style layout-menu-fixed layout-compact" dir="ltr" data-theme="theme-default" data-assets-path="{{ asset('backend/assets') }}/" data-style="light">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>@yield('title')</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('backend/assets') }}/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />

    <link rel="stylesheet" href="{{ asset('backend/assets') }}/vendor/fonts/boxicons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('backend/assets') }}/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('backend/assets') }}/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('backend/assets') }}/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('backend/assets') }}/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="{{ asset('backend/assets') }}/vendor/libs/apex-charts/apex-charts.css" />

    <!-- sweetalert 2 -->
    <link rel="stylesheet" href="{{ asset('backend/assets/sweetalert2/sweetalert2.css') }}">

    <!-- Page CSS -->
    <style>
        .border-bottom{
            border-bottom: 1px solid #E4E6E8;
        }
    </style>
    <script src="{{ asset('backend/assets') }}/vendor/libs/jquery/jquery.js"></script>
    @stack('css')

    <!-- Helpers -->
    <script src="{{ asset('backend/assets') }}/vendor/js/helpers.js"></script>
    <script src="{{ asset('backend/assets') }}/js/config.js"></script>
</head>

<body>
<!-- Layout wrapper -->
<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
        <!-- Menu -->

        @include('layouts.backend.partials.sidebar')
        <!-- / Menu -->

        <!-- Layout container -->
        <div class="layout-page">
            <!-- Navbar -->

            @include('layouts.backend.partials.topbar')

            <!-- / Navbar -->

            <!-- Content wrapper -->
            <div class="content-wrapper">
                <!-- Content -->

                @yield('content')
                <!-- / Content -->


                <div class="content-backdrop fade"></div>
            </div>
            <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
    </div>

    <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>
</div>
<!-- / Layout wrapper -->

<!-- Toast with Placements -->
<div class="bs-toast toast toast-placement-ex m-2"
        role="alert"
        aria-live="assertive"
        aria-atomic="true"
        data-bs-delay="3000">
    <div class="toast-header">
        <i class="bx bx-bell me-2"></i>
        <div class="me-auto fw-medium alert_title">Success</div>
        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body"></div>
</div>

<!-- Core JS -->
<!-- build:js assets/vendor/js/core.js -->


<div class="modal fade large_modal" id="main_modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1"></h5>
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">

            </div>

        </div>
    </div>
</div>



<script src="{{ asset('backend/assets') }}/vendor/libs/popper/popper.js"></script>
<script src="{{ asset('backend/assets') }}/vendor/js/bootstrap.js"></script>
<script src="{{ asset('backend/assets') }}/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
<script src="{{ asset('backend/assets') }}/vendor/js/menu.js"></script>
<!-- Main JS -->
<script src="{{ asset('backend/assets') }}/js/main.js"></script>

<!-- endbuild -->


<!-- custom toastr -->
<script>
    function showToast(alert='primary', position="topRight", message) {
        const toastPlacementExample = document.querySelector('.toast-placement-ex');
        const selectedType = 'bg-'+alert;

        let selectedPlacement;
        if(position == 'topLeft'){
            selectedPlacement = 'top-0 start-0'.split(' ');
        }else if(position == 'topRight'){
            selectedPlacement = 'top-0 end-0'.split(' ');
        }else if(position == 'topCenter'){
            selectedPlacement = 'top-0 start-50 translate-middle-x'.split(' ');
        }else if(position == 'middleCenter'){
            selectedPlacement = 'op-50 start-50 translate-middle'.split(' ');
        }else if(position == 'bottomLeft'){
            selectedPlacement = 'bottom-0 start-0'.split(' ');
        }else if(position == 'bottomRight'){
            selectedPlacement = '"bottom-0 end-0'.split(' ');
        }else{
            selectedPlacement = 'top-0 end-0'.split(' ');
        }

        if(alert == 'primary' || alert == 'success'){
            $(".alert_title").text('Success');
        }else{
            $(".alert_title").text('Error');
        }

        // Dispose existing toast if it exists
        if (toastPlacementExample && toastPlacementExample._toast) {
            toastPlacementExample._toast.dispose();
        }

        // Add the selected classes
        toastPlacementExample.classList.add(selectedType);
        DOMTokenList.prototype.add.apply(toastPlacementExample.classList, selectedPlacement);

        $(".toast-body").text(message);

        // Create and show the toast
        const toast = new bootstrap.Toast(toastPlacementExample);
        toast.show();

        // Store the toast instance for potential disposal later
        toastPlacementExample._toast = toast;
    }
</script>

<script>
    @if(session()->has('success'))
        showToast('primary', 'topLeft', '{{ session('success') }}');
    @endif
    @if(session()->has('error'))
    showToast('danger', 'topLeft', '{{ session('error') }}');
    @endif
</script>

<!-- validation -->
<script>
    $('.validate').click(function (e) {
        e.preventDefault(); // Prevent default form submission

        // Flag to track validation status
        var isValid = true;
        var firstInvalidInput = null; // To store the first invalid input

        // Check inputs outside tabs
        $('input, select, textarea, input[type="text"]').not('.tab-pane input, .tab-pane select, .tab-pane textarea, .tab-pane input[type="text"]').each(function () {
            // Check if the input is required and empty
            if ($(this).prop('required') && ($(this).val() === null || $(this).val().trim() === '')) {
                // Add error styling or display error message as per your UI design
                $(this).addClass('is-invalid');

                if ($(this).hasClass('select2-hidden-accessible')) {
                    $(this).next('.select2-container').find('span.select2-selection.select2-selection--single').addClass('is-invalid');
                }

                if ($(this).hasClass('dropify')) {
                    $(this).closest('.drop_inp').find('.dropify-wrapper').addClass('is-invalid');
                } else {
                    $(this).addClass('is-invalid');
                }

                // If this is the first invalid input, store it
                if (!firstInvalidInput) {
                    firstInvalidInput = $(this);
                }

                isValid = false; // Set validation flag to false
            } else {
                $(this).removeClass('is-invalid');

                if ($(this).hasClass('select2-hidden-accessible')) {
                    $(this).next('.select2-container').find('span.select2-selection.select2-selection--single').removeClass('is-invalid');
                }

                if ($(this).hasClass('dropify')) {
                    $(this).closest('.drop_inp').find('.dropify-wrapper').removeClass('is-invalid');
                } else {
                    $(this).removeClass('is-invalid');
                }
            }
        });

        // If any validation error found, prevent form submission
        if (!isValid) {
            // Focus the first invalid input
            if (firstInvalidInput) {
                firstInvalidInput.focus();
            }

            // Optionally, you can display a message or perform any other action
            //console.log('Validation failed. Please check your inputs.');
            showToast('danger', 'topLeft', 'Please fill in all required fields highlighted in red.');
            return false;
        }

        // If all inputs are valid, submit the form
        $(this).closest('form').submit();
    });
</script>

<!-- sweetalert2 -->
<script src="{{ asset('backend/assets/sweetalert2/sweetalert2@11.js') }}"></script>
<script>
    function deleteData(id) {
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
        });

        swalWithBootstrapButtons.fire({
            title: 'Are you sure?',
            text: "You won't be able to delete this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                event.preventDefault();
                document.getElementById('delete-form-'+id).submit();
            }
        })
    }
</script>

<script>
    $(document).ready(function () {
        $(".ajax-modal").on('click', function () {
            var link = $(this).attr("href");
            var title = $(this).data("title");
            var size = $(this).data("size");
            $("#main_modal").removeClass('modal-xl');
            $.ajax({
                url: link,
                success: function(data){
                    $('#main_modal .modal-body').html(data);
                    $('#main_modal .modal-title').html(title);
                    $('#main_modal').addClass('modal-'+size);
                    $('#main_modal').modal('show');

                }
            });
            return false;
        })
    });

    $(document).on("submit",".ajax-submit",function(){
        var elem = $(this);
        $(elem).find("button[type=submit]").prop("disabled",true);
        var link = $(this).attr("action");
        $.ajax({
            method: "POST",
            url: link,
            data:  new FormData(this),
            mimeType:"multipart/form-data",
            contentType: false,
            cache: false,
            processData:false,
            beforeSend: function(){
                button_val = $(elem).find("button[type=submit]").text();
                $(elem).find("button[type=submit]").html('Please Wait');

            },success: function(data){

                window.setTimeout(function(){
                    $(elem).find("button[type=submit]").html(button_val);
                    $(elem).find("button[type=submit]").attr("disabled",false);
                }, 1000);

                var json = JSON.parse(data);
                if(json['result'] == "success"){
                    showToast('primary', 'topLeft', json['message']);
                    window.setTimeout(function(){
                        location.reload();
                    }, 1500);

                }else{
                    jQuery.each( json['message'], function( i, val ) {
                        showToast('danger', 'topLeft', val);
                    });
                }
            },
        });

        return false;
    });
</script>

@stack('js')

</body>
</html>
