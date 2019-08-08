drop table if exists `Users`;
create table Users(
    UserID int primary key AUTO_INCREMENT,
    FirstName varchar(45) not null,
    LastName varchar(45) not null,
    Address varchar(255) not null,
    Username varchar(45) unique not null,
    Password varchar(255) not null,
    RoleID int,
    foreign key(RoleID) references Roles(RoleID)
);
