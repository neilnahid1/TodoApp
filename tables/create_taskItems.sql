drop table if exists `TaskItems`;
create table TaskItems(
    TaskItemID int primary key AUTO_INCREMENT,
    Description varchar(45),
    IsDone boolean,
    TaskCodeID int,
    foreign key(TaskCodeID) references Tasks(TaskCodeID)
) 