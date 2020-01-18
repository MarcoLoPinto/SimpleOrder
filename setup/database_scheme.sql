CREATE TABLE tableOrder(
    id INT UNSIGNED AUTO_INCREMENT,
    name VARCHAR(60) NOT NULL,
    password VARCHAR(60) NOT NULL,
    PRIMARY KEY(id),
    UNIQUE(name)
);

CREATE TABLE category(
    id INT UNSIGNED AUTO_INCREMENT,
    type VARCHAR(60) NOT NULL,
    PRIMARY KEY(id),
    UNIQUE(type)
);

CREATE TABLE food(
    id INT UNSIGNED AUTO_INCREMENT,
    name VARCHAR(60) NOT NULL,
    price INT UNSIGNED NOT NULL,
    PRIMARY KEY(id),
    UNIQUE(name)
);

CREATE TABLE foodInstance(
    id INT UNSIGNED AUTO_INCREMENT,
    quantity INT UNSIGNED NOT NULL,
    id_food INT UNSIGNED,
    id_tableOrder INT UNSIGNED,
    PRIMARY KEY(id),
    CONSTRAINT ref_food FOREIGN KEY (id_food) REFERENCES food(id) ON DELETE SET NULL ON UPDATE CASCADE,
    CONSTRAINT ref_tableOrder FOREIGN KEY (id_tableOrder) REFERENCES tableOrder(id) ON DELETE SET NULL ON UPDATE CASCADE
);