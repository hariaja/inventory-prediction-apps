<!-- Core JS -->
<script src="{{ asset('assets/template/src/js/codebase.app.min.js') }}"></script>
<script src="{{ asset('assets/template/src/js/lib/jquery.min.js') }}"></script>
<script src="{{ asset('assets/custom/js/custom.js') }}"></script>
<script src="{{ asset('assets/custom/js/trix.js') }}"></script>

<!-- Datatables -->
<script src="{{ asset('assets/template/src/js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/template/src/js/plugins/datatables-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
<script src="{{ asset('assets/template/src/js/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/template/src/js/plugins/datatables-responsive-bs5/js/responsive.bootstrap5.min.js') }}"></script>
<script src="{{ asset('assets/template/src/js/plugins/datatables-buttons/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('assets/template/src/js/plugins/datatables-buttons-bs5/js/buttons.bootstrap5.min.js') }}"></script>

<!-- Page JS Plugins -->
<script src="{{ asset('assets/template/src/js/plugins/datatables-buttons-jszip/jszip.min.js') }}"></script>
<script src="{{ asset('assets/template/src/js/plugins/datatables-buttons-pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('assets/template/src/js/plugins/datatables-buttons-pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('assets/template/src/js/plugins/datatables-buttons/buttons.print.min.js') }}"></script>
<script src="{{ asset('assets/template/src/js/plugins/datatables-buttons/buttons.html5.min.js') }}"></script>

<script src="{{ asset('assets/template/src/js/plugins/flatpickr/flatpickr.min.js') }}"></script>
<script src="{{ asset('assets/template/src/js/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ asset('assets/template/src/js/plugins/select2/js/select2.full.min.js') }}"></script>
<script src="{{ asset('assets/template/src/assets/js/plugins/ckeditor5-classic/build/ckeditor.js') }}"></script>
{{-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> --}}
<script src="{{ asset('assets/template/src/assets/js/plugins/chart.js/chart.umd.js') }}"></script>

<!-- Page JS Code -->
<script src="{{ asset('assets/template/src/js/pages/be_tables_datatables.min.js') }}"></script>

<script>
  Codebase.helpersOnLoad([
      'js-flatpickr'
      , 'jq-datepicker'
      , 'jq-select2'
      , 'js-ckeditor5'
    ])

    !(function() {
      class e {
        static initDashboardChartJS() {
          (Chart.defaults.color = "#818d96")
          , (Chart.defaults.scale.grid.color = "transparent")
          , (Chart.defaults.scale.grid.zeroLineColor = "transparent")
          , (Chart.defaults.scale.display = !1)
          , (Chart.defaults.scale.beginAtZero = true)
          , (Chart.defaults.elements.line.borderWidth = 2)
          , (Chart.defaults.elements.point.radius = 5)
          , (Chart.defaults.elements.point.hoverRadius = 7)
          , (Chart.defaults.plugins.tooltip.radius = 3)
          , (Chart.defaults.plugins.legend.display = !1);
        }
        static init() {
          this.initDashboardChartJS();
        }
      }
      Codebase.onLoad(() => e.init());
    })();

</script>

@include('sweetalert::alert')
@stack('javascript')
@include('components.error-alert')
