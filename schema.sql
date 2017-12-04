CREATE DATABASE yeticave;

USE yeticave;

CREATE TABLE users (
  id                INT       NOT NULL,
  ragistration_date TIMESTAMP NULL,
  email             CHAR(45)  NOT NULL,
  name              CHAR(60)  NOT NULL,
  password          CHAR(60)  NOT NULL,
  avatar            CHAR(45)  NOT NULL,
  contacts          CHAR(45)  NOT NULL,
  CONSTRAINT user_pk PRIMARY KEY (id)
);

CREATE TABLE category (
  id         INT      NOT NULL,
  cat_name   CHAR(45) NULL,
  is_deleted TINYINT  NOT NULL,
  CONSTRAINT category_pk PRIMARY KEY (id)
);

CREATE TABLE lot (
  id             INT         NOT NULL,
  user_id        INT         NOT NULL,
  category_id    INT         NOT NULL,

  creation_date  TIMESTAMP   NULL,
  name           CHAR(60)    NULL,
  description    TEXT(65535) NOT NULL,
  photo          CHAR(100)   NOT NULL,
  starting_price INT         NULL,
  end_date       TIMESTAMP   NULL,
  step           INT         NULL,
  CONSTRAINT lot_pk PRIMARY KEY (id),
  CONSTRAINT lot_category FOREIGN KEY lot_category (category_id) REFERENCES category (id),
  CONSTRAINT lot_user FOREIGN KEY lot_user (user_id) REFERENCES users(id)
);


CREATE TABLE bet (
  id        INT       NOT NULL,
  user_id   INT       NOT NULL,
  lot_id    INT       NOT NULL,

  reg_date  TIMESTAMP NULL,
  bet_value INT       NULL,
  CONSTRAINT bet_pk PRIMARY KEY (id),
  CONSTRAINT bet_user FOREIGN KEY bet_user (user_id) REFERENCES users(id),
  CONSTRAINT bet_lot FOREIGN KEY bet_lot (lot_id) REFERENCES lot (id)
);


CREATE INDEX bet
  ON bet (bet_value);

CREATE UNIQUE INDEX category
  ON category (cat_name);

CREATE INDEX lot_name
  ON lot (name);

CREATE UNIQUE INDEX email
  ON users (email);
CREATE INDEX user_name
  ON users (name);


