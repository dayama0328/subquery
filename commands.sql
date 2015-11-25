create database subquery;

use subquery;


grant all on subquery.* to testuser@localhost identified by '9999';

create table sales (
member_id int primary key auto_increment,
sale varchar(32),
month varchar(32)
);

create table members (
member_id int primary key auto_increment,
name varchar(32)
);

create table age (
member_id int primary key auto_increment,
age int(32)
);

INSERT INTO sales (member_id , sale, month) VALUES
(1,75,4),
(2,200,5),
(3,15,6),
(4,700,5),
(5,672,4),
(6,56,8),
(7,231,9),
(8,459,8),
(9,8,7),
(10,120,4);

INSERT INTO members (member_id , name) VALUES
(1,"Tanaka"),
(2,"Sato"),
(3,"Suzuki"),
(4,"Tsuchiya"),
(5,"Yamada"),
(6,"Sasaki"),
(7,"Harada"),
(8,"Takahashi"),
(9,"Nishida"),
(10,"Nakada");

INSERT INTO age (member_id , age) VALUES
(1,24),
(2,25),
(3,47),
(4,55),
(5,39),
(6,26),
(7,43),
(8,33),
(9,24),
(10,20);

select * from members where member_id = (select member_id from sales order by sale desc limit 1);

select * from sales where sale >  (select avg(sale) from sales);

売上の平均以上を達成した社員の名前
SELECT DISTINCT m.name FROM sales AS s INNER JOIN members AS m ON s.member_id = m.member_id WHERE s.sale > (SELECT AVG(sale) FROM sales);

30歳以下の各個人の売上
select sum(sale) from age join sales on age.member_id = sales.member_id where age <= 30;







