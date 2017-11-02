CREATE TABLE ProjectUser (
  username varchar(50) NOT NULL UNIQUE, 
  password varchar(200) NOT NULL, 
  usertype varchar(20)
);


CREATE TABLE Book(
  title varchar(100),
  firstname varchar(50),
  lastname varchar(50),
  copyright int, 
  lexile int, 
  pages int, 
  recommended varchar(1),
  topic varchar(50),
  prot_feat varchar(50), 
  prot_gender varchar(50)
);
