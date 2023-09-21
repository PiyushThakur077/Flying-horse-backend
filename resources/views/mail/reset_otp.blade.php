@extends('mail.index')

@section('mail')

<td class="content-cell" >
    <table  width="100%" class="height-md bt0 br0 bl0 bb2" style="font-size: 12px;">
        <tr >
            <h3 style="font-weight: 450;">Hi,   {{$name ?? ''}} </h3>
        </tr>
        <tr>
            <h3 style="font-weight: 400;">
                {{$otp}} is the otp for your reset password request, the OTP is valid for 5 minutes only
            </h3>
        </tr>
    </table>
    
</td>
@stop