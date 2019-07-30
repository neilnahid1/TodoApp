drop table if exists `Tasks`;
create table Tasks(
    TaskID int primary key AUTO_INCREMENT,
    Name varchar(45),
    Date datetime,
    TodoCodeID int,
    foreign key(TodoCodeID) references Todos(TodoCodeID)
)