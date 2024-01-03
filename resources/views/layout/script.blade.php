    <!-- OPTIONAL SCRIPTS -->
    {{-- <script src="{{ url('theme/dist/js/demo.js') }}"></script> --}}
    <script src="{{ url('theme/plugins/chart.js/Chart.min.js') }}"></script>
    {{-- <script src="{{ url('theme/dist/js/pages/dashboard3.js') }}"></script> --}}

    <!-- custom -->
    <script type="text/javascript">
        $(document).ready(function () {
            $('.select2').select2({
                placeholder: "Select One",
                width: "100%",
                allowClear: true,
            });
            $('.select2bs4').select2({
                theme: 'bootstrap4',
                placeholder: "Select One",
                width: "100%",
                allowClear: true,
            });
            $('.select2Txt').select2({
                placeholder: "Select One",
                width: "100%",
                allowClear: true,
                tags: true,
            });
            $('.datepicker').attr('data-toggle', 'datetimepicker').addClass('datetimepicker-input');
            $('.datepicker').datetimepicker({
                format: "YYYY-MM-DD",
                useCurrent: false,
                keepOpen: false,
                toolbarPlacement: 'bottom',
                buttons: {
                    showToday: true,
                    showClear: true,
                    //showClose: true,
                    //showTime: true,
                },
                icons: {
                    //time: "fa-regular fa-clock",
                    today: 'fa-regular fa-calendar-check',
                    //clear: 'fa-regular fa-trash',
                    //close: 'fa-regular fa-times-circle',
                }
            });
            $('.timepicker').attr('data-toggle', 'datetimepicker').addClass('datetimepicker-input');
            $('.timepicker').datetimepicker({
                format: "HH:mm",
                useCurrent: false,
                keepOpen: false,
                toolbarPlacement: 'bottom',
                buttons: {
                    showToday: true,
                    showClear: true,
                    //showClose: true,
                    //showTime: true,
                },
                icons: {
                    time: "fa-regular fa-clock",
                    // today: 'fa-regular fa-calendar-check',
                    //clear: 'fa-regular fa-trash',
                    //close: 'fa-regular fa-times-circle',
                }
            });

            $('.datetimepicker').attr('data-toggle', 'datetimepicker').addClass('datetimepicker-input');
            $('.datetimepicker').datetimepicker({
                format: "YYYY-MM-DD HH:mm:ss",
                useCurrent: false,
                keepOpen: false,
                toolbarPlacement: 'bottom',
                buttons: {
                    showToday: true,
                    showClear: true,
                    //showClose: true,
                    //showTime: true,
                },
                icons: {
                    time: "fa-regular fa-clock",
                    today: 'fa-regular fa-calendar-check',
                    //clear: 'fa-regular fa-trash',
                    //close: 'fa-regular fa-times-circle',
                }
            });

            $('.datepickerbs4v1').datepicker({
                format: "yyyy-mm-dd",
                todayBtn: "linked",
                orientation: "bottom auto",
                autoclose: true,
                todayHighlight: true,
                forceParse: true,
            });
            $('.datepickerbs4v2').datepicker({
                format: "dd-mm-yyyy",
                todayBtn: "linked",
                orientation: "bottom auto",
                autoclose: true,
                todayHighlight: true,
                forceParse: true,
            });
            $('.datepickerbs4v3').datepicker({
                format: "yyyy-mm-dd",
                todayBtn: "linked",
                orientation: "top auto",
                autoclose: true,
                todayHighlight: true,
                forceParse: true,
            });
            $('.datepickerbs4v4').datepicker({
                format: "dd-mm-yyyy",
                todayBtn: "linked",
                orientation: "top auto",
                autoclose: true,
                todayHighlight: true,
                forceParse: true,
            });
            $('.StartDate').datepicker({
                format: "yyyy-mm-dd",
                todayBtn: "linked",
                orientation: "bottom auto",
                autoclose: true,
                todayHighlight: true,
                forceParse: true,
            }).on('changeDate', function(){
                $('.EndDate').datepicker('setStartDate', new Date($(this).val()));
            });
            $('.EndDate').datepicker({
                format: "yyyy-mm-dd",
                todayBtn: "linked",
                orientation: "bottom auto",
                autoclose: true,
                todayHighlight: true,
                forceParse: true,
            }).on('changeDate', function(){
                $('.StartDate').datepicker('setEndDate', new Date($(this).val()));
            });
            $('.StartDatev2').datepicker({
                format: "yyyy-mm-dd",
                todayBtn: "linked",
                orientation: "top auto",
                autoclose: true,
                todayHighlight: true,
                forceParse: true,
            }).on('changeDate', function(){
                $('.EndDatev2').datepicker('setStartDate', new Date($(this).val()));
            });
            $('.EndDatev2').datepicker({
                format: "yyyy-mm-dd",
                todayBtn: "linked",
                orientation: "top auto",
                autoclose: true,
                todayHighlight: true,
            }).on('changeDate', function(){
                $('.StartDatev2').datepicker('setEndDate', new Date($(this).val()));
            });

            $('.year-and-month').datepicker({
                format: "yyyy-mm",
                minViewMode: "months", // Set the minimum view mode to months
                todayBtn: "linked",
                orientation: "top auto",
                autoclose: true,
                todayHighlight: true,
                forceParse: true,
            });

            $('.selectpicker').on('show.bs.select', function() {
                $('.selectflow').css('overflow','inherit');
            });
            $('.selectpicker').on('hide.bs.select', function() {
                $('.selectflow').css('overflow','auto');
            });
        });

        var monthFull = ["N/A", "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
        var month = ["N/A", "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
        var dayFull = ["N/A", "Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
        var day = ["N/A", "Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat" ];
    </script>


    <script  type="text/javascript">
        function updateColumnValue(modelName="",rowId="",columnName="",value="", callback=null){
            $.post('{{ route('update_column_value_by_ajx') }}', {_token: '{{ csrf_token() }}',modelName:modelName,rowId:rowId,columnName:columnName,value:value},function(data){
                if(callback){
                    if(data) callback(true);
                    else callback(false);
                }
            });
        }
        function jsCurrentDate(format="Y-m-d") {
            var currentDate = new Date();
            var year = currentDate.getFullYear();
            var month = (currentDate.getMonth() + 1).toString().padStart(2, '0');
            var day = currentDate.getDate().toString().padStart(2, '0');
            var hours = currentDate.getHours().toString().padStart(2, '0');
            var minutes = currentDate.getMinutes().toString().padStart(2, '0');
            var seconds = currentDate.getSeconds().toString().padStart(2, '0');

            format = format.replace('Y', year);
            format = format.replace('m', month);
            format = format.replace('d', day);
            format = format.replace('H', hours);
            format = format.replace('i', minutes);
            format = format.replace('s', seconds);

            return format;
        }

        function waitingSection(type){
            if(document.getElementById("waitingSection")){
                document.getElementById("waitingSection").remove();
            }
            if(type){

                var newElement = document.createElement('div');
                newElement.id = "waitingSection";
                newElement.innerHTML = `
                <div class="modal-backdrop fade show" style="opacity: 0.8 !important; text-align: center; display: flex; justify-content: center; align-items: center; z-index: 1000000;">
                    <h3 style="color: #fff;">Please  wait..</h3>
                </div>`;
                document.body.appendChild(newElement);

            }else{
                if(document.getElementById("waitingSection")){
                    document.getElementById("waitingSection").remove();
                }
            }
        }


    </script>
