<div class="row">
    <div class="col-lg-3">

    </div>
    <div class="col-lg-6">
        <div class="panel panel-default">

            <div class="panel-body" style="min-height: 350px;">
                <div class="panel panel-default">
                    {!! Form::open([
                        'action' => [
                            '\App\Http\Controllers\HRIS\Database\EmployeeController@addEmployeeData',
                            $uniqueemp->id,
                            'method' => 'Post',
                            'form' => '12',
                            'enctype' => 'multipart/form-data',
                        ],
                    ]) !!}
                    <div class="panel-body" style="padding-bottom: 0;">
                        <table class="table table-striped">
                            <tbody>
                                <tr>
                                    <th style="width: 25%; text-align: center;">Old Password</th>
                                    <td style="width: 75%">
                                        <div class="control-group {!! $errors->has('old_password') ? 'has-error' : '' !!}">
                                            <div class="controls">
                                               <input placeholder="Old Password" value="{{ old('old_password') }}" type="password" class="form-control" name="old_password" id="">
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th style="width: 25%; text-align: center;">New Password</th>
                                    <td style="width: 75%">
                                        <div class="control-group {!! $errors->has('password') ? 'has-error' : '' !!}">
                                            <div class="controls">
                                               <input placeholder="New Password" value="{{ old('password') }}"  type="password" class="form-control" name="password" id="">
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th style="width: 25%; text-align: center;">Confirm New Password</th>
                                    <td style="width: 75%">
                                        <div class="control-group {!! $errors->has('password_confirmation') ? 'has-error' : '' !!}">
                                            <div class="controls">
                                               <input placeholder="Confirm Password" value="{{ old('password_confirmation') }}"  type="password" class="form-control" name="password_confirmation" id="">
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="panel-footer text-right">
                        @if ($edit)
                         {!! Form::submit('Change', ['class' => 'btn btn-success']) !!}
                        @endif
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3">

    </div>

</div>

