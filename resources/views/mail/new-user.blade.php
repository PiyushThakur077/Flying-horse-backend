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
               <h3 style="font-weight: 450;">Hello,   {{$name ?? ''}} </h3>
                <h3 style="font-weight: 400;">
                Welcome to flying horse! Your account has been successfullt created
            </h3>
            <p> Here are your login details: </p>
            <p> Email: {{$email}}</p>
            <p> Password: {{$password}}</p>
            <p> Thank you for using our application</p>
            </td>
           
        </tr>
    </table>
    
</td>
@stop