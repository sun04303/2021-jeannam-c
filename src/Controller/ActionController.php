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

            $list = DB::fetchAll("SELECT s.*, IFNULL(score, 0) grade, IFNULL(SUM(cnt), 0) cnt, IFNULL(reviewcnt, 0) reviewcnt, l.borough, l.name AS dong FROM
                                  stores AS s 
                                  LEFT JOIN (SELECT store_id, AVG(score) score, COUNT(*) reviewcnt FROM grades GROUP BY store_id) AS g ON s.id = g.store_id
                                  LEFT JOIN (SELECT id, store_id FROM deliveries) AS d ON s.id = d.store_id
                                  LEFT JOIN (SELECT delivery_id, SUM(cnt) cnt FROM delivery_items GROUP BY delivery_id) AS di ON d.id = di.delivery_id
                                  LEFT JOIN users AS u ON s.user_id = u.id
                                  LEFT JOIN locations AS l ON u.location_id = l.id
                                  GROUP BY s.name ORDER BY cnt DESC");

            echo json_encode($list);
        }
    }