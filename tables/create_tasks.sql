drop table if exists `Tasks`;
create table Tasks(
    TaskCodeID int primary key AUTO_INCREMENT,
    Name varchar(255) not null,
    Description text,
    DateCreated datetime default now(),
    DateUpdated datetime,
    UserID int not null,
    IsComplete boolean default 0,
    foreign key(UserID) references Users(UserID) on delete cascade
);
