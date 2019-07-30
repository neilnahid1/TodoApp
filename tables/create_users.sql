drop table if exists `Users`;
create table Users(
    UserID int primary key AUTO_INCREMENT,
    Username varchar(45),
    Password varchar(45),
    RoleID int,
    foreign key(RoleID) references Roles(RoleID)
)