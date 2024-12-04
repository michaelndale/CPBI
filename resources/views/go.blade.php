<script>
    setTimeout("location.href = '{{ route('login')}}';", 2500);
</script>

<style>
    /* Absolute Center Spinner */
    body {
        position: relative;
    }

    .box {
        position: absolute;
        top: 10%;
        left: 50%;
        transform: translate(-50%, 50%);
    }

    .box p {
        color: #228B22;
        font-size: 2.8rem;
        font-family: Helvetica, sans-serif;
        font-weight: bolder;
    }

    .text-box {
        color: white;
        background-color: #228B22;
        padding: 0px 5px;
        border-radius: 3px;
    }

    .y-back {
        width: 160px;
        height: 2px;
        padding: 1px;
        border-radius: 2px;
        background-color: #e2dbdb;
        overflow: hidden;
        margin: auto;
    }

    .y-inner {
        height: 3px;
        width: 40px;
        background-color: #228B22;
        transform: translateX(-60%);
        animation: anim 1.6s infinite;
    }

    @keyframes anim {
        50% {
            transform: translateX(360%);
        }
    }
</style>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your  - GoProject</title>
</head>
    <body>
        <div class="box">
            <p class="logo-text ms-2 d-none d-sm-block"> <i class="far fa-chart-bar"></i> CEPBU</p>
            <div class="y-back">
                <div class="y-inner"></div>
            </div>
            <center>
                <small> <br> <br> © 2023 - <script>
                        document.write(new Date().getFullYear())
                    </script> GoProject </small>
            </center>
        </div>
    </body>
</html>