
CREATE DATABASE recetarioDataBase;
USE recetarioDataBase;


CREATE TABLE auth(
	idAuth int not null auto_increment,
    webSiteName varchar (255) not null,
    password_ varchar (255) not null,
    img varchar(255) null,
    url varchar(255) not null,
    country varchar(255) not null,
    mark varchar(100) not null,
    creationDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	updateDate TIMESTAMP ON UPDATE CURRENT_TIMESTAMP null,
    primary key PK_idAuth (idAuth)
);
#-------------------------------------RECIPEBOOK----------------------------------------------------------------------------

CREATE TABLE recipeBook(
	idRecipeBook int not null auto_increment,
    recipeBookName varchar(50) not null,
	performance varchar(255) not null,
	descriptionRecipe varchar(255) not null,
	img varchar(255) not null,
    url varchar(255) not null,
    creationDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	updateDate TIMESTAMP ON UPDATE CURRENT_TIMESTAMP null,
    idAuth int not null,
    primary key PK_idRecipeBook (idRecipeBook),
	foreign key  (idAuth) references auth(idAuth)
);


CREATE TABLE headerProcedureRecipeBook(
	idHeaderProcedureRecipeBook int not null auto_increment,
    headerProcedure varchar(50) not null,
    idRecipeBook int not null,
    primary key PK_idHeaderProcedureRecipeBook (idHeaderProcedureRecipeBook),
	foreign key  (idRecipeBook) references recipeBook(idRecipeBook)

);

CREATE TABLE procedureRecipeBook(
	idProcedureRecipeBook int not null auto_increment,
    procedureRecipeBookStep longtext not null,
    idHeaderProcedureRecipeBook int not null,
	primary key PK_idProcedureRecipeBook (idProcedureRecipeBook),
	foreign key  (idHeaderProcedureRecipeBook) references headerProcedureRecipeBook(idHeaderProcedureRecipeBook)

);

CREATE TABLE headerIngredientRecipeBook(
	idHeaderIngredientRecipeBook int not null auto_increment,
    headerName varchar(50) not null,
    idRecipeBook int not null,
    primary key PK_idHeaderIngredientRecipeBook (idHeaderIngredientRecipeBook),
	foreign key  (idRecipeBook) references recipeBook(idRecipeBook)

);

CREATE TABLE ingredientRecipeBook(
	idIngredient int not null auto_increment,
    ingredientDatail longtext not null,
    percentage varchar (50) not null,
    quantityPounds varchar(15),
    quantityOunces varchar(15),
    idHeaderIngredientRecipeBook int not null,
    primary key PK_idIngredient (idIngredient),
	foreign key  (idHeaderIngredientRecipeBook) references headerIngredientRecipeBook(idHeaderIngredientRecipeBook)
);

#-------------------------------------RECIPE--------------------------------------------------------------------------------
CREATE TABLE recipe(
	idRecipe int not null auto_increment,
    recipeName varchar(50) not null,
	performance varchar(255) not null,
	descriptionRecipe varchar(255) not null,
    img varchar(255) not null,
    url varchar(255) not null,
    creationDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	updateDate TIMESTAMP ON UPDATE CURRENT_TIMESTAMP null,
    idAuth int not null,
    primary key PK_idRecipe (idRecipe),
	foreign key  (idAuth) references auth(idAuth)
);

CREATE TABLE headerProcedureRecipe(
	idHeaderProcedureRecipe int not null auto_increment,
    headerProcedure varchar(50) not null,
    idRecipe int not null,
    primary key PK_idHeaderProcedureRecipe (idHeaderProcedureRecipe),
	foreign key  (idRecipe) references recipe(idRecipe)

);

CREATE TABLE procedureRecipe(
	idProcedureRecipe int not null auto_increment,
    procedureRecipeStep longtext not null,
    idHeaderProcedureRecipe int not null,
	primary key PK_idProcedureRecipe (idProcedureRecipe),
	foreign key  (idHeaderProcedureRecipe) references headerProcedureRecipe(idHeaderProcedureRecipe)

);

CREATE TABLE headerIngredientRecipe(
	idHeaderIngredientRecipe int not null auto_increment,
    headerName varchar(50) not null,
    idRecipe int not null,
    primary key PK_idHeaderIngredientRecipe (idHeaderIngredientRecipe),
	foreign key  (idRecipe) references recipe(idRecipe)

);

CREATE TABLE ingredientRecipe(
	idIngredient int not null auto_increment,
    ingredientDatail longtext not null,
    percentage varchar (50) not null,
    quantityPounds varchar(15),
    quantityOunces varchar(15),
    idHeaderIngredientRecipe int not null,
    primary key PK_idIngredient (idIngredient),
	foreign key  (idHeaderIngredientRecipe) references headerIngredientRecipe(idHeaderIngredientRecipe)
);

select * from procedureRecipeBook;

#--------------------RecipeBook Complete---------------------
select * from recipeBook;

SELECT re.recipeBookName, he.headerName,re.img, re.url, re.creationDate, re.updateDate, pr.ingredientDatail, pr.percentage, pr.quantityPounds, pr.quantityOunces, re.performance
FROM ingredientRecipeBook pr
 JOIN headerIngredientRecipeBook he 
ON pr.idHeaderIngredientRecipeBook =he.idHeaderIngredientRecipeBook 
JOIN recipeBook re  
ON re.idRecipeBook=he.idRecipeBook
WHERE re.idAuth=1 and re.idRecipeBook=1;

SELECT he.headerProcedure, pr.procedureRecipeBookStep
FROM headerProcedureRecipeBook he
JOIN procedureRecipeBook pr 
ON he.idHeaderProcedureRecipeBook =pr.idHeaderProcedureRecipeBook
JOIN recipeBook re  
ON re.idRecipeBook=he.idRecipeBook
WHERE re.idAuth=1 and re.idRecipeBook=1;

SELECT descriptionRecipe FROM recipeBook  WHERE idAuth=1;


#--------------------Recipe Complete---------------------

/* 2 RECIPE */ 
SELECT re.recipeName, he.headerName,re.img, re.url, re.creationDate, re.updateDate, pr.ingredientDatail, pr.percentage, pr.quantityPounds, pr.quantityOunces, re.performance
FROM ingredientRecipe pr
JOIN headerIngredientRecipe he 
ON pr.idHeaderIngredientRecipe =he.idHeaderIngredientRecipe 
JOIN recipe re  
ON re.idRecipe=he.idRecipe
WHERE re.idAuth=1 and re.idRecipe=1;

SELECT he.headerProcedure, pr.procedureRecipeStep
FROM headerProcedureRecipe he
JOIN procedureRecipe pr 
ON he.idHeaderProcedureRecipe =pr.idHeaderProcedureRecipe
JOIN recipe re  
ON re.idRecipe=he.idRecipe
WHERE re.idAuth=1;

SELECT descriptionRecipe FROM recipe  WHERE idRecipe=1;

