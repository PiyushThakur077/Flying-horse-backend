@extends('mail.index')

@section('mail')

<td class="content-cell" >
    <table  width="100%" class="height-md bt0 br0 bl0 bb2" style="font-size: 12px;background-color: #ffffff;
    border-color: #e8e5ef;
    border-radius: 2px;
    border-width: 1px;
    margin: 0 auto;
    padding: 0;
    width: 570px;">
       <!--  <tr >
            <h3 style="font-weight: 450;">Hello,   {{$name ?? ''}} </h3>
        </tr> -->
        <tr>
            <td style="max-width: 100vw; padding: 32px;">
                <a href="{{url('/')}}">
                                <img src="{{ asset('images/logo1.png') }}" class="logo" alt="{{config('app.name')}} Logo" style=" width: 50%;">
                            </a>
               <h3 style="font-weight: 300; font-size:25px;margin-bottom: 9px;">Greetings! <br><span style="font-size: 35px;font-weight: 500;color: #333333;">{{$name ?? ''}}</span></h3>
                <h3 style="font-weight: 400;font-size: 21px;margin-top: 0;">
                Welcome to flying horse! Your account has been successfully created
            </h3><hr>
            <p style="font-size: 20px;"> Here are your login details: </p>
            <p style="font-size: 20px;"> Email: {{$email}}</p>
            <p style="font-size: 20px;"> Password: {{$password}}</p>
            <br>
            <p style="font-size: 20px;"> For any query please contact your admin.</p>
            </td>
           
        </tr>
    </table>
    
</td>
@stop