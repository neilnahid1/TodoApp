drop table if exists `Tasks`;
create table Tasks(
    TaskCodeID int primary key AUTO_INCREMENT,
    Name varchar(255),
    Description text,
    UserID int,
    IsComplete boolean,
    foreign key(UserID) references Users(UserID)
);
