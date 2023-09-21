@extends('mail.index')

@section('mail')

<td class="content-cell" >
    <table  width="100%" class="height-md bt0 br0 bl0 bb2" style="font-size: 12px;">
        <tr >
            <h3 style="font-weight: 450;">Hi,   {{$data['name'] ?? ''}} </h3>
        </tr>
        <tr>
            <h3 style="font-weight: 400;">
                {{$data['userName']}} has sent you mail to download fediwallet app.
            </h3>
            <p>Please use below invite code to rgister to the application <h2>{{$data['token']}}</h2>  </p>
        </tr>
        <tr>
            <table class="action" align="center" width="100%" cellpadding="0" cellspacing="0" role="presentation">
                <tr>
                    <td align="center">
                        <table width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation">
                            <tr>
                                <td align="center">
                                    <table border="0" cellpadding="0" cellspacing="0" role="presentation">
                                        <tr>
                                            <td>
                                                <a href="https://drive.google.com/drive/folders/1Jl47FD4taqOQ8QiF8y3hbex_-sx6w-aQ?usp=drive_link" class="btn btn-{{ $color ?? 'primary' }}" target="_blank" rel="noopener" style="text-decoration: none;padding-left: 30px;padding-right: 30px;">Download Now</a>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>

        </tr>
    </table>
    
</td>
@stop