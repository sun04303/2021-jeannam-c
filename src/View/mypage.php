    <section>
        <div class="background">
            <img src="./resource/img/3.jpg" alt="배경 이미지" title="배경">
            <div class="text">마이페이지</div>
        </div>

        <div class="container my_page">
            <?php if($_SESSION['user']->type == 'normal') : ?>
                <h3 class="my-5">주문 내역</h3>
                <table style="vertical-align:middle;" class="table text-center mb-5">
                    <thead>
                        <tr>
                            <th>빵집 이름</th>
                            <th>라이더 이름</th>
                            <th>도착 예정 시간</th>
                            <th>주문 상태</th>
                            <th>상품 이름</th>
                            <th>가격</th>
                            <th>상품 개수</th>
                            <th>주문일시</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($list as $item) : ?>
                            <tr>
                                <td class="bn"><?= $item->name ?></td>
                                <td class="rn"><?= is_null($item->driver_id) ? '-' : $item->driver_id ?></td>
                                <td class="et"><?= is_null($item->driver_id) ? '-' : $item->driver_id ?></td>
                                <td class="st"><?= $item->state ?></td>
                                <td><?= $item->bn ?></td>
                                <td><?= $item->sale == 0 ? $item->price : ceil((int)$item->price - (((int)$item->price*0.01)*(int)$item->sale)) ?></td>
                                <td><?= $item->cnt ?></td>
                                <td class="ot"><?= $item->order_at ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php elseif($_SESSION['user']->type == "owner") : ?>

            <?php else : ?>
                <div class="rider row">
                    <div class="my_info col-3">
                        <h3 class="my-5">내 정보</h3>
                        <div class="box">
                            <div class="left mb-5">
                                <h4>내 위치</h4>
                                <select class="form-select" name="location" id="location">
                                    <?php foreach($list as $item) : ?>
                                        <?php if($_SESSION['user']->location_id == $item->id) : ?>
                                            <option value="<?= $item->id ?>" selected><?= $item->borough." ".$item->name ?></option>
                                        <?php else : ?>
                                            <option value="<?= $item->id ?>"><?= $item->borough." ".$item->name ?></option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="right mb-5">
                                <h4 class="mb-4">이동수단</h4>
                                <div class="mid">
                                    <div class="item">
                                        <label for="moto"><i class="fas fa-bicycle"></i>자전거</label>
                                        <input class="form-check-input" type="radio" name="transfort" id="moto" <?= $_SESSION['user']->transportation == "bike" ? "" : "checked" ?>>
                                    </div>

                                    <item class="item">
                                        <label for="bike"><i class="fas fa-motorcycle"></i>오토바이</label>
                                        <input class="form-check-input" type="radio" name="transfort" id="bike" <?= $_SESSION['user']->transportation == "bike" ? "checked" : "" ?>>
                                    </item>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="order_list col-9">
                        <h3 class="my-5">배달 리스트</h3>
                        <table class="table text-center" style="vertical-align:middle;">
                            <thead>
                                <tr>
                                    <th>빵집 이름</th>
                                    <th>빵집 주소</th>
                                    <th>배달 주소</th>
                                    <th>도착 예정시간</th>
                                    <th>상품 이름</th>
                                    <th>가격</th>
                                    <th>상품 개수</th>
                                    <th>상태</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($list1 as $item) : ?>
                                    <tr>
                                        <td><?= $item->storename ?></td>
                                        <td><?= $item->storeb." ".$item->storen ?></td>
                                        <td><?= $item->userb." ".$item->usern ?></td>
                                        <td>asd</td>
                                        <td><?= $item->bn ?></td>
                                        <td><?= $item->price ?></td>
                                        <td><?= $item->cnt ?></td>
                                        <td><button class="btn btn-promary">수락</button></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <?php 
                        echo "<pre>";
                        var_dump($list1);
                        echo "</pre>";
                    ?>
                </div>
            <?php endif; ?>
        </div>
    </section>
    <script src="./resource/js/mypage.js"></script>