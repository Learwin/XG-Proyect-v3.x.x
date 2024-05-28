<?php

$queries[] = "ALTER TABLE `" . USERS . "` ADD COLUMN `user_resi_factor` float default 1;";
$queries[] = "ALTER TABLE `" . USERS_STATISTICS . "` ADD COLUMN `user_statistic_prct` FLOAT default 100;";
$queries[] = "INSERT INTO `" . OPTIONS . "` (`option_id`, `option_name`, `option_value`) VALUES (1001, 'st_resource_multiplier', '1');";
$queries[] = "INSERT INTO `" . OPTIONS . "` (`option_id`, `option_name`, `option_value`) VALUES (1002, 'st_resource_multi_100', '1');";
$queries[] = "INSERT INTO `" . OPTIONS . "` (`option_id`, `option_name`, `option_value`) VALUES (1003, 'st_resource_multi_80', '1');";
$queries[] = "INSERT INTO `" . OPTIONS . "` (`option_id`, `option_name`, `option_value`) VALUES (1004, 'st_resource_multi_60', '1');";
$queries[] = "INSERT INTO `" . OPTIONS . "` (`option_id`, `option_name`, `option_value`) VALUES (1005, 'st_resource_multi_40', '1');";
$queries[] = "INSERT INTO `" . OPTIONS . "` (`option_id`, `option_name`, `option_value`) VALUES (1006, 'st_resource_multi_20', '1');";