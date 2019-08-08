drop table if exists `Roles`;
create table Roles(
    RoleID int primary key AUTO_INCREMENT,
    Name varchar(45)
);
insert into Roles(Name)values("Admin");
insert into Roles(Name)values("User");
