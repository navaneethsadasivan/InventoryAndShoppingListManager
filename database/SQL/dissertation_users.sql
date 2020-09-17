create table users
(
    id                bigint unsigned auto_increment
        primary key,
    name              varchar(255) not null,
    email             varchar(255) not null,
    email_verified_at timestamp    null,
    password          varchar(255) not null,
    api_token         varchar(80)  null,
    remember_token    varchar(100) null,
    created_at        timestamp    null,
    updated_at        timestamp    null,
    constraint users_api_token_unique
        unique (api_token),
    constraint users_email_unique
        unique (email)
)
    collate = utf8mb4_unicode_ci;

INSERT INTO dissertation.users (id, name, email, email_verified_at, password, api_token, remember_token, created_at, updated_at) VALUES (1, 'Navaneeth Sadasivan', 'navaneeth.sadasivan@gmail.com', null, '$2y$10$k3RaC9ZG4jqFL58wS4Y9xOjf4FHVsPRvYxm99poqGxCLVe33//m3W', 'aUQwCVHYUEmS2T2r6aleQdyTlyqwvOFy9ayJC0dcBmQx6aaWu8o0s7u9TJbv', null, '2020-09-11 11:57:33', '2020-09-11 11:57:33');
INSERT INTO dissertation.users (id, name, email, email_verified_at, password, api_token, remember_token, created_at, updated_at) VALUES (2, 'Test User', 'navaneeth.sadasivan@hotmail.com', null, '$2y$10$fmECGWwlubr7SW3GkmNPp.teIlu0qTWP6xVNybW8ZC26U.2Fecj8S', 'Ccj5YlIHQY8QLJTiSN9tm2C5rihEbJItXm2V6P8nWXd51TNAEgttyjRB5cij', null, '2020-09-13 17:38:34', '2020-09-13 17:38:34');
INSERT INTO dissertation.users (id, name, email, email_verified_at, password, api_token, remember_token, created_at, updated_at) VALUES (4, 'TestDummy', 'testdummy@dummy.com', null, '$2y$10$VBa6maXZQcDD9whGwg2BDedDhdklLOe/Sj2g48pPFGuxASLIiod/6', 'SGp7bwHAdYO7R9noc6Nf2yjsZokT4woZTmHBEpgLBL6sj80D6ftiG43iuImk', null, '2020-09-13 17:26:47', '2020-09-13 17:26:47');
INSERT INTO dissertation.users (id, name, email, email_verified_at, password, api_token, remember_token, created_at, updated_at) VALUES (5, 'Final_Test', 'finalTest@test.com', null, '$2y$10$boxyvI391qgXexEzWtE00.Rz0DE.CcInmenwvVgknqspgykq95f/2', '5JRXwxz3bEMs6qnJF7wPHZNIaXcowYqn8Fl0dY56QMZ3ov8v7S5L6N4j1vP3', null, '2020-09-17 12:32:34', '2020-09-17 12:32:34');