drop table if exists `Todos`;
create table Todos(
    TodoCodeID int primary key AUTO_INCREMENT,
    Name varchar(45),
    UserID int,
    foreign key(UserID) references Users(UserID)
)