@extends('mail.index')

@section('mail')

<td class="content-cell" >
    <table  width="100%" class="height-md bt0 br0 bl0 bb2" style="font-size: 12px;">
        <tr >
            <h3 style="font-weight: 450;">Hello,   {{$name ?? ''}} </h3>
        </tr>
        <tr>
            <h3 style="font-weight: 400;">
                Welcome to flying horse! Your account has been successfullt created
            </h3>
            <p> Here are your login details: </p>
            <p> Email: {{$email}}</p>
            <p> Email: {{$password}}</p>
            <p> Thank you for using our application</p>
        </tr>
    </table>
    
</td>
@stop