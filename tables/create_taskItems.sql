drop table if exists `TaskItems`;
create table TaskItems(
    TaskItemID int primary key AUTO_INCREMENT,
    Name varchar(255) not null,
    TaskCodeID int not null,
    IsDone boolean not null default 0,
    foreign key(TaskCodeID) references Tasks(TaskCodeID) on delete cascade
);
