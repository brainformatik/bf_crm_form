#
# Table structure for table 'tx_powermail_domain_model_fields'
#
CREATE TABLE tx_powermail_domain_model_fields (
  tx_bfcrmform_fieldname varchar(255) DEFAULT '' NOT NULL
);

#
# Table structure for table 'tx_powermail_domain_model_forms'
#
CREATE TABLE tx_powermail_domain_model_forms (
  tx_bfcrmform_active int(1) DEFAULT '0' NOT NULL,
  tx_bfcrmform_url varchar(255) DEFAULT '' NOT NULL,
  tx_bfcrmform_username varchar(255) DEFAULT '' NOT NULL,
  tx_bfcrmform_accesskey varchar(255) DEFAULT '' NOT NULL,
  tx_bfcrmform_module varchar(255) DEFAULT '' NOT NULL
);