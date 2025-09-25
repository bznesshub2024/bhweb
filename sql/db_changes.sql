ALTER TABLE `wallet_transaction_history` CHANGE `payment_type` `payment_type` VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '0- prod. commission / 1 - membership reward / 2 - checkout_discount / 3- withdwrowal / 4 - Seller commission,5 add money to wallet';

ALTER TABLE `orders` ADD `bonus_virtual` INT(11) NOT NULL DEFAULT '0' COMMENT '0 nothing,\r\n1 New User Bonus,\r\n2 Virtual Partner/Order Commission' AFTER `coupon_value`, ADD `bonus_virtual_price` TEXT NULL DEFAULT NULL AFTER `bonus_virtual`;

ALTER TABLE `orders` ADD `globalJson` LONGTEXT NULL DEFAULT NULL AFTER `bonus_virtual_price`;

ALTER TABLE `wallet_transaction_history` CHANGE `payment_type` `payment_type` VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '0- prod. commission / 1 - membership reward / 2 - checkout_discount / 3- withdwrowal / 4 - Seller commission,5 add money to wallet, 6 deduct New User Bonus /Virtual Partner/Order Commission from wallet';