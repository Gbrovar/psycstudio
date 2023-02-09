CREATE DATABASE IF NOT EXISTS psycstudio;
USE psycstudio;

CREATE TABLE users(
id              int(255) auto_increment not null,
name            varchar(50) NOT NULL,
surename        varchar(100) NOT NULL,
email           varchar(255) NOT NULL,
phone_number    int(255) NOT NULL,
country         varchar(255) NOT NULL,
address         varchar(255) NOT NULL,
password        varchar(255) NOT NULL,
gender          varchar(255) NOT NULL,  
birthday        datetime NOT NULL,
description     text DEFAULT NULL,
therapist_id    int(255) DEFAULT NULL,       
role            varchar(255) NOT NULL,
remember_token  varchar(255),
imge            varchar(255),
created_at      datetime DEFAULT NULL,
update_at       datetime DEFAULT NULL,

CONSTRAINT pk_users PRIMARY KEY(id),
CONSTRAINT fk_user_therapist FOREIGN KEY(therapist_id) REFERENCES therapists(id)
)ENGINE=InnoDb;

CREATE TABLE therapists(
id                  int(255) auto_increment not null,
name                varchar(50) NOT NULL,
surename            varchar(100) NOT NULL,
email               varchar(255) NOT NULL,
password            varchar(255) NOT NULL,
gender              varchar(255) NOT NULL,  
birthday            datetime NOT NULL,
country             varchar(255) NOT NULL,
country_residence   varchar(255) NOT NULL,
address             varchar(255) NOT NULL,
phone_number        int(255) NOT NULL,
description         text DEFAULT NULL, 
id_card             varchar(255) NOT NULL,
collegiate_number   varchar(255) NOT NULL,
graduation_year     int(255) NOT NULL,
graduation_country  varchar(255) NOT NULL,
diploma_img         varchar(255) NOT NULL,
degree              varchar(255) NOT NULL,
areas               varchar(255) NOT NULL,
specialties         varchar(255) NOT NULL,
other_degrees       varchar(255) NOT NULL,
role                varchar(255) NOT NULL,
remember_token      varchar(255),
imge                varchar(255),
created_at          datetime DEFAULT NULL,
update_at           datetime DEFAULT NULL,

CONSTRAINT pk_therapists PRIMARY KEY(id)
)ENGINE=InnoDb;

CREATE TABLE therapist_dates(
id              int(255) auto_increment not null,
therapist_id    int(255) NOT NULL,
start_date      datetime NOT NULL,
end_date        datetime NOT NULL,
schedule_status varchar(255) NOT NULL,
status          varchar(255) NOT NULL,
room_id         varchar(255) NOT NULL,
created_at      datetime DEFAULT NULL,
update_at       datetime DEFAULT NULL,

CONSTRAINT pk_therapist_dates PRIMARY KEY(id),
CONSTRAINT fk_therapist_dates_therapist FOREIGN KEY(therapist_id) REFERENCES therapists(id)
)ENGINE=InnoDb;

CREATE TABLE user_dates(
id                      int(255) auto_increment not null,
user_id                 int(255) NOT NULL,
date_id                 int(255) NOT NULL,
therapist_id            int(255) NOT NULL,
status                  varchar(255) DEFAULT NULL,
transaction_id          int(255) NOT NULL,
user_plan               bit DEFAULT NULL,
user_plan_id            int(255) DEFAULT NULL,
user_subscription       bit DEFAULT NULL,
user_subscription_id    int(255) DEFAULT NULL,
payment_method          varchar(255) NOT NULL,
room_id                 varchar(255) NOT NULL,
created_at              datetime DEFAULT NULL,
update_at               datetime DEFAULT NULL,

CONSTRAINT pk_user_dates PRIMARY KEY(id),
CONSTRAINT fk_user_dates_user FOREIGN KEY(user_id) REFERENCES users(id),
CONSTRAINT fk_user_dates_therapist_dates FOREIGN KEY(date_id) REFERENCES therapist_dates(id),
CONSTRAINT fk_user_dates_therapist FOREIGN KEY(therapist_id) REFERENCES therapists(id),
CONSTRAINT fk_user_dates_user_transaction FOREIGN KEY(transaction_id) REFERENCES user_transactions(id),
CONSTRAINT fk_user_dates_user_plans FOREIGN KEY(user_plan_id) REFERENCES user_plans(id),
CONSTRAINT fk_user_dates_user_subscriptions FOREIGN KEY(user_subscription_id ) REFERENCES user_subscriptions(id)
)ENGINE=InnoDb;

