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
                                <td class="bn"><?= $item->sn ?></td>
                                <td class="rn"><?= is_null($item->driver_id) ? '-' : $item->driver_id ?></td>
                                <td class="et">
                                    <?php
                                        if($item->state == 'taking') {
                                            $dis = (int)$item->rtos + (int)$item->stou;
                                            $type = $item->dt == "bike" ? 15 : 50;
                                            echo floor(($dis / $type) * 60) > 0 ? floor(($dis / $type) * 60).'분 소요' : "-";
                                        } else {
                                            echo "-";
                                        }
                                    ?>
                                </td>
                                <td class="st"><?= $item->state == "order" ? "대기 중" : ($item->state == "taking" ? "배달 중" : "배달 완료") ?></td>
                                <td><?= $item->bn ?></td>
                                <td><?= $item->sale == 0 ? $item->price : ceil((int)$item->price - (((int)$item->price*0.01)*(int)$item->sale)) ?></td>
                                <td><?= $item->cnt ?></td>
                                <td class="ot"><?= $item->order_at ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php elseif($_SESSION['user']->type == "owner") : ?>
                <div class="owner row">
                    <div class="order_view col-8">
                        <h3 class="my-5">주문 조회</h3>
                        <table class="table text-center" style="vertical-align:middle;">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>주문자</th>
                                    <th>배달 주소</th>
                                    <th>라이더 이름</th>
                                    <th>도착 예정 시간</th>
                                    <th>상품</th>
                                    <th>가격</th>
                                    <th>수량</th>
                                    <th>주문 상태</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($list1 as $item) : ?>
                                    <tr>
                                        <td class="delid"> <?= $item->delid ?></td>
                                        <td class="or"><?= $item->orderer_id ?></td>
                                        <td class="oa"><?= $item->userb." ".$item->usern ?></td>
                                        <td class="di"><?= is_null($item->driver_id) ? "-" : $item->driver_id ?></td>
                                        <td class="at">
                                            <?php
                                                if($item->state == 'taking') {
                                                    $dis = (int)$item->rtos + (int)$item->stou;
                                                    $type = $item->transportation == "bike" ? 15 : 50;
                                                    echo floor(($dis / $type) * 60) > 0 ? floor(($dis / $type) * 60).'분 소요' : "-";
                                                } else {
                                                    echo "-";
                                                }
                                            ?>
                                        </td>
                                        <td><?= $item->bn ?></td>
                                        <td><?= $item->price ?></td>
                                        <td><?= $item->cnt ?></td>
                                        <td class="st">
                                            <?php if($item->state == "order") : ?>
                                                <button data-id="<?= $item->delid ?>" class="stb btn btn-primary">수락</button>
                                                <button data-id="<?= $item->delid ?>" class="stb btn btn-danger">거절</button>
                                            <?php elseif($item->state == "reject") : ?>
                                                거절한 주문
                                            <?php elseif($item->state == "accept") : ?>
                                                수락한 주문
                                            <?php elseif($item->state == "taking") : ?>
                                                배달 중
                                            <?php else : ?>
                                                배달 완료
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="menu col-4">
                        <h3 class="my-5">메뉴 관리</h3>
                        <div class="box">
                            <?php foreach($list as $item) : ?>
                                <img src="./resource<?= $item->image ?>" alt="빵" title="빵">
                                <div><?= $item->name ?></div>
                            <?php endforeach; ?>
                        </div>

                        <?php 
                            echo "<pre>";
                            var_dump($list);
                            echo "</pre>";
                        ?>
                    </div>
                </div>
            <?php else : ?>
                <div class="rider row">
                    <div class="my_info col-3">
                        <h3 class="my-5">내 정보</h3>
                        <div class="box">
                            <div class="left mb-5">
                                <h4>내 위치</h4>
                                <select class="form-select rider_location" name="location" id="location">
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
                                        <label for="bike"><i class="fas fa-bicycle"></i>자전거</label>
                                        <input class="form-check-input" value="bike" type="radio" name="transport" id="bike" <?= $_SESSION['user']->transportation == "bike" ? "checked" : "" ?>>
                                    </div>

                                    <item class="item">
                                        <label for="motorcycle"><i class="fas fa-motorcycle"></i>오토바이</label>
                                        <input class="form-check-input" value="motorcycle" type="radio" name="transport" id="motorcycle" <?= $_SESSION['user']->transportation == "bike" ? "" : "checked" ?>>
                                    </item>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="order_list col-9 mb-5">
                        <h3 class="my-5">배달 리스트</h3>
                        <table class="table text-center" style="vertical-align:middle;">
                            <thead>
                                <tr>
                                    <th>#</th>
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
                                        <td class="delid"> <?= $item->delid ?></td>
                                        <td class="sn"><?= $item->storename ?></td>
                                        <td class="sa"><?= $item->storeb." ".$item->storen ?></td>
                                        <td class="da"><?= $item->userb." ".$item->usern ?></td>
                                        <td class="at"><?= floor((((int)$item->rtos + (int)$item->stou) / ($_SESSION['user']->transportation == "bike" ? 15 : 50)) * 60) > 0 ? floor((((int)$item->rtos + (int)$item->stou) / ($_SESSION['user']->transportation == "bike" ? 15 : 50)) * 60).'분 소요' : "-" ?></td>
                                        <td><?= $item->bn ?></td>
                                        <td><?= $item->price ?></td>
                                        <td><?= $item->cnt ?></td>
                                        <td class="st"><button class="btn btn-promary" data-id="<?= $item->delid ?>"><?= $item->state == "accept" ? "수락" : ($item->state == "taking" ? "완료" : "완료한 배달") ?></button></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </section>
    <script src="./resource/js/mypage.js"></script>