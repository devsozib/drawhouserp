@if ($message = Session::get('success'))
<div class="alert alert-success alert-block" style="margin: 10px;">
    <button type="button" class="close" data-dismiss="alert">×</button>
    <strong>{{ $message }}</strong>
</div>
@elseif ($message = Session::get('warning'))
<div class="alert alert-warning alert-block" style="margin: 10px;">
    <button type="button" class="close" data-dismiss="alert">×</button>
    <strong>{{ $message }}</strong>
</div>
@elseif ($message = Session::get('info'))
<div class="alert alert-info alert-block" style="margin: 10px;">
    <button type="button" class="close" data-dismiss="alert">×</button>
    <strong>{{ $message }}</strong>
</div>
@elseif ($message = Session::get('static'))
<div class="alert alert-success alert-important" style="margin: 10px;">
    <button type="button" class="close" data-dismiss="alert">×</button>
    <strong>{{ $message }}</strong>
</div>
@elseif ($errors->any())
<div class="alert alert-danger alert-block" style="margin: 10px;">
    <button type="button" class="close" data-dismiss="alert">×</button>
    Check the following errors :
    @foreach ($errors->all() as $error)
    <br><strong>{{ $error }}</strong>
    @endforeach
</div>
@elseif ($message = Session::get('error'))
<div class="alert alert-danger alert-block" style="margin: 10px;">
    <button type="button" class="close" data-dismiss="alert">×</button>
    <strong>{{ $message }}</strong>
</div>
@endif
