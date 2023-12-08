<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    </head>
    <body style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; position: relative; -webkit-text-size-adjust: none; background-color: #ffffff; color: #718096; height: 100%; line-height: 1.4; margin: 0; padding: 0; width: 100% !important;">
        <style>
        @media  only screen and (max-width: 600px) {
            .inner-body {
                width: 100% !important;
            }
            
            .footer {
                width: 100% !important;
            }
            table{
                font-size:8px !important;
            }
        }
        
        @media  only screen and (max-width: 500px) {
            .button {
                width: 100% !important;
            }
            table{
                font-size:7px !important;
            }
        }
        .el-card__header{
            height: 100px;
            vertical-align: center;
            /* background: #164b7b !important; */
            color: #fff !important;
        }
        .header-div{
            vertical-align: center!important;
        }
        table{
            font-size:11px;
            color: #164B77;
            border-collapse: collapse;
        }
        th {
            height: 50px;
        }
        td {
            height: 25px;
            vertical-align: center;
        }
        .height-md {
            height: 35px;
        }
        .height-lg {
            height: 50px;
        }
        .font-light {
            font-weight: 100;
            color: grey;
        }
        .br0 {
            border-right: none;
        }
        .bl0 {
            border-left: none;
        }
        .bt0 {
            border-top: none;
        }
        .bb2 {
            border-bottom: 2px solid;
        }
        .br2 {
            border-right: 2px solid;
        }
        .bl2 {
            border-left: 2px solid;
        }
        .btn-primary {
            color: #fff;
            background-color: #8951dd;
            border-color: #8951dd;
        }
        .btn {
            display: inline-block;
            font-weight: 400;
            text-align: center;
            white-space: nowrap;
            vertical-align: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            border: 1px solid transparent;
            padding: 0.375rem 0.75rem;
            font-size: 1rem;
            line-height: 1.5;
            border-radius: 0.25rem;
            transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;
        }
    </style>
    
        <table class="wrapper" width="100%"  style="background-color: #edf2f7;">
        <tr>
            <td align="center" >
                <table class="content" width="100%"  style="background-color: #fff;">
                   <!--  <tr style="margin-bottom: 6%;">
                        <td class="header" style="padding: 25px 0; text-align: center">
                            <a href="{{url('/')}}">
                                <img src="{{ asset('images/logo1.png') }}" class="logo" alt="{{config('app.name')}} Logo" style=" height: 85px; width: 150px;">
                            </a>
                        </td>
                    </tr> -->
                    <!-- Email Body -->
                    <tr>
                        <td class="body" width="100%" cellpadding="0" cellspacing="0" >
                            <table class="inner-body" align="center" width="670" cellpadding="0" cellspacing="0" role="presentation" style="margin-top: 6%" >
                                <!-- Body content -->
                                <tr>
                                    <td class="header" style="padding: 25px 0; text-align: center">
                            <a href="{{url('/')}}">
                                <img src="{{ asset('images/logo1.png') }}" class="logo" alt="{{config('app.name')}} Logo" style=" height: 85px; width: 150px;">
                            </a>
                        </td>
                                </tr>
                                <tr>
                                    @yield('mail')
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    </body>
</html>
