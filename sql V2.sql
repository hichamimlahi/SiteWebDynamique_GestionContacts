drop database if exists contacts2;
create database contacts2;
use contacts2;
create table utilisateurs (
    id int auto_increment primary key,
    nom_utilisateur varchar(50) not null unique,
    mot_de_pass varchar(255) not null
);
create table personnes (
    id int auto_increment primary key,
    nom varchar(255) not null,
    prenom varchar(255) not null,
    telephone varchar(20),
    email varchar(255),
    photo varchar(255),
    id_utilisateur int,
    D_ajoute date not null,
    foreign key (id_utilisateur) references utilisateurs(id) on delete cascade
);