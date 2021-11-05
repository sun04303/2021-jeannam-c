<?php
    namespace Controller;
    use App\DB;
    class ViewController {
        static function main() {
            view('main');
        }
    
        static function sub() {
            view('sub');
        }
    
        static function stamp() {
            view('stamp');
        }

        static function login() {
            view('login');
        }

        static function order() {
            if(!isset($_SESSION['user'])) go('로그인 해주세요', '/login');
            $id = $_GET['shop'];
            $shop = DB::fetch("SELECT s.*, IFNULL(score, 0) grade, IFNULL(SUM(cnt), 0) cnt, IFNULL(reviewcnt, 0) reviewcnt, l.borough, l.name AS dong FROM
                               (SELECT * FROM stores WHERE id = ?) AS s 
                               LEFT JOIN (SELECT store_id, AVG(score) score, COUNT(*) reviewcnt FROM grades GROUP BY store_id) AS g ON s.id = g.store_id
                               LEFT JOIN (SELECT id, store_id FROM deliveries) AS d ON s.id = d.store_id
                               LEFT JOIN (SELECT delivery_id, SUM(cnt) cnt FROM delivery_items GROUP BY delivery_id) AS di ON d.id = di.delivery_id
                               LEFT JOIN users AS u ON s.user_id = u.id
                               LEFT JOIN locations AS l ON u.location_id = l.id
                               GROUP BY s.name ORDER BY cnt DESC, name", [$id]);
            $list = DB::fetchAll("SELECT * FROM breads WHERE store_id = ?", [$id]);
            view('order', $shop, $list);
        }

        static function mypage() {
            if(!isset($_SESSION['user'])) go("로그인 해주세요", '/login');

            $type = $_SESSION['user']->type;

            switch ($type) {
                case 'owner':
                    
                    break;
                
                case 'rider':
                    $locations = DB::fetchAll("SELECT * FROM locations");
                    $list = DB::fetchAll("SELECT * FROM 
                                        (SELECT * FROM deliveries WHERE state = 'accept') AS d
                                        LEFT JOIN delivery_items AS di ON d.id = di.delivery_id
                                        LEFT JOIN (SELECT name AS storename, id, user_id FROM stores) AS s ON s.id = d.store_id
                                        LEFT JOIN users AS u ON u.id = s.user_id
                                        LEFT JOIN (SELECT id, sale, name AS bn FROM breads) AS b ON b.id = di.bread_id
                                        LEFT JOIN users AS uu ON uu.id = d.orderer_id
                                        LEFT JOIN (SELECT id, borough AS storeb, name AS storen FROM locations) AS l ON u.location_id = l.id
                                        LEFT JOIN (SELECT id, borough AS userb, name AS usern FROM locations ) AS ll ON uu.location_id = ll.id");
                    
                    view("mypage", $locations, $list);
                    break;

                case 'normal':
                    $list = DB::fetchAll("SELECT * FROM 
                                          (SELECT * FROM deliveries WHERE orderer_id = ?) AS d
                                          LEFT JOIN delivery_items AS di ON d.id = di.delivery_id
                                          LEFT JOIN stores AS s ON s.id = d.store_id
                                          LEFT JOIN (SELECT id, sale, name AS bn FROM breads) AS b ON b.id = di.bread_id", [$_SESSION['user']->id]);
                    view("mypage", $list);
                    break;
            }
        }
    }