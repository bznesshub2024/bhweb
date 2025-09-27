ALTER TABLE `wallet_transaction_history` CHANGE `payment_type` `payment_type` VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '0- prod. commission / 1 - membership reward / 2 - checkout_discount / 3- withdwrowal / 4 - Seller commission,5 add money to wallet';

ALTER TABLE `orders` ADD `bonus_virtual` INT(11) NOT NULL DEFAULT '0' COMMENT '0 nothing,\r\n1 New User Bonus,\r\n2 Virtual Partner/Order Commission' AFTER `coupon_value`, ADD `bonus_virtual_price` TEXT NULL DEFAULT NULL AFTER `bonus_virtual`;

ALTER TABLE `orders` ADD `globalJson` LONGTEXT NULL DEFAULT NULL AFTER `bonus_virtual_price`;

ALTER TABLE `wallet_transaction_history` CHANGE `payment_type` `payment_type` VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '0- prod. commission / 1 - membership reward / 2 - checkout_discount / 3- withdwrowal / 4 - Seller commission,5 add money to wallet, 6 deduct New User Bonus, 7 deduct Virtual Partner/Order Commission,8 return order cancel New User Bonus, 9 return order cancel Virtual Partner/Order Commission';

ALTER TABLE `plans` ADD `duration` TEXT NULL DEFAULT NULL AFTER `plan_value`;

ALTER TABLE `seller_plan_payment` ADD `plan_duration` TEXT NOT NULL AFTER `create_at`, ADD `plan_start_date` TEXT NOT NULL AFTER `plan_duration`, ADD `plan_end_date` TEXT NOT NULL AFTER `plan_start_date`;
ALTER TABLE `seller_plan_payment` ADD `current_plan` INT(11) NOT NULL DEFAULT '1' COMMENT '1 active plan,0 deactive' AFTER `plan_end_date`;