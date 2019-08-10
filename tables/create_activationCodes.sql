drop table if exists `activations`;
create table Activations(
    ActivationCode int primary key,
    UserID int not null unique,
    foreign key(UserID) references Users(UserID)
)