CREATE TABLE user_plans(
id                      int(255) auto_increment not null,
user_id                 int(255) NOT NULL,
plan_id                 int(255) NOT NULL,
transaction_id          int(255) NOT NULL,
credits                 int(255) NOT NULL,
remaining_credits       int(255) NOT NULL,
status                  varchar(255) NOT NULL,
created_at              datetime DEFAULT NULL,
update_at               datetime DEFAULT NULL,

CONSTRAINT pk_user_plans PRIMARY KEY(id),
CONSTRAINT fk_user_plans_user FOREIGN KEY(user_id) REFERENCES users(id),
CONSTRAINT fk_user_plans_plan FOREIGN KEY(plan_id) REFERENCES plans(id),
CONSTRAINT fk_user_plans_user_transaction FOREIGN KEY(transaction_id) REFERENCES user_transactions(id)
)ENGINE=InnoDb;

CREATE TABLE plans(
id              int(255) auto_increment not null,
name            varchar(255) NOT NULL,
description     varchar(255) NOT NULL,
status          varchar(255) NOT NULL,
price           int(255) NOT NULL,
credits         int(255) NOT NULL,
product_id      varchar(255) NOT NULL,
price_id        varchar(255) NOT NULL,
created_at      datetime DEFAULT NULL,
update_at       datetime DEFAULT NULL,

CONSTRAINT pk_plans PRIMARY KEY(id)
)ENGINE=InnoDb;


CREATE TABLE user_subscriptions(
id                      int(255) auto_increment not null,
user_id                 int(255) NOT NULL,

plan_id                 int(255) NOT NULL,
transaction_id          int(255) NOT NULL,
credits                 int(255) NOT NULL,
remaining_credits       int(255) NOT NULL,
status                  varchar(255) NOT NULL,
period_start            datetime NOT NULL,
period_end              datetime NOT NULL,
cancel                  bit DEFAULT NULL,
cancel_at               datetime DEFAULT NULL,
ended_at                datetime DEFAULT NULL,
interval_billing        varchar(255) NOT NULL,       
created_at              datetime DEFAULT NULL,
update_at               datetime DEFAULT NULL,

CONSTRAINT pk_user_subscriptions PRIMARY KEY(id),
CONSTRAINT fk_user_subscriptions_user FOREIGN KEY(user_id) REFERENCES users(id),
CONSTRAINT fk_user_subscriptions_plan FOREIGN KEY(plan_id) REFERENCES plan_subscriptions(id),
CONSTRAINT fk_user_subscriptions_user_transaction FOREIGN KEY(transaction_id) REFERENCES user_transactions(id)
)ENGINE=InnoDb;

CREATE TABLE plan_subscriptions(
id              int(255) auto_increment not null,
name            varchar(255) NOT NULL,
description     varchar(255) NOT NULL,
status          varchar(255) NOT NULL,
price           int(255) NOT NULL,
credits         int(255) NOT NULL,
subscription_id varchar(255) NOT NULL,
product_id      varchar(255) NOT NULL,
price_id        varchar(255) NOT NULL,
created_at      datetime DEFAULT NULL,
update_at       datetime DEFAULT NULL,

CONSTRAINT pk_plans PRIMARY KEY(id)
)ENGINE=InnoDb;

CREATE TABLE user_transactions(
id              int(255) auto_increment not null,
user_id         int(255) NOT NULL,
payment_method  varchar(255) NOT NULL,
payment_id      varchar(255) NOT NULL,
created_at      datetime DEFAULT NULL,
update_at       datetime DEFAULT NULL,

CONSTRAINT pk_user_transactions PRIMARY KEY(id)
)ENGINE=InnoDb;
