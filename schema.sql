create database if not exists minishop_cse485;
use minishop_cse485;
character set utf8mb4 collate utf8mb4_unicode_ci;
create table categories(
    id int unsigned auto_increament primary key,
    name varchar(255) not null unique,
    description varchar(255) null,
    create_at timestamp default current_timestamp,
);
insert into categories(name, description) values
('Ban phim','Danh muc ban phim co / membrane'),
('Chuot','Danh muc chuot may tinh'),
('Man hinh','Danh muc man hinh');