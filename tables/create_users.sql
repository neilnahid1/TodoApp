drop table if exists `Users`;
create table Users(
    UserID int primary key AUTO_INCREMENT,
    FirstName varchar(45) not null,
    LastName varchar(45) not null,
    Address varchar(255) not null,
    EmailAddress varchar(255) unique not null,
    ActivationCode varchar(255) unique not null,
    IsEmailVerified boolean default 0,
    Username varchar(45) unique not null,
    Password varchar(255) not null,
    RoleID int,
    foreign key(RoleID) references Roles(RoleID)
);
insert into Users(FirstName,LastName,Address,EmailAddress,Username,Password,RoleID,ActivationCode,IsEmailVerified)
values('Neil','Nahid','Cebu City','neil.nahid1@fullspeectechnologies.com','admin','$2y$10$.XlufFCm1lHPCB7N0qtkOeYqCuGzWEfgbf//AxLXATdz9/upeQnmO',2,"admin",1);