-- `bit.wms`.tbl_mst_categories definition

CREATE TABLE `tbl_mst_categories` (
  `id` int(11) NOT NULL,
  `name_categories` varchar(100) DEFAULT NULL,
  `code_categories` varchar(10) DEFAULT NULL,
  `CreatedAt` datetime DEFAULT NULL,
  `CreatedBy` varchar(100) DEFAULT NULL,
  `UpdatedAt` datetime DEFAULT NULL,
  `UpdatedBy` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- `bit.wms`.tbl_mst_customers definition

CREATE TABLE `tbl_mst_customers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name_customers` varchar(100) DEFAULT NULL,
  `code_customers` varchar(100) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `phone` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `status_customer` int(1) DEFAULT 1,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tbl_mst_customers_unique` (`code_customers`),
  UNIQUE KEY `tbl_mst_customers_unique_1` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4;


-- `bit.wms`.tbl_mst_handling definition

CREATE TABLE `tbl_mst_handling` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `price` double NOT NULL DEFAULT 0,
  `nameHandling` varchar(100) DEFAULT NULL,
  `status_handling` int(11) DEFAULT 1,
  `remarks` varchar(250) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4;


-- `bit.wms`.tbl_mst_packaging definition

CREATE TABLE `tbl_mst_packaging` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name_packaging` varchar(100) DEFAULT NULL,
  `status_packaging` int(1) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;


-- `bit.wms`.tbl_mst_role definition

CREATE TABLE `tbl_mst_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `roleName` varchar(100) DEFAULT NULL,
  `code_role` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  `status_role` int(1) DEFAULT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tbl_mst_role_unique` (`code_role`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4;


-- `bit.wms`.tbl_mst_units definition

CREATE TABLE `tbl_mst_units` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name_unit` varchar(100) DEFAULT NULL,
  `code_unit` varchar(100) DEFAULT NULL,
  `status_unit` int(11) DEFAULT 1 COMMENT '1 AKTIF , 0 INACTIVE',
  `unit_level` int(3) DEFAULT NULL,
  `parent_id` varchar(100) DEFAULT NULL,
  `remarks` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tbl_mst_units_unique` (`name_unit`),
  UNIQUE KEY `tbl_mst_units_unique_1` (`code_unit`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4;


-- `bit.wms`.tbl_mst_users definition

CREATE TABLE `tbl_mst_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) DEFAULT NULL,
  `fullname` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  `customers_id` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(100) DEFAULT NULL,
  `lock_user` int(1) DEFAULT 0,
  `status_user` int(1) DEFAULT 1,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tbl_mst_users_tbl_mst_role_FK` (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4;


-- `bit.wms`.tbl_mst_warehouse definition

CREATE TABLE `tbl_mst_warehouse` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `NameWarehouse` varchar(100) DEFAULT NULL,
  `Area` varchar(100) DEFAULT NULL,
  `Address` varchar(100) DEFAULT NULL,
  `status_warehouse` int(1) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4;


-- `bit.wms`.tbl_sys_menu definition

CREATE TABLE `tbl_sys_menu` (
  `Menu_id` varchar(100) NOT NULL,
  `MenuLevel` varchar(100) DEFAULT NULL,
  `MenuUrut` varchar(30) DEFAULT NULL,
  `LevelNumber` varchar(100) DEFAULT NULL,
  `ParentMenu` varchar(100) DEFAULT NULL,
  `MenuName` varchar(100) DEFAULT NULL,
  `MenuIcon` varchar(100) DEFAULT NULL,
  `MenuUrl` varchar(100) DEFAULT NULL,
  `StatusMenu` int(1) DEFAULT 0,
  PRIMARY KEY (`Menu_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- `bit.wms`.tbl_mst_child_units definition

CREATE TABLE `tbl_mst_child_units` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `unit_name` varchar(100) DEFAULT NULL,
  `unit_code` varchar(100) DEFAULT NULL,
  `remarks` varchar(100) DEFAULT NULL,
  `headers_unit_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tbl_mst_child_units_unique` (`unit_name`),
  UNIQUE KEY `tbl_mst_child_units_unique_1` (`unit_code`),
  KEY `tbl_mst_child_units_tbl_mst_units_FK` (`headers_unit_id`),
  CONSTRAINT `tbl_mst_child_units_tbl_mst_units_FK` FOREIGN KEY (`headers_unit_id`) REFERENCES `tbl_mst_units` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;


-- `bit.wms`.tbl_mst_locationwarehouse definition

CREATE TABLE `tbl_mst_locationwarehouse` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `location` varchar(100) DEFAULT NULL,
  `warehouse_id` int(11) DEFAULT NULL,
  `status_location` int(1) DEFAULT NULL,
  `remarks` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tbl_mst_locationwarehouse_tbl_mst_warehouse_FK` (`warehouse_id`),
  CONSTRAINT `tbl_mst_locationwarehouse_tbl_mst_warehouse_FK` FOREIGN KEY (`warehouse_id`) REFERENCES `tbl_mst_warehouse` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;


-- `bit.wms`.tbl_mst_material definition

CREATE TABLE `tbl_mst_material` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `no_material` varchar(100) DEFAULT NULL,
  `name_material` varchar(100) DEFAULT NULL,
  `uniqueId` varchar(100) NOT NULL,
  `customers_id` int(11) DEFAULT NULL,
  `packaging_id` int(11) DEFAULT NULL,
  `unit_id` int(11) DEFAULT NULL,
  `location_id` int(11) DEFAULT NULL,
  `parentUnitId` int(11) DEFAULT NULL,
  `QtyPerUnit` double DEFAULT NULL,
  `status_material` int(1) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tbl_mst_material_unique_2` (`uniqueId`),
  UNIQUE KEY `tbl_mst_material_unique` (`no_material`),
  UNIQUE KEY `tbl_mst_material_unique_1` (`name_material`,`customers_id`),
  KEY `tbl_mst_material_tbl_mst_customers_FK` (`customers_id`),
  KEY `tbl_mst_material_tbl_mst_units_FK` (`unit_id`),
  KEY `tbl_mst_material_tbl_mst_units_FK_1` (`parentUnitId`),
  KEY `tbl_mst_material_tbl_mst_packingstorage_FK` (`packaging_id`),
  KEY `tbl_mst_material_tbl_mst_locationwarehouse_FK` (`location_id`),
  CONSTRAINT `tbl_mst_material_tbl_mst_customers_FK` FOREIGN KEY (`customers_id`) REFERENCES `tbl_mst_customers` (`id`),
  CONSTRAINT `tbl_mst_material_tbl_mst_locationwarehouse_FK` FOREIGN KEY (`location_id`) REFERENCES `tbl_mst_locationwarehouse` (`id`),
  CONSTRAINT `tbl_mst_material_tbl_mst_packingstorage_FK` FOREIGN KEY (`packaging_id`) REFERENCES `tbl_mst_packaging` (`id`),
  CONSTRAINT `tbl_mst_material_tbl_mst_units_FK` FOREIGN KEY (`unit_id`) REFERENCES `tbl_mst_units` (`id`),
  CONSTRAINT `tbl_mst_material_tbl_mst_units_FK_1` FOREIGN KEY (`parentUnitId`) REFERENCES `tbl_mst_units` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8mb4;


-- `bit.wms`.tbl_sys_roleaccessmenu definition

CREATE TABLE `tbl_sys_roleaccessmenu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) DEFAULT NULL,
  `menu_id` varchar(11) DEFAULT NULL,
  `enable_menu` float DEFAULT 1,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tbl_sys_roleaccessmenu_unique` (`role_id`,`menu_id`),
  KEY `tbl_sys_roleaccessmenu_tbl_sys_menu_FK` (`menu_id`),
  CONSTRAINT `tbl_sys_roleaccessmenu_tbl_mst_role_FK` FOREIGN KEY (`role_id`) REFERENCES `tbl_mst_role` (`id`),
  CONSTRAINT `tbl_sys_roleaccessmenu_tbl_sys_menu_FK` FOREIGN KEY (`menu_id`) REFERENCES `tbl_sys_menu` (`Menu_id`)
) ENGINE=InnoDB AUTO_INCREMENT=185 DEFAULT CHARSET=utf8mb4;


-- `bit.wms`.tbl_trn_shipingmaterial definition

CREATE TABLE `tbl_trn_shipingmaterial` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) DEFAULT NULL,
  `no_surat_jalan` varchar(100) DEFAULT NULL,
  `no_reference` varchar(100) DEFAULT NULL,
  `include_handling` enum('yes','no') DEFAULT NULL,
  `ship_to` varchar(255) DEFAULT NULL,
  `driver` varchar(100) DEFAULT NULL,
  `no_truck` varchar(100) DEFAULT NULL,
  `status` enum('open','close') DEFAULT NULL,
  `date_in` datetime DEFAULT NULL,
  `date_out` datetime DEFAULT NULL,
  `types` enum('in','out') DEFAULT NULL,
  `types_trans` enum('Order','Adjust') DEFAULT NULL,
  `date_trans` datetime DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tbl_trn_shipingmaterial_unique` (`no_surat_jalan`),
  KEY `tbl_trn_shipingmaterial_tbl_mst_customers_FK` (`customer_id`),
  CONSTRAINT `tbl_trn_shipingmaterial_tbl_mst_customers_FK` FOREIGN KEY (`customer_id`) REFERENCES `tbl_mst_customers` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;


-- `bit.wms`.tbl_trn_tagihan definition

CREATE TABLE `tbl_trn_tagihan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customers_id` int(11) DEFAULT NULL,
  `tanggal_tagihan` date DEFAULT NULL,
  `status_tagihan` varchar(100) DEFAULT NULL,
  `tanggal_pembayaran` varchar(100) DEFAULT NULL,
  `tagihan_warehouse` double DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tbl_trn_tagihan_tbl_mst_customers_FK` (`customers_id`),
  CONSTRAINT `tbl_trn_tagihan_tbl_mst_customers_FK` FOREIGN KEY (`customers_id`) REFERENCES `tbl_mst_customers` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;


-- `bit.wms`.tbl_sys_accesmenu definition

CREATE TABLE `tbl_sys_accesmenu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `accessmenu_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `add` int(1) DEFAULT NULL,
  `edit` int(1) DEFAULT NULL,
  `delete` int(1) DEFAULT NULL,
  `showAll` int(1) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tbl_sys_accesmenu_unique` (`accessmenu_id`,`user_id`),
  KEY `tbl_sys_accesmenu_tbl_mst_users_FK` (`user_id`),
  CONSTRAINT `tbl_sys_accesmenu_tbl_mst_users_FK` FOREIGN KEY (`user_id`) REFERENCES `tbl_mst_users` (`id`),
  CONSTRAINT `tbl_sys_accesmenu_tbl_sys_roleaccessmenu_FK` FOREIGN KEY (`accessmenu_id`) REFERENCES `tbl_sys_roleaccessmenu` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=720 DEFAULT CHARSET=utf8mb4;


-- `bit.wms`.tbl_trn_detailshipingmaterial definition

CREATE TABLE `tbl_trn_detailshipingmaterial` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `headers_id` int(11) DEFAULT NULL,
  `material_id` int(11) DEFAULT NULL,
  `no_material` varchar(100) DEFAULT NULL,
  `name_material` varchar(100) DEFAULT NULL,
  `uniqid` varchar(100) DEFAULT NULL,
  `unit` varchar(100) DEFAULT NULL,
  `units` varchar(100) DEFAULT NULL,
  `packaging` varchar(100) DEFAULT NULL,
  `qtyUnit` double DEFAULT 0,
  `qtyUnits` double DEFAULT 0,
  `qtyPackaging` double DEFAULT 0,
  `begin_stock_unit` double DEFAULT 0,
  `begin_stock_units` double DEFAULT 0,
  `begin_stock_packaging` double DEFAULT 0,
  `details_unit` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tbl_trn_detailshipingmaterial_tbl_mst_material_FK` (`material_id`),
  KEY `tbl_trn_detailshipingmaterial_tbl_trn_shipingmaterial_FK` (`headers_id`),
  CONSTRAINT `tbl_trn_detailshipingmaterial_tbl_mst_material_FK` FOREIGN KEY (`material_id`) REFERENCES `tbl_mst_material` (`id`),
  CONSTRAINT `tbl_trn_detailshipingmaterial_tbl_trn_shipingmaterial_FK` FOREIGN KEY (`headers_id`) REFERENCES `tbl_trn_shipingmaterial` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;



-- `bit.wms`.vw_sys_menu source

create or replace
algorithm = UNDEFINED view `bit.wms`.`vw_sys_menu` as
select
    `a`.`user_id` as `user_id`,
    `b`.`enable_menu` as `enable_menu`,
    `b`.`menu_id` as `menu_id`,
    `b`.`role_id` as `role_id`,
    `c`.`MenuName` as `MenuName`,
    `c`.`MenuLevel` as `MenuLevel`,
    `c`.`MenuIcon` as `MenuIcon`,
    `c`.`LevelNumber` as `LevelNumber`,
    `c`.`ParentMenu` as `ParentMenu`,
    `c`.`MenuUrl` as `MenuUrl`,
    `a`.`add` as `add`,
    `a`.`edit` as `edit`,
    `a`.`delete` as `delete`
from
    ((`bit.wms`.`tbl_sys_accesmenu` `a`
join `bit.wms`.`tbl_sys_roleaccessmenu` `b` on
    (`b`.`id` = `a`.`accessmenu_id`))
join `bit.wms`.`tbl_sys_menu` `c` on
    (`c`.`Menu_id` = `b`.`menu_id`));


-- `bit.wms`.vw_tbl_adjust source

create or replace
algorithm = UNDEFINED view `bit.wms`.`vw_tbl_adjust` as
select
    `a`.`id` as `id`,
    `a`.`status` as `status`,
    `a`.`types` as `types`,
    `a`.`remarks` as `remarks`,
    `a`.`types_trans` as `types_trans`,
    `a`.`customer_id` as `customer_id`,
    `b`.`name_customers` as `name_customers`,
    `b`.`code_customers` as `code_customers`,
    `a`.`no_surat_jalan` as `no_surat_jalan`,
    `a`.`no_reference` as `no_reference`,
    `a`.`ship_to` as `ship_to`,
    `a`.`driver` as `driver`,
    `a`.`no_truck` as `no_truck`,
    `a`.`date_trans` as `date_trans`
from
    (`bit.wms`.`tbl_trn_shipingmaterial` `a`
left join `bit.wms`.`tbl_mst_customers` `b` on
    (`b`.`id` = `a`.`customer_id`))
where
    `a`.`types_trans` = 'Adjust'
order by
    `a`.`date_trans` desc;


-- `bit.wms`.vw_tbl_control_stock source

create or replace
algorithm = UNDEFINED view `bit.wms`.`vw_tbl_control_stock` as
select
    `a`.`id` as `id`,
    `a`.`customers_id` as `customers_id`,
    `a`.`uniqueId` as `uniqueId`,
    `b`.`name_unit` as `units`,
    `c`.`name_unit` as `unit`,
    `d`.`name_packaging` as `packaging`,
    `a`.`no_material` as `no_material`,
    `a`.`name_material` as `name_material`,
    ifnull(`x`.`QtyUnit`, 0) - ifnull(`y`.`QtyUnit`, 0) as `QtyUnit`,
    ifnull(`x`.`QtyUnits`, 0) - ifnull(`y`.`QtyUnits`, 0) as `QtyUnits`,
    ifnull(`x`.`QtyPackaging`, 0) - ifnull(`y`.`QtyPackaging`, 0) as `QtyPackaging`,
    coalesce(`y`.`updated_at`, `x`.`updated_at`) as `updated_at`
from
    (((((`bit.wms`.`tbl_mst_material` `a`
left join `bit.wms`.`tbl_mst_units` `b` on
    (`b`.`id` = `a`.`unit_id`))
left join `bit.wms`.`tbl_mst_units` `c` on
    (`c`.`id` = `a`.`parentUnitId`))
left join `bit.wms`.`tbl_mst_packaging` `d` on
    (`d`.`id` = `a`.`packaging_id`))
left join (
    select
        `ttd`.`material_id` as `material_id`,
        sum(`ttd`.`qtyUnits`) as `QtyUnits`,
        sum(`ttd`.`qtyUnit`) as `QtyUnit`,
        sum(`ttd`.`qtyPackaging`) as `QtyPackaging`,
        max(`ttd`.`updated_at`) as `updated_at`
    from
        (`bit.wms`.`tbl_trn_detailshipingmaterial` `ttd`
    left join `bit.wms`.`tbl_trn_shipingmaterial` `tts` on
        (`tts`.`id` = `ttd`.`headers_id`))
    where
        `tts`.`status` = 'close'
        and `tts`.`types` = 'in'
    group by
        `ttd`.`material_id`
    order by
        `ttd`.`updated_at` desc) `x` on
    (`x`.`material_id` = `a`.`id`))
left join (
    select
        `ttd`.`material_id` as `material_id`,
        ifnull(sum(`ttd`.`qtyUnits`), 0) as `QtyUnits`,
        sum(`ttd`.`qtyUnit`) as `QtyUnit`,
        sum(`ttd`.`qtyPackaging`) as `QtyPackaging`,
        max(`ttd`.`updated_at`) as `updated_at`
    from
        (`bit.wms`.`tbl_trn_detailshipingmaterial` `ttd`
    left join `bit.wms`.`tbl_trn_shipingmaterial` `tts` on
        (`tts`.`id` = `ttd`.`headers_id`))
    where
        `tts`.`status` = 'close'
        and `tts`.`types` = 'out'
    group by
        `ttd`.`material_id`) `y` on
    (`y`.`material_id` = `a`.`id`));


-- `bit.wms`.vw_tbl_control_stock_detail source

create or replace
algorithm = UNDEFINED view `bit.wms`.`vw_tbl_control_stock_detail` as
select
    `ttd`.`id` as `id`,
    `ttd`.`headers_id` as `headers_id`,
    `tts`.`types_trans` as `types_trans`,
    `tts`.`types` as `types`,
    `tts`.`customer_id` as `customer_id`,
    `ttd`.`material_id` as `material_id`,
    `ttd`.`unit` as `unit`,
    `ttd`.`units` as `units`,
    `ttd`.`packaging` as `packaging`,
    `ttd`.`qtyUnit` as `QtyUnit`,
    `ttd`.`qtyUnits` as `QtyUnits`,
    `ttd`.`qtyPackaging` as `QtyPackaging`,
    `ttd`.`begin_stock_unit` as `begin_stock_unit`,
    `ttd`.`begin_stock_units` as `begin_stock_units`,
    `ttd`.`begin_stock_packaging` as `begin_stock_packaging`,
    if(`tts`.`types` = 'in',
    `ttd`.`begin_stock_unit` + `ttd`.`qtyUnit`,
    `ttd`.`begin_stock_unit` - `ttd`.`qtyUnit`) as `EndStockUnit`,
    if(`tts`.`types` = 'in',
    `ttd`.`begin_stock_units` + `ttd`.`qtyUnits`,
    `ttd`.`begin_stock_units` - `ttd`.`qtyUnits`) as `EndStockUnits`,
    if(`tts`.`types` = 'in',
    `ttd`.`begin_stock_packaging` + `ttd`.`qtyPackaging`,
    `ttd`.`begin_stock_packaging` - `ttd`.`qtyPackaging`) as `EndStockPackaging`,
    if(`tts`.`types` = 'in',
    `tts`.`date_in`,
    `tts`.`date_out`) as `dates`
from
    (`bit.wms`.`tbl_trn_detailshipingmaterial` `ttd`
left join `bit.wms`.`tbl_trn_shipingmaterial` `tts` on
    (`ttd`.`headers_id` = `tts`.`id`))
where
    `tts`.`status` = 'close';


-- `bit.wms`.vw_tbl_inbound source

create or replace
algorithm = UNDEFINED view `bit.wms`.`vw_tbl_inbound` as
select
    `a`.`id` as `id`,
    `a`.`status` as `status`,
    `a`.`types` as `types`,
    `a`.`types_trans` as `types_trans`,
    `a`.`customer_id` as `customer_id`,
    `b`.`name_customers` as `name_customers`,
    `b`.`code_customers` as `code_customers`,
    `a`.`no_surat_jalan` as `no_surat_jalan`,
    `a`.`no_reference` as `no_reference`,
    `a`.`ship_to` as `ship_to`,
    `a`.`driver` as `driver`,
    `a`.`no_truck` as `no_truck`,
    `a`.`date_trans` as `date_trans`
from
    (`bit.wms`.`tbl_trn_shipingmaterial` `a`
left join `bit.wms`.`tbl_mst_customers` `b` on
    (`b`.`id` = `a`.`customer_id`))
where
    `a`.`types` = 'in'
    and `a`.`types_trans` = 'Order'
order by
    `a`.`date_trans` desc;


-- `bit.wms`.vw_tbl_inbound_detail source

create or replace
algorithm = UNDEFINED view `bit.wms`.`vw_tbl_inbound_detail` as
select
    `a`.`id` as `id`,
    `a`.`headers_id` as `headers_id`,
    `a`.`material_id` as `material_id`,
    `a`.`no_material` as `no_material`,
    `a`.`name_material` as `name_material`,
    `a`.`uniqid` as `uniqid`,
    `a`.`unit` as `unit`,
    `a`.`units` as `units`,
    `a`.`packaging` as `packaging`,
    `a`.`qtyUnit` as `qtyUnit`,
    `a`.`qtyUnits` as `qtyUnits`,
    `a`.`qtyPackaging` as `qtyPackaging`,
    `a`.`begin_stock_unit` as `begin_stock_unit`,
    `a`.`begin_stock_units` as `begin_stock_units`,
    `a`.`begin_stock_packaging` as `begin_stock_packaging`,
    `a`.`details_unit` as `details_unit`
from
    (((`bit.wms`.`tbl_trn_detailshipingmaterial` `a`
left join `bit.wms`.`tbl_mst_material` `b` on
    (`b`.`id` = `a`.`material_id`))
left join `bit.wms`.`tbl_mst_units` `c` on
    (`c`.`id` = `b`.`unit_id`))
left join `bit.wms`.`tbl_mst_packaging` `d` on
    (`d`.`id` = `b`.`packaging_id`));


-- `bit.wms`.vw_tbl_outbound source

create or replace
algorithm = UNDEFINED view `bit.wms`.`vw_tbl_outbound` as
select
    `a`.`id` as `id`,
    `a`.`status` as `status`,
    `a`.`types` as `types`,
    `a`.`types_trans` as `types_trans`,
    `a`.`customer_id` as `customer_id`,
    `b`.`name_customers` as `name_customers`,
    `b`.`code_customers` as `code_customers`,
    `a`.`no_surat_jalan` as `no_surat_jalan`,
    `a`.`no_reference` as `no_reference`,
    `a`.`ship_to` as `ship_to`,
    `a`.`driver` as `driver`,
    `a`.`no_truck` as `no_truck`,
    `a`.`date_trans` as `date_trans`
from
    (`bit.wms`.`tbl_trn_shipingmaterial` `a`
left join `bit.wms`.`tbl_mst_customers` `b` on
    (`b`.`id` = `a`.`customer_id`))
where
    `a`.`types` = 'out'
    and `a`.`types_trans` = 'Order'
order by
    `a`.`date_trans` desc;


-- `bit.wms`.vw_tbl_sj source

create or replace
algorithm = UNDEFINED view `bit.wms`.`vw_tbl_sj` as
select
    `b`.`id` as `headers_id`,
    `b`.`no_surat_jalan` as `no_surat_jalan`,
    `a`.`name_material` as `name_material`,
    `a`.`no_material` as `no_material`,
    `a`.`qtyUnits` as `qtyUnits`,
    `a`.`qtyPackaging` as `qtyPackaging`,
    `a`.`units` as `units`,
    `a`.`packaging` as `packaging`,
    `a`.`details_unit` as `details_unit`
from
    (`bit.wms`.`tbl_trn_detailshipingmaterial` `a`
left join `bit.wms`.`tbl_trn_shipingmaterial` `b` on
    (`b`.`id` = `a`.`headers_id`));



CREATE DEFINER=`root`@`localhost` PROCEDURE `bit.wms`.`sp_tbl_checkstock`(IN material_id_param INT)
begin
	select a.id  ,  a.name_material ,  
	(IFNULL(X.qtyUnit,0) - IFNULL(Y.qtyUnit,0)) qtyUnitBeginStock ,
	(IFNULL(X.qtyUnits,0) - IFNULL(Y.qtyUnits,0)) qtyUnitsBeginStock,
	(IFNULL(X.qtyPackaging,0) - IFNULL(Y.qtyPackaging,0)) qtyPackagingBeginStock
	from tbl_mst_material a 
	left join (
	 	select a.material_id,  sum(a.qtyUnit)qtyUnit , 
		sum(a.qtyUnits)qtyUnits , sum(a.qtyPackaging) qtyPackaging 
		from tbl_trn_detailshipingmaterial a 
		left join tbl_trn_shipingmaterial b on b.id  = a.headers_id  
		where  b.status in ("close") and b.date_in <= now() and b.types = ("in")
		group by  a.material_id 
	)X on X.material_id = a.id 	
	left join (
	 	select a.material_id,  sum(a.qtyUnit) qtyUnit , 
		sum(a.qtyUnits) qtyUnits , sum(a.qtyPackaging) qtyPackaging 
		from tbl_trn_detailshipingmaterial a 
		left join tbl_trn_shipingmaterial b on b.id  = a.headers_id  
		where  b.status in ("close") and b.date_out <= now() and b.types = ("out")
		group by  a.material_id 
	)Y on Y.material_id = a.id 	
	where a.id  = material_id_param ;
END;