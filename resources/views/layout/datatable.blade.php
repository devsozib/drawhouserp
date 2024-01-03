<!-- DataTables -->
<link rel="stylesheet" href="{{ url('theme/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ url('theme/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ url('theme/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">

<!-- DataTables  & Plugins -->
<script src="{{ url('theme/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ url('theme/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ url('theme/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ url('theme/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ url('theme/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ url('theme/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ url('theme/plugins/jszip/jszip.min.js') }}"></script>
<script src="{{ url('theme/plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ url('theme/plugins/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ url('theme/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ url('theme/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ url('theme/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $(".datatbl").DataTable({
            "responsive": true,
            "paging": true,
            "searching": true,
            "ordering": true,
            "lengthChange": false,
            "autoWidth": false,
            "autoHeight": false,
            "pageLength": 10,
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            "buttons": [{
                extend: 'pageLength',
                className: 'btn-default',
            }],
            "columnDefs": [{
                "orderable": false,
                "targets": [-1],
                "order": []
            }, ],
        }).buttons().container().appendTo('#usertbl_wrapper .col-md-6:eq(0)');

        $(".datatblsp").DataTable({
            "responsive": true,
            "paging": true,
            "searching": true,
            "ordering": true,
            "lengthChange": false,
            "autoWidth": false,
            "autoHeight": false,
            "pageLength": 10,
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            "columnDefs": [{
                    "orderable": false,
                    "targets": [-1],
                    "order": []
                },
                //{ "visible": false, "targets": [0] }
            ],
            //"buttons": ["pageLength", "copy", "csv", "excel", "pdf", "print", "colvis"],
            "buttons": [
                {
                    extend: 'pageLength',
                    className: 'btn-default',
                },
                /* {
                    extend: 'csv',
                    //text: '<img class="btn-icons" src="images/csv-icon.png"></i>',
                    text: '<i class="fas fa-file-csv"></i> CSV',
                    className: 'btn-default',
                    exportOptions: {
                        columns: ':visible',
                        orthogonal: {
                            display: ':null'
                        },
                    },
                    titleAttr: 'CSV',
                }, */
                {
                    extend: 'excel',
                    text: '<i class="fas fa-file-excel"></i> Excel',
                    className: 'btn-default',
                    exportOptions: {
                        columns: ':visible',
                        orthogonal: {
                            display: ':null'
                        },
                    },
                    titleAttr: 'Excel',
                },
                /* {
                    extend: 'print',
                    text: '<i class="fas fa-print"></i> Print',
                    className: 'btn-default',
                    exportOptions: {
                        //columns: [ 0, 1, 2, 3, 4, 5 ],
                        columns: ':visible',
                        orthogonal: {
                            display: ':null'
                        },
                    },
                    titleAttr: 'Print',
                },
                {
                    extend: 'pdfHtml5',
                    text: '<i class="fas fa-file-pdf"></i> PDF',
                    className: 'btn-default',
                    exportOptions: {
                        columns: ':visible',
                        orthogonal: {
                            display: ':null'
                        },
                    },
                    titleAttr: 'PDF',
                }, */
                /* {
                    extend: 'colvis',
                    //text: '<img class="btn-icons" src="images/pdf-icon.png"></i>',
                    text: 'Visibility',
                    className: 'btn-default',
                    exportOptions: {
                        orthogonal: {
                            display: ':null'
                        },
                    },
                    titleAttr: 'COLVIS',
                }, */
            ],
        }).buttons().container().appendTo('#usertbl_wrapper .col-md-6:eq(0)');

        $(".datatblrpt").DataTable({
            "paging": false,
            "searching": false,
            "ordering": false,
            "lengthChange": false,
            "autoWidth": false,
            "autoHeight": false,
            "bInfo" : false,
            "buttons": [
                {
                    extend: 'excel',
                    text: '<i class="fas fa-file-excel"></i> Excel',
                    className: 'btn-default',
                    exportOptions: {
                        columns: ':visible',
                        orthogonal: {
                            display: ':null'
                        },
                    },
                    titleAttr: 'Excel',
                },
            ],
        }).buttons().container().appendTo('#usertbl_wrapper .col-md-6:eq(0)');
    });
</script>
