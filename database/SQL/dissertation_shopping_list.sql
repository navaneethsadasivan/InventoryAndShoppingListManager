create table shopping_list
(
    id          int auto_increment,
    list_id     varchar(255) null,
    user_id     int          null,
    created_at  datetime     null,
    total_items int          null,
    total_price float        null,
    constraint shopping_list_1_id_uindex
        unique (id),
    constraint shopping_list_1_list_id_uindex
        unique (list_id)
);

alter table shopping_list
    add primary key (id);

INSERT INTO dissertation.shopping_list (id, list_id, user_id, created_at, total_items, total_price) VALUES (6, 'U02T130820003', 2, '2020-08-13 09:48:19', 22, 38.02);
INSERT INTO dissertation.shopping_list (id, list_id, user_id, created_at, total_items, total_price) VALUES (7, 'U02T130820004', 2, '2020-08-13 09:56:17', 29, 52.93);
INSERT INTO dissertation.shopping_list (id, list_id, user_id, created_at, total_items, total_price) VALUES (8, 'U02T130820005', 2, '2020-08-13 10:00:43', 24, 41.44);
INSERT INTO dissertation.shopping_list (id, list_id, user_id, created_at, total_items, total_price) VALUES (9, 'U02T130820006', 2, '2020-08-13 10:04:06', 21, 34.71);
INSERT INTO dissertation.shopping_list (id, list_id, user_id, created_at, total_items, total_price) VALUES (10, 'U02T130820007', 2, '2020-08-13 10:07:55', 27, 52.96);
INSERT INTO dissertation.shopping_list (id, list_id, user_id, created_at, total_items, total_price) VALUES (11, 'U02T130820008', 2, '2020-08-13 10:12:16', 32, 50.42);
INSERT INTO dissertation.shopping_list (id, list_id, user_id, created_at, total_items, total_price) VALUES (12, 'U02T130820009', 2, '2020-08-13 10:16:04', 30, 49.37);
INSERT INTO dissertation.shopping_list (id, list_id, user_id, created_at, total_items, total_price) VALUES (13, 'U02T130820010', 2, '2020-08-13 10:32:26', 25, 40.31);
INSERT INTO dissertation.shopping_list (id, list_id, user_id, created_at, total_items, total_price) VALUES (14, 'U02F140820011', 2, '2020-08-14 15:10:21', 23, 39.88);
INSERT INTO dissertation.shopping_list (id, list_id, user_id, created_at, total_items, total_price) VALUES (25, 'U01T250820012', 1, '2020-08-25 09:09:14', 4, 9.58);
INSERT INTO dissertation.shopping_list (id, list_id, user_id, created_at, total_items, total_price) VALUES (26, 'U02T250820013', 2, '2020-08-25 09:10:41', 3, 3.54);
INSERT INTO dissertation.shopping_list (id, list_id, user_id, created_at, total_items, total_price) VALUES (27, 'U02T250820014', 2, '2020-08-25 09:11:07', 1, 1.49);
INSERT INTO dissertation.shopping_list (id, list_id, user_id, created_at, total_items, total_price) VALUES (29, 'U01S300820015', 1, '2020-08-30 10:33:33', 9, 6.34);
INSERT INTO dissertation.shopping_list (id, list_id, user_id, created_at, total_items, total_price) VALUES (30, 'U01S300820016', 1, '2020-08-30 10:39:58', 13, 15.9);
INSERT INTO dissertation.shopping_list (id, list_id, user_id, created_at, total_items, total_price) VALUES (32, 'U01S300820017', 1, '2020-08-30 10:41:39', 4, 6);
INSERT INTO dissertation.shopping_list (id, list_id, user_id, created_at, total_items, total_price) VALUES (33, 'U01S300820018', 1, '2020-08-30 10:43:56', 1, 1.6);
INSERT INTO dissertation.shopping_list (id, list_id, user_id, created_at, total_items, total_price) VALUES (34, 'U01S300820019', 1, '2020-08-30 10:46:01', 1, 0.85);
INSERT INTO dissertation.shopping_list (id, list_id, user_id, created_at, total_items, total_price) VALUES (35, 'U01S300820020', 1, '2020-08-30 12:33:52', 1, 3);
INSERT INTO dissertation.shopping_list (id, list_id, user_id, created_at, total_items, total_price) VALUES (36, 'U01S300820021', 1, '2020-08-30 12:42:28', 1, 0.8);
INSERT INTO dissertation.shopping_list (id, list_id, user_id, created_at, total_items, total_price) VALUES (37, 'U01T010920022', 1, '2020-09-01 10:20:34', 1, 1.6);
INSERT INTO dissertation.shopping_list (id, list_id, user_id, created_at, total_items, total_price) VALUES (38, 'U01T030920023', 1, '2020-09-03 13:38:43', 2, 3.2);
INSERT INTO dissertation.shopping_list (id, list_id, user_id, created_at, total_items, total_price) VALUES (47, 'Test01', 4, '2020-09-04 10:45:34', 6, 0);
INSERT INTO dissertation.shopping_list (id, list_id, user_id, created_at, total_items, total_price) VALUES (48, 'Test02', 4, '2020-09-04 10:45:34', 4, 0);
INSERT INTO dissertation.shopping_list (id, list_id, user_id, created_at, total_items, total_price) VALUES (49, 'Test03', 4, '2020-09-04 10:45:34', 8, 0);
INSERT INTO dissertation.shopping_list (id, list_id, user_id, created_at, total_items, total_price) VALUES (50, 'Test04', 4, '2020-09-04 10:45:34', 7, 0);
INSERT INTO dissertation.shopping_list (id, list_id, user_id, created_at, total_items, total_price) VALUES (51, 'Test05', 4, '2020-09-04 10:45:34', 5, 0);
INSERT INTO dissertation.shopping_list (id, list_id, user_id, created_at, total_items, total_price) VALUES (56, 'U02F040920001', 2, '2020-09-04 11:03:17', 1, 1.2);
INSERT INTO dissertation.shopping_list (id, list_id, user_id, created_at, total_items, total_price) VALUES (57, 'U02F040920002', 2, '2020-09-04 11:03:57', 5, 6.1);
INSERT INTO dissertation.shopping_list (id, list_id, user_id, created_at, total_items, total_price) VALUES (58, 'U02F040920003', 2, '2020-09-04 11:05:49', 5, 6.1);