drop table if exists `Tasks`;
create table Tasks(
    TaskCodeID int primary key AUTO_INCREMENT,
    Name varchar(45),
    Description varchar(255),
    UserID int,
    IsComplete boolean,
    foreign key(UserID) references Users(UserID)
)