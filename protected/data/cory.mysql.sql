CREATE  TABLE IF NOT EXISTS `cory`.`tbl_clients` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `users_id` INT NULL ,
  `name` VARCHAR(255) NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_tbl_clients_tbl_users1` (`users_id` ASC) ,
  CONSTRAINT `fk_tbl_clients_tbl_users1`
    FOREIGN KEY (`users_id` )
    REFERENCES `cory`.`tbl_users` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE  TABLE IF NOT EXISTS `cory`.`tbl_companies` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `street` VARCHAR(255) NULL ,
  `city` VARCHAR(255) NULL ,
  `country` VARCHAR(255) NULL ,
  `state` VARCHAR(255) NULL ,
  `zip` VARCHAR(255) NULL ,
  `phone` VARCHAR(255) NULL ,
  `web` VARCHAR(255) NULL ,
  `products` TEXT NULL ,
  `sales` VARCHAR(255) NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;

CREATE  TABLE IF NOT EXISTS `cory`.`tbl_users` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `username` VARCHAR(128) NULL ,
  `password` VARCHAR(128) NULL ,
  `email` VARCHAR(128) NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;

CREATE  TABLE IF NOT EXISTS `cory`.`tbl_instances` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `users_id` INT NULL ,
  `clients_id` INT NULL ,
  `demo_title` VARCHAR(255) NULL ,
  `application_title` VARCHAR(255) NULL ,
  `expiration` DATETIME NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_tbl_instances_tbl_users1` (`users_id` ASC) ,
  INDEX `fk_tbl_instances_tbl_clients1` (`clients_id` ASC) ,
  CONSTRAINT `fk_tbl_instances_tbl_users1`
    FOREIGN KEY (`users_id` )
    REFERENCES `cory`.`tbl_users` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_tbl_instances_tbl_clients1`
    FOREIGN KEY (`clients_id` )
    REFERENCES `cory`.`tbl_clients` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE  TABLE IF NOT EXISTS `cory`.`tbl_employees` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `companies_id` INT NULL ,
  `instances_id` INT NULL ,
  `name` VARCHAR(255) NULL ,
  `title` VARCHAR(255) NULL ,
  `geographical_area` VARCHAR(255) NULL ,
  `contact_info` TEXT NULL ,
  `email` VARCHAR(255) NULL ,
  `home_street` VARCHAR(255) NULL ,
  `home_city` VARCHAR(255) NULL ,
  `home_state_country` VARCHAR(255) NULL ,
  `home_zip` VARCHAR(255) NULL ,
  `home_phone` VARCHAR(255) NULL ,
  `actual_location_street` VARCHAR(255) NULL ,
  `actual_location_city` VARCHAR(255) NULL ,
  `actual_location_state` VARCHAR(255) NULL ,
  `profile` TEXT NULL ,
  `date_entered` DATETIME NULL ,
  `date_update` DATETIME NULL ,
  `misc_info` TEXT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_employees_companies` (`companies_id` ASC) ,
  INDEX `fk_tbl_employees_tbl_instances1` (`instances_id` ASC) ,
  CONSTRAINT `fk_employees_companies`
    FOREIGN KEY (`companies_id` )
    REFERENCES `cory`.`tbl_companies` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_tbl_employees_tbl_instances1`
    FOREIGN KEY (`instances_id` )
    REFERENCES `cory`.`tbl_instances` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;