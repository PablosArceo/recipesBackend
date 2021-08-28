
CREATE DATABASE recetarioDataBase;
USE recetarioDataBase;

CREATE TABLE auth(
	idAuth int not null auto_increment,
    webSiteName varchar (255) not null,
    password_ varchar (255) not null,
    primary key PK_idAuth (idAuth)
);

CREATE TABLE recipeBook(
	idRecipeBook int not null auto_increment,
    recipeBookName varchar(50) not null,
	performance varchar(255) not null,
	descriptionRecipe varchar(255) not null,
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
	descriptionRecipe varchar(255) not null,
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


#----------------------------recipeBook-----------------------------

# -- Register from Auth
insert into auth (webSiteName, password_) values ("molinosModernos","admin100");


#---- Register from recipeBook

insert into recipeBook (recipeBookName,performance,descriptionRecipe,idAuth) values ("Amor en un brazo gitano","Rendimiento: 2 Unidades de 1 Libra y 4 Onzas","REVISE LA CALIDAD DE SUS INGREDIENTES, Revise la calidad de sus ingredientes, Verifique que los utensilios a utilizar estén limpios, Lave correctamente sus manos.",1);



#-- Register from headerProcedureRecipeBook
insert into headerProcedureRecipeBook (headerProcedure, idRecipeBook) values ("Amor en un brazo Gitano","1");


# -- Register from procedureRecipeBook
insert into procedureRecipeBook (procedureRecipeBookStep, idHeaderProcedureRecipeBook) values ("1. Pesar correctamente la premezcla, los huevos, el aceite y el agua", 1);



# -- Register from headerIngredient
insert into headerIngredientRecipeBook (headerName,idRecipeBook) values ("AMOR EN UN BRAZO GITANO",1);


# -- Register from ingredientBook
insert into ingredientRecipeBook (ingredientDatail,percentage, quantityPounds,quantityOunces, idHeaderIngredientRecipeBook) values ("Premezcla de Vainilla Chocolate o Blanco MM","100%","1","-", 1);




#----------------------recipe---------------------------------------------------------------------



#---- Register from recipeBook

insert into recipe (recipeName,descriptionRecipe,idAuth) values ("baguette","Tiempo de horneado: 30 minutos (depende del tamaño)Temperatura del horno 180 °C / 355 °FUna onza equivale a 28 gramos. Una libra equivale a 0.453592 kilo.",1);



#-- Register from headerProcedureRecipe
insert into headerProcedureRecipe (headerProcedure, idRecipe) values ("Ingredientes","1");


# -- Register from procedureRecipe
insert into procedureRecipe (procedureRecipeStep, idHeaderProcedureRecipe) values ("1. Pesa muy bien los ingredientes. Amasa todos los ingredientes por 2 minutos y desarrolla el gluten hasta lograr una textura elástica.", 1);



# -- Register from headerIngredientRecipe
insert into headerIngredientRecipe (headerName,idRecipe) values ("Ingredientes",1);


# -- Register from ingredientBook
insert into ingredientRecipe (ingredientDatail,percentage, quantityPounds,quantityOunces, idHeaderIngredientRecipe) values ("Harina Espiga Artesana	","100%","2","-", 1);
