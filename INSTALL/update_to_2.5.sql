-- Update Script, updates 2.0.1.x DB RatePAY OXID Module to 2.5 DB

ALTER TABLE `pi_ratepay_settings` ADD `PAYMENT_FIRSTDAY` BOOL NOT NULL DEFAULT '0',
ADD `DUEDATE` INT NOT NULL DEFAULT '14';

INSERT INTO `pi_ratepay_settings` (`profile_id`, `security_code`, `type`) VALUES ('', '', 'elv');

INSERT INTO oxpayments (OXID, OXACTIVE, OXDESC, OXADDSUM, OXADDSUMTYPE, OXFROMBONI, OXFROMAMOUNT, OXTOAMOUNT, OXVALDESC, OXCHECKED, OXDESC_1, OXVALDESC_1, OXDESC_2, OXVALDESC_2, OXDESC_3, OXVALDESC_3, OXLONGDESC, OXLONGDESC_1, OXLONGDESC_2, OXLONGDESC_3, OXSORT, OXTSPAYMENTID)
VALUES ('pi_ratepay_elv', 1, 'RatePAY Lastschrift', 0, 'abs', 0, 20, 1500, '', 1, 'RatePAY Lastschrift', '', '', '', '', '', '', '', '', '', 0, '');

INSERT INTO `oxtplblocks` (`OXID`, `OXACTIVE`, `OXSHOPID`, `OXTEMPLATE`, `OXBLOCKNAME`, `OXPOS`, `OXFILE`, `OXMODULE`) VALUES ('c3658e0e1002c1921edd359257260d6f', '1', 'oxbaseshop', 'page/checkout/payment.tpl', 'select_payment', '0', 'payment_pi_ratepay_elv', 'pi_ratepay');

CREATE TABLE `pi_ratepay_debit_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` varchar(256) NOT NULL,
  `owner` blob NOT NULL,
  `accountnumber` blob NOT NULL,
  `bankcode` blob NOT NULL,
  `bankname` blob NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci;

ALTER TABLE `pi_ratepay_settings` ADD `SAVEBANKDATA` BOOL NOT NULL DEFAULT '0';

ALTER TABLE `pi_ratepay_settings` ADD `ACTIVATE_ELV` TINYINT NOT NULL DEFAULT '0';
