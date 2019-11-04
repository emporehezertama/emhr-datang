<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="viewport" content="width=device-width" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>{{ get_setting('title') }}</title>
</head>
<body style="margin:0px; background: #f8f8f8; ">
<div width="100%" style="background: #f8f8f8; padding: 0px 0px; font-family:arial; line-height:28px; height:100%;  width: 100%; color: #514d6a;">
  <div style="max-width: 700px; padding:50px 0;  margin: 0px auto; font-size: 14px">
    <table border="0" cellpadding="0" cellspacing="0" style="width: 100%; margin-bottom: 10px">
      <tbody>
        <tr>
          <td style="vertical-align: top;"> 
            @if(get_setting('logo') != "")
             <a href="#" target="_blank" style="text-decoration: none;color: #484848;"><img src="http://em-hr.co.id{{ get_setting('logo') }}" style="border:none; width: 150px; height: 40px;"> 
            @endif
          </td>
        </tr>
      </tbody>
    </table>
    <div style="padding: 40px; background: #fff;">
        @yield('content')
        <p>This email is sent automatically by the system, you cannot reply to this message, please log in to your account for more info
        </p>
         <br />
          <!--<b>{{ strip_tags(html_entity_decode (get_setting('mail_signature'))) }}</b>-->
          <b>{!! get_setting('mail_signature') !!}</b>
    </div>
    <div style="text-align: center; font-size: 12px; color: #b2b2b5; margin-top: 20px">
      <p> {{ get_setting('title') }}</p>
    </div>
  </div>
</div>
</body>
</html>
