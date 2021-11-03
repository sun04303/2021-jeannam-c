<?php
    namespace Controller;
    use App\DB;
    class ActionController {
        static function login() {
            $id = $_POST['id'];
            $pass = $_POST['pass'];

            $user = DB::fetch("SELECT * FROM users WHERE id = ? AND pw = ?", [$id, $pass]);

            if($user) {
                $_SESSION['user'] = $user;
                go("로그인 되었습니다.", "/");
            } else {
                back("아이디 혹은 비밀번호를 다시 확인해주세요.");
            }
        }

        static function logout() {
            unset($_SESSION['user']);
            go("로그아웃 되었습니다.", '/');
        }

        static function search() {
            $kind = $_POST['kind'];
            $keyword = $_POST['keyword'];

            if(isset($keyword) && $keyword != '') {
                switch($kind) {
                    case '이름' :
                        $list = DB::fetchAll("SELECT s.*, IFNULL(score, 0) grade, IFNULL(SUM(cnt), 0) cnt, IFNULL(reviewcnt, 0) reviewcnt, l.borough, l.name AS dong FROM
                                              (SELECT * FROM stores WHERE name LIKE '%".addslashes($keyword)."%') AS s 
                                              LEFT JOIN (SELECT store_id, AVG(score) score, COUNT(*) reviewcnt FROM grades GROUP BY store_id) AS g ON s.id = g.store_id
                                              LEFT JOIN (SELECT id, store_id FROM deliveries) AS d ON s.id = d.store_id
                                              LEFT JOIN (SELECT delivery_id, SUM(cnt) cnt FROM delivery_items GROUP BY delivery_id) AS di ON d.id = di.delivery_id
                                              LEFT JOIN users AS u ON s.user_id = u.id
                                              LEFT JOIN locations AS l ON u.location_id = l.id
                                              GROUP BY s.name ORDER BY cnt DESC, name");
                        break;
                    
                    case '메뉴' : 
                        $list = DB::fetchAll("SELECT s.*, IFNULL(score, 0) grade, IFNULL(SUM(cnt), 0) cnt, IFNULL(reviewcnt, 0) reviewcnt, l.borough, l.name AS dong FROM
                                              stores AS s 
                                              RIGHT JOIN (SELECT store_id, name FROM breads WHERE name LIKE '%".addslashes($keyword)."%') AS b ON b.store_id = s.id
                                              LEFT JOIN (SELECT store_id, AVG(score) score, COUNT(*) reviewcnt FROM grades GROUP BY store_id) AS g ON s.id = g.store_id
                                              LEFT JOIN (SELECT id, store_id FROM deliveries) AS d ON s.id = d.store_id
                                              LEFT JOIN (SELECT delivery_id, SUM(cnt) cnt FROM delivery_items GROUP BY delivery_id) AS di ON d.id = di.delivery_id
                                              LEFT JOIN users AS u ON s.user_id = u.id
                                              LEFT JOIN locations AS l ON u.location_id = l.id
                                              GROUP BY s.name ORDER BY cnt DESC, name");
                        break;

                    case '지역' :
                        $list = DB::fetchAll("SELECT s.*, IFNULL(score, 0) grade, IFNULL(SUM(cnt), 0) cnt, IFNULL(reviewcnt, 0) reviewcnt, l.borough, l.name AS dong FROM
                                              (SELECT * FROM locations WHERE borough LIKE '%".addslashes($keyword)."%' OR name LIKE '%".addslashes($keyword)."%') AS l
                                              LEFT JOIN (SELECT id, location_id FROM users WHERE id LIKE 'o%') AS u ON u.location_id = l.id
                                              INNER JOIN stores AS s ON s.user_id = u.id
                                              LEFT JOIN (SELECT store_id, AVG(score) score, COUNT(*) reviewcnt FROM grades GROUP BY store_id) AS g ON s.id = g.store_id
                                              LEFT JOIN (SELECT id, store_id FROM deliveries) AS d ON s.id = d.store_id
                                              LEFT JOIN (SELECT delivery_id, SUM(cnt) cnt FROM delivery_items GROUP BY delivery_id) AS di ON d.id = di.delivery_id
                                              GROUP BY s.name ORDER BY cnt DESC, name");
                        break;
                }
            } else {
                $list = DB::fetchAll("SELECT s.*, IFNULL(score, 0) grade, IFNULL(SUM(cnt), 0) cnt, IFNULL(reviewcnt, 0) reviewcnt, l.borough, l.name AS dong FROM
                                  stores AS s 
                                  LEFT JOIN (SELECT store_id, AVG(score) score, COUNT(*) reviewcnt FROM grades GROUP BY store_id) AS g ON s.id = g.store_id
                                  LEFT JOIN (SELECT id, store_id FROM deliveries) AS d ON s.id = d.store_id
                                  LEFT JOIN (SELECT delivery_id, SUM(cnt) cnt FROM delivery_items GROUP BY delivery_id) AS di ON d.id = di.delivery_id
                                  LEFT JOIN users AS u ON s.user_id = u.id
                                  LEFT JOIN locations AS l ON u.location_id = l.id
                                  GROUP BY s.name ORDER BY cnt DESC, name");
            }

            echo json_encode($list);
        }

        static function orderok() {
            $list = $_POST['a'];
            $id = $_POST['id'];

            $cnt = 0;
            $price = 0;

            DB::query("INSERT INTO deliveries (store_id, orderer_id) VALUES (?, ?)", [$id, $_SESSION['user']->id]);
            $last_id = DB::fetch("SELECT id FROM deliveries ORDER BY id DESC LIMIT 1");
            $last_id=$last_id->id;
            
            foreach($list as $item) {
                DB::query("INSERT INTO delivery_items (delivery_id, bread_id, price, cnt) VALUES (?, ?, ?, ?)", [$last_id, $item["id"], $item["price"], $item["cnt"]]);
                $cnt+=(int)$item["cnt"];
                $price+=(int)$item["cnt"] * (int)$item["price"];
            }

            $msg = "총 ".$cnt."개, ".number_format($price)."원이 주문되었습니다";
            go($msg, '/');
        }
    }