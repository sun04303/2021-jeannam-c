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

            $list = DB::fetchAll("SELECT s.*, IFNULL(cnt, 0) cnt FROM
                                  stores AS s 
                                  LEFT JOIN deliveries AS d ON s.id = d.store_id
                                  LEFT JOIN delivery_items AS di ON d.id = di.delivery_id");

            echo json_encode($list);

            // $list = DB::fetchAll("SELECT * FROM 
            //                       stores AS s WHERE name = ? 
            //                       LEFT JOIN deliveries AS d ON s.id = d.store_id");
        }
    }