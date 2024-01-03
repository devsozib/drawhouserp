<div class="footer">            
    <table width="100%">
        <tbody>
            <tr>
                <td align="left" style="vertical-align: bottom;"><b style="border-bottom: 1px solid #000000;">PRINTED BY</b>
                    <?php $user = getUserDetails($CreatedBy); ?>
                    @if($user) 
                    <br>{!! $user->Name !!}                               
                    <br>{!! $user->Designation !!} ({!! $user->Department !!})
                    <br>ID: {!! $user->EmployeeID !!}
                    @endif   
                </td>
            </tr>
        </tbody>
    </table>
</div>