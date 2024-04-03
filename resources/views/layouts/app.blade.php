<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SGH</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous"> --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>

    <!-- jQuery UI CSS CDN -->
    <link href='https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/ui-lightness/jquery-ui.css'
        rel='stylesheet'>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    @yield('content')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var toggleButtons = document.querySelectorAll('.toggle-sublist');

            toggleButtons.forEach(function (button) {
                button.addEventListener('click', function () {
                    var sublist = this
                        .nextElementSibling; // Assuming sublist is the next sibling
                    sublist.classList.toggle('hide');

                    var toggleIcon = this.querySelector('.toggle-icon');
                    toggleIcon.classList.toggle('rotate');

                    // sidenav.classList.toggle('hide');
                });
            });

            var toggleBtnSidenav = document.querySelector('.toggle-btn-sidenav');
            var sidenav = document.querySelector('.sidenav');

            toggleBtnSidenav.addEventListener('click', function () {
                // Toggle the 'hide' class on the entire side navigation
                sidenav.classList.toggle('hide');
            });
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function () {
            $('.js-example-basic-single').select2();
            $('.js-example-basic-multiple').select2();
            $('body').on('shown.bs.modal', '#exampleModalCenter', function () {
                $(this).find('select').each(function () {
                    var dropdownParent = $(document.body);
                    if ($(this).parents('.modal.in:first').length !== 0) {
                        dropdownParent = $(this).parents('.modal.in:first');
                    }
                    $('#nama-customer').select2({
                        dropdownParent: $('#exampleModalCenter')
                    });
                    $('#nama-produk').select2({
                        dropdownParent: $('#exampleModalCenter')
                    });
                    $('#kategori-produk').select2({
                        dropdownParent: $('#exampleModalCenter')
                    });
                    $('#batch-produk').select2({
                        dropdownParent: $('#exampleModalCenter')
                    });
                    $('#sales-produk').select2({
                        dropdownParent: $('#exampleModalCenter')
                    });
                });
            });
        });

    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous">
    </script>
    <!-- jQuery UI JS CDN -->
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js">
    </script>
    
    <script>
        $(document).ready(function () {
            $(function () {
                $("#my_date_picker").datepicker({ dateFormat: 'dd-mm-yy' });
            });
            $(function () {
                $("#my_date_picker2").datepicker({ dateFormat: 'dd-mm-yy' });
            });
            $(function () {
                $("#my_date_picker3").datepicker({ dateFormat: 'dd-mm-yy' });
            });
        })

    </script>
</body>

</html>
