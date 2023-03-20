<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{$site_name}}</title>
    <style type="text/css"> 
        * {
            padding: 0;
            margin: 0;
            outline: 0;
            box-sizing: border-box;
        }

        .maintenance {
            width: 100vw;
            height: 100vh;
            background-color: #1F2B6E;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .container {
            width: 1140px;
            padding: 0 15px;
            margin: 0 auto;

        }

        .mode-container {
            background: rgba(255, 255, 255, 0.10);
            border-radius: 16px;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(5px);
            -webkit-backdrop-filter: blur(5px);
            border: 1px solid rgba(255, 255, 255, 0.315);
            width: 100%;
            height: fit-content;
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            align-items: center;
            border-radius: 1rem;
            overflow: hidden;
        }

        .left {
            width: 100%;
            height: 100%;
        }

        .left>img {
            width: 100%;
            height: 100%;
        }

        .mode-content {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            text-align: center;
            padding: 0 20px;
        }

        .mode-content>h2 {
            color: #fff;
            font-size: 30px;
            margin: 1rem 0;
        }

        .mode-content>p {
            color: #ddd;
            font-size: 16px;
            margin-bottom: 2rem;
        }

        .mode-content>a {
            text-decoration: none; 
            padding: 5px 20px;
            border: 1px solid whitesmoke;
            color: #fff;
            background: transparent;
            border-radius: 4px;
            cursor: pointer;
            transition: 0.3s all linear;
        }

        .mode-content>a:hover {
            background-color:whitesmoke;
            color: #000;
        }

        .mode-icon {
            width: 60px;
            aspect-ratio: 1/1;
        }

        .mode-icon>img {
            width: 100%;
            height: auto;
            -webkit-animation: rotate-center 0.6s linear infinite;
            animation: rotate-center 3s linear infinite;

        }


        @-webkit-keyframes rotate-center {
            0% {
                -webkit-transform: rotate(0);
                transform: rotate(0);
            }

            100% {
                -webkit-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }

        @keyframes rotate-center {
            0% {
                -webkit-transform: rotate(0);
                transform: rotate(0);
            }

            100% {
                -webkit-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }

        @media (max-width: 575.98px) {
            .mode-container {
                grid-template-columns: repeat(1, 1fr);
            }

            .mode-icon {
                width: 35px;
            }

            .mode-content>h2 {
                font-size: 20px;
                margin: 0.5rem 0;
            }

            .mode-content {
                padding: 10px;
            }

            .mode-content>p {
                font-size: 14px;
                margin-bottom: 1rem;
            }

            .mode-content>a {
                font-size: 12px;
            } 
        }
    </style>
</head>
<body>
    <section class="maintenance">
        <div class="container">
            <div class="mode-container">
                <div class="left">
                    <img src="{{asset('assets/images/maintenance/5326050.jpg')}}" alt="">
                </div>
                <div class="mode-content">
                    <div class="mode-icon">
                        <img src="{{asset('assets/images/maintenance/settings_img.png')}}" alt="">
                    </div>
                    <h2></h2>
                    <p>{{$maintenance_mode_message}}</p>
                    <a href="{{url('/')}}">
                        {{ translate('Reload')}}
                    </a>
                </div>
            </div>
        </div>
    </section>
</body>
</html>