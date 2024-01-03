<div class="row">
    <div class="col-lg-7">
        <div class="panel panel-default">
            <div class="panel-heading">Documents List</div>
            <div class="panel-body">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            @if ($empdocument->cvfile != null)
                            <th>CV</th>
                            @endif
                            @if ($empdocument->nidfile != null)
                            <th>NID</th>
                            @endif
                            @if ($empdocument->vaccine_certificate != null)
                            <th>Vacine Certificate</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            @if ($empdocument->cvfile != null)
                            <td>
                                <a href="{{ url('public/employee/applicant_cv', $empdocument->cvfile) }}"
                                    target="_blank"><img
                                        src="{{ asset('public/career') }}/img/pdf.png" alt=""
                                        width="30" height="30"></a>
                            </td>
                            @endif
                            @if ($empdocument->nidfile != null)
                            <td>
                                <a href="{{ url('public/employee/nid', $empdocument->nidfile) }}"
                                    target="_blank"><img
                                        src="{{ asset('public/career') }}/img/pdf.png" alt=""
                                        width="30" height="30"></a>
                            </td>
                            @endif
                            @if ($empdocument->vaccine_certificate != null)
                            <td>
                                <a href="{{ url('public/employee/vaccine_certificate', $empdocument->vaccine_certificate) }}"
                                    target="_blank"><img
                                        src="{{ asset('public/career') }}/img/pdf.png" alt=""
                                        width="30" height="30"></a>
                            </td>
                            @endif
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="panel panel-default">
            <div class="panel-heading">Documents</div>
            <form action="{{ action('\App\Http\Controllers\HRIS\Database\EmployeeController@addEmployeeData', [$uniqueemp->id]) }}" method="POST" enctype="multipart/form-data" form="8">
                @csrf
                <input type="hidden" name="form" value="8">
                <input type="hidden" name="empid" value="{{ $uniqueemp->EmployeeID }}">
                <table class="table table-striped">
                    <tbody>
                        <tr>
                            <th style="width: 25%; text-align: center;">CV(pdf)</th>
                            <td style="width: 75%">
                                <div class="control-group {{ $errors->has('cv') ? 'has-error' : '' }}">
                                    <div class="controls">
                                        <input type="file" name="cv" class="pdf-file-input">
                                        <span class="file-error text-danger"></span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th style="width: 25%; text-align: center;">NID(pdf)</th>
                            <td style="width: 75%">
                                <div class="control-group {{ $errors->has('nid') ? 'has-error' : '' }}">
                                    <div class="controls">
                                        <input type="file" name="nid" class="pdf-file-input">
                                        <span class="file-error text-danger"></span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th style="width: 25%; text-align: center;">Vaccination Certificate(Optional)(pdf)</th>
                            <td style="width: 75%">
                                <div class="control-group {{ $errors->has('v_certificate') ? 'has-error' : '' }}">
                                    <div class="controls">
                                        <input type="file" name="v_certificate" class="pdf-file-input">
                                        <span class="file-error text-danger"></span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="panel-footer text-right">
                    @if ($edit)
                        <button type="submit" class="btn btn-success" id="submitBtn">Save</button>
                    @endif
                </div>
            </form>

        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.pdf-file-input').on('change', function() {
            var file = this.files[0];
    
            if (file) {
                if (!file.type.includes('pdf')) {
                    $(this).val('');
                    $(this).next('.file-error').text('Please select a PDF file.');
                    return;
                }
    
                if (file.size > 2 * 1024 * 1024) {
                    $(this).val('');
                    $(this).next('.file-error').text('File size exceeds the maximum limit of 2 MB.');
                    return;
                }
    
                // Clear previous error messages
                $(this).next('.file-error').text('');
            }
        });
    
        // Prevent form submission if there are errors
        $('#submitBtn').on('click', function(e) {
            var hasError = false;
            $('.pdf-file-input').each(function() {
                if ($(this).next('.file-error').text() !== '') {
                    hasError = true;
                }
            });
    
            if (hasError) {
                e.preventDefault();
            }
        });
    });
    </script>

