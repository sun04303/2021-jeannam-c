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
                    $sl = $_SESSION['user']->location_id;
                    $menu = DB::fetchAll("SELECT b.* FROM breads AS b
                                          RIGHT JOIN (SELECT * FROM stores WHERE user_id = ?) AS s ON b.store_id = s.id", [$_SESSION['user']->id]);
                    
                    $list = DB::fetchAll("SELECT * FROM
                                          (SELECT id AS delid, store_id, orderer_id, driver_id, state FROM deliveries WHERE store_id = ?) AS d
                                          LEFT JOIN delivery_items AS di ON d.delid = di.delivery_id
                                          LEFT JOIN (SELECT id, sale, name AS bn FROM breads) AS b ON b.id = di.bread_id
                                          LEFT JOIN users AS u ON u.id = d.orderer_id
                                          LEFT JOIN (SELECT id, borough AS userb, name AS usern FROM locations) AS l ON u.location_id = l.id
                                          LEFT JOIN users AS uu ON uu.id = d.driver_id
                                          LEFT JOIN (SELECT id, borough AS storeb, name AS storen FROM locations) AS ll ON uu.location_id = ll.id
                                          LEFT JOIN (SELECT vertex1, vertex2, distance AS rtos FROM distances) AS dis ON dis.vertex1 = ll.id AND dis.vertex2 = ? OR dis.vertex1 = ? AND dis.vertex2 = ll.id
                                          LEFT JOIN (SELECT vertex1, vertex2, distance AS stou FROM distances) AS diss ON diss.vertex1 = l.id AND diss.vertex2 = ? OR diss.vertex1 = ? AND diss.vertex2 = l.id
                                          ORDER BY delid",
                                          [$_SESSION['user']->id, $sl, $sl, $sl, $sl]);
                    view('mypage', $menu, $list);
                    break;
                
                case 'rider':
                    $riderl = $_SESSION['user']->location_id;
                    $locations = DB::fetchAll("SELECT * FROM locations");
                    $list = DB::fetchAll("SELECT * FROM 
                                        (SELECT id AS delid, store_id, orderer_id, driver_id, state FROM deliveries WHERE state = 'accept' OR state = 'taking' AND driver_id = ?) AS d
                                        LEFT JOIN delivery_items AS di ON d.delid = di.delivery_id
                                        LEFT JOIN (SELECT name AS storename, id, user_id FROM stores) AS s ON s.id = d.store_id
                                        LEFT JOIN users AS u ON u.id = s.user_id
                                        LEFT JOIN (SELECT id, sale, name AS bn FROM breads) AS b ON b.id = di.bread_id
                                        LEFT JOIN users AS uu ON uu.id = d.orderer_id
                                        LEFT JOIN (SELECT id, borough AS storeb, name AS storen FROM locations) AS l ON u.location_id = l.id
                                        LEFT JOIN (SELECT vertex1, vertex2, distance AS rtos FROM distances) AS dis ON dis.vertex1 = ? AND dis.vertex2 = l.id OR dis.vertex1 = l.id AND dis.vertex2 = ?
                                        LEFT JOIN (SELECT id, borough AS userb, name AS usern FROM locations) AS ll ON uu.location_id = ll.id
                                        LEFT JOIN (SELECT vertex1, vertex2, distance AS stou FROM distances) AS diss ON diss.vertex1 = ll.id AND diss.vertex2 = l.id OR diss.vertex1 = l.id AND diss.vertex2 = ll.id
                                        ORDER BY delid", [$_SESSION['user']->id, $riderl, $riderl]);
                    
                    view("mypage", $locations, $list);
                    break;

                case 'normal':
                    $id = $_SESSION['user']->id;
                    $lo = $_SESSION['user']->location_id;
                    $list = DB::fetchAll("SELECT * FROM 
                                          (SELECT * FROM deliveries WHERE orderer_id = ?) AS d
                                          LEFT JOIN delivery_items AS di ON d.id = di.delivery_id
                                          LEFT JOIN (SELECT id, user_id, name AS sn FROM stores) AS s ON s.id = d.store_id
                                          LEFT JOIN (SELECT id, sale, name AS bn FROM breads) AS b ON b.id = di.bread_id
                                          LEFT JOIN users AS u ON u.id = s.user_id
                                          LEFT JOIN (SELECT id, location_id, transportation AS dt FROM users) AS uu ON uu.id = d.driver_id
                                          LEFT JOIN (SELECT id, borough AS storeb, name AS storen FROM locations) AS l ON u.location_id = l.id #상점
                                          LEFT JOIN (SELECT id, borough AS userb, name AS usern FROM locations) AS ll ON uu.location_id = ll.id #라이더
                                          LEFT JOIN (SELECT vertex1, vertex2, distance AS rtos FROM distances) AS dis ON dis.vertex1 = ll.id AND dis.vertex2 = l.id OR dis.vertex1 = l.id AND dis.vertex2 = ll.id
                                          LEFT JOIN (SELECT vertex1, vertex2, distance AS stou FROM distances) AS diss ON diss.vertex1 = u.location_id AND diss.vertex2 = ? OR diss.vertex1 = ? AND diss.vertex2 = u.location_id
                                          ", [$id, $lo, $lo]);
                    view("mypage", $list);
                    break;
            }
        }
    }