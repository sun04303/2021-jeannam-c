<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>대전 브레드 투어</title>
    <script src="./resource/js/jquery-3.6.0.min.js"></script>
    <script src="./resource/bootstrap-5.0.2-dist/js/bootstrap.js"></script>
    <link rel="stylesheet" href="./resource/bootstrap-5.0.2-dist/css/bootstrap.css">
    <link rel="stylesheet" href="./resource/fontawesome-free-5.15.3-web/css/all.css">
    <link rel="stylesheet" href="./resource/css/style.css">
</head>
<body>
    <header>
        <div class="pc">
            <div class="logo">
                <a href="#"><img src="./resource/img/logo.png" alt="로고" title="대전 브레드 투어"></a>
            </div>
            <nav>
                <ul>
                    <li><a href="#">대전 빵집</a></li>
                    <li><a href="#">스탬프</a></li>
                    <li><a href="#">할인 이벤트</a></li>
                    <li><a href="#">마이페이지</a></li>
                </ul>
            </nav>
            <div class="ect">
                <a href="#" class="login">로그인</a>
            </div>
        </div>

        <div class="mobile">
            <div class="logo">
                <a href="#"><img src="./resource/img/logo.png" alt="로고" title="대전 브레드 투어"></a>
            </div>
            <div class="side">
                <input type="checkbox" name="side" id="side" hidden>

                <label for="side" class="ham">
                    <span></span>
                    <span></span>
                    <span></span>
                </label>

                <div class="m__menu">
                    <label for="side"></label>
                    <div class="box">
                        <div class="item">
                            <a href="#">로그인</a>
                        </div>
                        <div class="item">
                            <a href="#">대전 빵집</a>
                        </div>
                        <div class="item">
                            <a href="#">스탬프</a>
                        </div>
                        <div class="item">
                            <a href="#">할인 이벤트</a>
                        </div>
                        <div class="item">
                            <a href="#">마이페이지</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>