    <section>
        <div class="background">
            <img src="./resource/img/8.jpg" alt="배경 이미지" title="배경">
            <div class="text">스탬프</div>
        </div>

        <div class="container my-5">
            <div class="issued">
                <div class="box">
                    <div class="left">
                        <h3><span class="line" style="margin-right: 10px;"></span> 카드 발급</h3>
                        <button class="btn btn-primary downOpen">다운로드</button>

                        <!-- Modal -->
                        <div class="modal fade" id="download" tabindex="-1" aria-labelledby="downloadLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="downloadLabel">이름 입력</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="text" name="cardName" id="cardName" class="form-control" placeholder="이름을 입력해주세요.">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">취소</button>
                                        <a href="#" class="btn btn-primary card-d" download="stamp_card.png">완료</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="right">
                        <img src="./resource/img/stamp/stamp.png" alt="스탬프카드" title="스탬프카드">
                    </div>
                </div>

                <canvas class="cardCopy" width="432" height="288" hidden></canvas>
            </div>

            <div class="stamp mt-5">
                <h3><span class="line" style="margin-right: 10px;"></span>스탬프 찍기</h3>
                <div class="box">
                    <input type="text" class="form-control my-3 codeInput" placeholder="코드를 입력해주세요.">
                    
                    <button class="btn btn-primary cardOpen">완료</button>
                    
                    <!-- Modal -->
                    <div class="modal fade" id="stampCard" tabindex="-1" aria-labelledby="stampCardLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="stampCardLabel">카드 선택</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <input type="file" name="cardSelect" id="cardSelect" class="form-contorl" accept="image/png">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">취소</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <canvas class="stampview" width="432" height="288" hidden></canvas>
                </div>
            </div>

            <div class="cardEvent mt-5">
                <h3><span class="line" style="margin-right: 10px;"></span>이벤트 참여</h3>
                <button class="btn btn-primary cardSel">카드 선택</button>

                <div class="box">
                    <span class="line"></span>
                    <canvas id="graph" width="1000" height="750"></canvas>
                </div>
                <canvas class="eventCanvas" width="432" height="288" hidden></canvas>
            </div>
        </div>
    </section>
    <script src="./resource/js/stamp.js"></script>