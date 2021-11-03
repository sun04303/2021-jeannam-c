    <section>
        <div class="background">
            <img src="./resource/img/21.jpg" alt="배경 이미지" title="배경">
            <div class="text">주문하기</div>
        </div>
        <input type="hidden" name="store_id" value="<?= $list->id ?>">
        <div class="container mb-5">
            <div class="store_info my-4">
                <img src="./resource/<?= $list->image ?>" alt="빵집" title="빵집">
                <div class="text">
                    <h3><?= $list->name ?></h3>
                    <p>
                        <?= floor((int)$list->grade*10000)/100?> 
                        <?php
                            $re = (int)$list->grade;
                            for($i = 0; $i<5; $i++) {
                                if($re >= 1) {
                                    echo '<i class="fas fa-star"></i>';
                                } else if ($re < 1 && $re > 0) {
                                    echo '<i class="fas fa-star-half-alt"></i>';
                                } else echo '<i class="far fa-star"></i>';
                        
                                $re--;
                            }
                        ?>
                        (<?= $list->reviewcnt ?>)
                    </p>

                    <p><?= $list->connect ?></p>
                    <p><?= $list->borough ?> <?= $list->dong ?></p>
                </div>
            </div>

            <h3>메뉴</h3>
            <div class="order_table">
                <?php foreach($list1 as $item) : ?>
                    <div class="item mb-2">
                        <img src="./resource/<?= $item->image ?>" alt="빵" title="빵">
                        <p><?= $item->name ?></p>

                        <?php if($item->sale != '0') : ?>
                            <p style="margin: 0;"><del><?= $item->price ?>\</del></p>
                            <p><span>-<?= $item->sale.'%' ?></span> <span class="order_bread"><?= ceil((int)$item->price - (((int)$item->price*0.01)*(int)$item->sale)) ?></span>\</p>
                        <?php else : ?>
                            <p><span class="order_bread"><?= $item->price ?></span>\</p> 
                        <?php endif; ?>

                        <input class="form-control" type="number" value="0" min="0" step="1" name="cnt" id="<?= $item->id ?>">
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <button id="order_ok"><i class="fas fa-shopping-cart"></i>주문하기</button>
    </section>
    <script src="./resource/js/order.js"></script>