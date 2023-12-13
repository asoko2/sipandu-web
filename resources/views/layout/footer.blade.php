<footer class="main-footer">
    <strong>Copyright &copy;</strong>
</footer>
</div>
<!-- ./wrapper -->

<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- ChartJS -->
<script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>
<!-- Sparkline -->
<script src="{{ asset('plugins/sparklines/sparkline.js') }}"></script>
<!-- JQVMap -->
<script src="{{ asset('plugins/jqvmap/jquery.vmap.min.js') }}"></script>
<script src="{{ asset('plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
<!-- jQuery Knob Chart -->
<script src="{{ asset('plugins/jquery-knob/jquery.knob.min.js') }}"></script>
<!-- daterangepicker -->
<script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<!-- Summernote -->
<script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('js/adminlte.js') }}"></script>
{{-- Sweetalert --}}
<script src="{{ asset('sweetalert/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('/js/sipandu.js?v=') . date('Ymdhis') }}"></script>

<script text="text/javascript">
    function openNotification(e) {
        if ($(e).attr('aria-expanded') != "true") {
            $.ajax({
                url: "{{ route('read-notification') }}",
                method: "POST",
                type: "ajax",
                dataType: "json",
                error: function(e){
                    console.log(e)
                },
                success: function(data){
                    $('#new_notification_count').html('')
                }
            })
        }
    }
    $(document).ready(function() {
        var element = $('#sidebar-menu > li > ul > li > a.active')

        element.parent().parent().parent().addClass('menu-open');
        element.parent().parent().parent().children('a').addClass('active');

    })
</script>

@stack('script')
</body>

</html>
