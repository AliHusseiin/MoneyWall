<!DOCTYPE html>
<html>
<head>
    <title>My App</title>
    <style>
        /* CSS styles here */
        @media only screen and (max-width: 600px) {
            table[class="container"] {
                width: 100% !important;
            }
            td[class="btn"] {
                display: block !important;
                width: auto !important;
                padding: 10px 20px !important;
            }
        }
    </style>
</head>
<body style="margin: 0; padding: 0;">
    <table class="container" cellpadding="0" cellspacing="0" border="0" align="center" width="600">
        <tr>
            <td style="font-family: Arial, sans-serif; padding: 20px; background-color: #f5f5f5; text-align: center;">
                <h2>Almost there! Just confirm your email</h2>
                <p>Please verify your email by visiting this URL:</p>
                <a href="{{ $URL }}" style="display: inline-block; padding: 10px 20px; background-color: #54BFA1; color: #fff; border-radius: 8px; text-decoration: none;" class="btn">Activation Link</a>
                <p>Thank you!</p>
            </td>
        </tr>
    </table>
</body>
</html>

