<!doctype html>
<html lang="en"
    style="
    margin: 0;
    padding: 0;
    font-family: &quot;Helvetica&quot;, &quot;Arial&quot;, sans-serif;
    background-color: #f5f7fa;
  ">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>One-Time Password</title>
</head>

<body style="margin: 0; padding: 0; background-color: #f5f7fa">
    <table role="presentation"
        style="
        width: 100%;
        border-collapse: collapse;
        background-color: #f5f7fa;
        padding: 20px 0;
      ">
        <tr>
            <td align="center">
                <table role="presentation"
                    style="
              width: 100%;
              max-width: 600px;
              border-collapse: collapse;
              background-color: #ffffff;
              border-radius: 8px;
              box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
              overflow: hidden;
            ">
                    <!-- Header -->
                    <tr>
                        <td
                            style="
                  background-color: #fdb38e;
                  padding: 20px;
                  text-align: center;
                  color: #ffffff;
                ">
                            <h1 style="margin: 0; font-size: 24px; font-weight: 600">
                                Fuwa Fuwa
                            </h1>
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td
                            style="
                  padding: 30px;
                  color: #333333;
                  text-align: left;
                  font-size: 16px;
                  line-height: 1.5;
                ">
                            <p style="margin-top: 0">Hello <strong>{{ $name }}</strong>,</p>
                            <p>Your one-time password (OTP) is:</p>

                            <p
                                style="
                    text-align: center;
                    font-size: 24px;
                    font-weight: bold;
                    color: #fdb38e;
                    margin: 20px 0;
                  ">
                                {{ $otp }}
                            </p>

                            <p>
                                Please use this password to log in. You will be required to
                                set a new password on your first login.
                            </p>

                            <p style="margin-bottom: 0">
                                If you did not request this, please ignore this email.
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td
                            style="
                  background-color: #f5f7fa;
                  padding: 20px;
                  text-align: center;
                  color: #999999;
                  font-size: 12px;
                ">
                            &copy; {{ date('Y') }} Fuwa Fuwa. All rights reserved.
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
