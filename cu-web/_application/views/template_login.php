<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <?php echo CONFIG_SITE['meta_head']; ?>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta content="" name="description" />
    <meta content="" name="author" />

    <!-- NO INDEX MESIN PENCARI-->
    <meta name="googlebot" content="noindex" />
    <meta name="googlebot" content="nofollow" />
    <meta name="googlebot-news" content="noindex" />
    <meta name="googlebot-news" content="nosnippet" />
    <meta name="googlebot-news" content="nofollow" />
    <meta name="robots" content="noindex" />
    <meta name="robots" content="nofollow" />

    <title>Login Administrator</title>

    <!-- Bootstrap -->
    <link href="<?php echo THEMES_BACKEND; ?>/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="<?php echo THEMES_BACKEND; ?>/css/font-awesome.min.css" rel="stylesheet">

    <!-- jQuery -->
    <script src="<?php echo THEMES_BACKEND; ?>/vendor/js/jquery.min.js"></script>
    <script src="<?php echo THEMES_BACKEND; ?>/vendor/js/bootstrap.min.js"></script>

    <style>
        /* BASIC */

        body {
            font-family: "Poppins", sans-serif;
            height: 100vh;
        }

        a {
            color: #4a4fa2;
            display: inline-block;
            text-decoration: none;
            font-weight: 400;
        }

        h2 {
            text-align: center;
            font-size: 16px;
            font-weight: 600;
            text-transform: uppercase;
            display: inline-block;
            margin: 40px 8px 10px 8px;
            color: #cccccc;
        }



        /* STRUCTURE */

        .wrapper {
            display: flex;
            align-items: center;
            flex-direction: column;
            justify-content: center;
            width: 100%;
            min-height: 100%;
            padding: 20px;
        }

        #formContent {
            -webkit-border-radius: 10px 10px 10px 10px;
            border-radius: 10px 10px 10px 10px;
            background: #fff;
            padding: 30px;
            width: 90%;
            max-width: 450px;
            position: relative;
            padding: 0px;
            -webkit-box-shadow: 0 30px 60px 0 rgba(0, 0, 0, 0.3);
            box-shadow: 0 30px 60px 0 rgba(0, 0, 0, 0.3);
            text-align: center;
        }

        #formFooter {
            background-color: #f6f6f6;
            border-top: 1px solid #dce8f1;
            padding: 25px;
            text-align: center;
            -webkit-border-radius: 0 0 10px 10px;
            border-radius: 0 0 10px 10px;
        }



        /* TABS */

        h2.inactive {
            color: #cccccc;
        }

        h2.active {
            color: #0d0d0d;
            border-bottom: 2px solid #5fbae9;
        }



        /* FORM TYPOGRAPHY*/

        input[type=button],
        input[type=submit],
        input[type=reset] {
            background-color: #4a4fa2;
            border: none;
            color: white;
            padding: 15px 80px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            text-transform: uppercase;
            font-size: 13px;
            -webkit-box-shadow: 0 10px 30px 0 rgb(167, 171, 231);
            box-shadow: 0 10px 30px 0 rgb(167, 171, 231);
            -webkit-border-radius: 5px 5px 5px 5px;
            border-radius: 5px 5px 5px 5px;
            margin: 5px 20px 40px 20px;
            -webkit-transition: all 0.3s ease-in-out;
            -moz-transition: all 0.3s ease-in-out;
            -ms-transition: all 0.3s ease-in-out;
            -o-transition: all 0.3s ease-in-out;
            transition: all 0.3s ease-in-out;
        }

        input[type=button]:hover,
        input[type=submit]:hover,
        input[type=reset]:hover {
            background-color: #636ad2;
        }

        input[type=button]:active,
        input[type=submit]:active,
        input[type=reset]:active {
            -moz-transform: scale(0.95);
            -webkit-transform: scale(0.95);
            -o-transform: scale(0.95);
            -ms-transform: scale(0.95);
            transform: scale(0.95);
        }

        input[type=text],
        input[type=password] {
            background-color: #f6f6f6;
            border: none;
            color: #0d0d0d;
            padding: 8px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 5px;
            width: 85%;
            border: 2px solid #f6f6f6;
            -webkit-transition: all 0.5s ease-in-out;
            -moz-transition: all 0.5s ease-in-out;
            -ms-transition: all 0.5s ease-in-out;
            -o-transition: all 0.5s ease-in-out;
            transition: all 0.5s ease-in-out;
            -webkit-border-radius: 5px 5px 5px 5px;
            border-radius: 5px 5px 5px 5px;
        }

        input[type=text]:focus,
        input[type=password]:focus {
            background-color: #fff;
            border-bottom: 2px solid #4a4fa2;
        }

        input[type=text]:placeholder,
        input[type=password]:placeholder {
            color: #cccccc;
        }

        /* Simple CSS3 Fade-in Animation */
        .underlineHover:after {
            display: block;
            left: 0;
            bottom: -10px;
            width: 0;
            height: 2px;
            background-color: #4a4fa2;
            content: "";
            transition: width 0.2s;
        }

        .underlineHover:hover {
            color: #b4b7ef;
        }

        .underlineHover:hover:after {
            width: 100%;
        }

        h1 {
            color: #4a4fa2;
        }

        /* OTHERS */

        *:focus {
            outline: none;
        }

        #icon {
            width: 50%;
        }
    </style>

</head>

<body class="login">

    <?php echo template_echo('content'); ?>

    <!--FORM VALIDATION-->
    <script src="<?php echo THEMES_BACKEND; ?>/vendor/js/form-validator/jquery.form-validator.min.js"></script>

    <script>
        $(function() {
            $("#captcha_reload").click(function() {
                var url = '<?php echo site_url(_login_uri . '/captcha'); ?>';
                $("#captcha_image").attr('src', url + '?' + Math.random());
            });
        });

        window.setTimeout(function() {
            $('.alert-danger').css("display", "none");
        }, 10000);

        $.validate({
            lang: 'id',
            errorMessagePosition: 'top',
            scrollToTopOnError: true
        });
    </script>
</body>

</html>