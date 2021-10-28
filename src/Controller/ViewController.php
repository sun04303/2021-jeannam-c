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
    }