create database stokki;

use database stokki;


create table produtos(

    `product_id` int(5) primary key not null auto_increment,
    `rebate_token` varchar(200),
    `user_id` int(10),
    `update_at` tinyint(1),    
    `tracking_code_list` varchar(200),   
    `tracking_code` varchar(200),
    `total` int(200),
    `token` varchar(200),
    `taxes` int(200),
    `subtotal` int(200),
    `status` varchar(200),
    `payment_due_date` datetime,
    `slip_url` varchar(200),
    `slip_token` varchar(200),
    `slip_due_date` datetime,
    `slip` tinyint(1),
    `shipping_tracked_at` datetime,
    `shipping_price` int(200),
    `shipped_at` datetime,
    `received_at` datetime,
    `payment_tid` varchar(200),
    `payment_method` varchar(200),
    `payment_gateway` varchar(200),
    `payment_authorization` varchar(200),
    `paid-at` datetime,    

    /*
        items começa
    */



    /*
        items termina
    */

   `installments` int(200),
   `id` int(200),
   `extra` varchar(200),
   `expected_delivery_date` datetime,
   `email` varchar(200),
   `discount_price` int(200),
   



);


