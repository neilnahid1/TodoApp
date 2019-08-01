drop table if exists `Users`;
create table Users(
    UserID int primary key AUTO_INCREMENT,
    Username varchar(45) unique not null,
    Password varchar(255) unique not null,
    RoleID int,
    foreign key(RoleID) references Roles(RoleID)
)