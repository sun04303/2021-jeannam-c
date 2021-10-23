    <section>
        <div class="background">
            <img src="./resource/img/9.jpg" alt="배경 이미지" title="배경">
            <div class="text">빵집 리스트</div>
        </div>

        <div class="container">
            <div class="search mb-5">
                <input type="radio" name="type" id="name" hidden checked>
                <input type="radio" name="type" id="menu" hidden>
                <input type="radio" name="type" id="location" hidden>

                <div class="type mb-2">
                    <label class="btn-cus" for="name">이름</label>
                    <label class="btn-cus" for="menu">메뉴</label>
                    <label class="btn-cus" for="location">지역</label>
                </div>

                <div class="searchbar">
                    <input onkeyup="enterKey();" type="text" class="form-control me-3" name="searchbar" id="searchbar" placeholder="검색">
                    <button class="btn btn-primary searchBtn"><i class="fas fa-search"></i></button>
                </div>

            </div>

            <div class="bestshop">
                <h3 class="mb-4"><span class="line" style="margin-right: 10px;"></span> TOP5</h3>
                <div class="list">
                    
                </div>
            </div>

            <div class="shoplist mb-5">
                <h3 class="mb-4"><span style="margin-right: 10px;" class="line"></span>빵집 목록</h3>
                <div class="box">
                    
                </div>
            </div>
        </div>
    </section>
    <script src="./resource/js/search.js"></script>