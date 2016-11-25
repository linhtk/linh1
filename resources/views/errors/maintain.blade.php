<!DOCTYPE html>
<html>
    <head>
        <title>{{trans.toppage('maintain')}}</title>

        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">

        <style>
            html, body {
                height: 100%;
            }


            .container {
                text-align: center;
                display: table-cell;
                vertical-align: middle;
            }

            .content {
                text-align: center;
                display: inline-block;
            }

            .title {
                font-size: 72px;
                margin-bottom: 40px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="content">
                <p style="color:#080808;font-weight: bold ">
                    {{ trans('account.maintain_text_1') }}
                </p>
            </div>
        </div>
    </body>
</html>
