<script src="{{asset('admin/vendors/scripts/core.js')}}"></script>
<script src="{{asset('admin/vendors/scripts/script.min.js')}}"></script>
<script src="{{asset('admin/vendors/scripts/process.js')}}"></script>
<script src="{{asset('admin/vendors/scripts/layout-settings.js')}}"></script>
<!-- <script src="{{asset('admin/src/plugins/apexcharts/apexcharts.min.js')}}"></script> -->
<script src="{{asset('admin/src/plugins/datatables/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('admin/src/plugins/datatables/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('admin/src/plugins/datatables/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('admin/src/plugins/datatables/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{asset('admin/vendors/scripts/dashboard.js')}}"></script>
<script src="{{asset('admin/src/plugins/jquery-steps/jquery.steps.js')}}"></script>
<script src="{{asset('admin/vendors/scripts/steps-setting.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@include('sweetalert::alert')
@stack('js')
@yield('custom_scripts')