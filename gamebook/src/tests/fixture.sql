DROP DATABASE gamebook_tests;
CREATE DATABASE gamebook_tests;

CREATE TABLE gamebook_tests.game (
    id int(10) unsigned auto_increment,
    title varchar(50),
    image_path varchar(255),
    primary key (id)
);

CREATE TABLE gamebook_tests.user (
    id int(10) unsigned auto_increment,
    username varchar(50),
    primary key (id)
);

CREATE TABLE gamebook_tests.rating (
    user_id int(10) unsigned,
    game_id int(10) unsigned,
    score tinyint(1),
    primary key (user_id, game_id)
);

insert into gamebook_tests.user values(1, 'frank');
insert into gamebook_tests.game values(1, 'Game 1', '');
insert into gamebook_tests.rating values(1, 1, 5);