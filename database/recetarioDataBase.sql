
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
    creationDate DATE not null,
    updateDate DATE,
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
    creationDate DATE not null,
    updateDate DATE,
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
    img varchar(255) not null,
    url varchar(255) not null,
    creationDate DATE not null,
    updateDate DATE,
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


#----------------------------------------------------Inserts RecipeBook-------------------------------------------
insert into recipeBook (recipeBookName,performance,descriptionRecipe,img,url,idAuth) values ("RoscaPintada","Rendimiento: 130 Unidades de 1.5 Onzas","Revise la calidad de sus ingredientesVerifique que los utensilios a utilizar estén limpios .Una onza equivale a 28 gramos. Una libra equivale a 0.453592 kilo.","https://cmiharinaslivescc.sana-cloud.net/content/files/images/recetario/portada-recetario/rosca-pintada.jpg","https://cmiharinaslivescc.sana-cloud.net/recetario_roscapintada",1);


#-- Register from headerProcedureRecipeBook
insert into headerProcedureRecipeBook (headerProcedure, idRecipeBook) values ("Amor en un brazo Gitano","1");
insert into headerProcedureRecipeBook (headerProcedure, idRecipeBook) values ("Corazones Rojos","1");
insert into headerProcedureRecipeBook (headerProcedure, idRecipeBook) values ("Brazo Gitano con Anicillos","1");


# -- Register from procedureRecipeBook
			#--- Amor en un grazo gitano

insert into procedureRecipeBook (procedureRecipeBookStep, idHeaderProcedureRecipeBook) values ("1. Pesar correctamente la premezcla, los huevos, el aceite y el agua", 1);
insert into procedureRecipeBook (procedureRecipeBookStep, idHeaderProcedureRecipeBook) values ("2. Colocar en la batidora; premezcla, huevos y agua.", 1);
insert into procedureRecipeBook (procedureRecipeBookStep, idHeaderProcedureRecipeBook) values ("3. Mezclar medio minuto en la velocidad más baja con la paleta.", 1);
insert into procedureRecipeBook (procedureRecipeBookStep, idHeaderProcedureRecipeBook) values ("4. Cambiar a velocidad media y mezclar por 3 minutos.", 1);
insert into procedureRecipeBook (procedureRecipeBookStep, idHeaderProcedureRecipeBook) values ("5. Limpiar el tazón de la batidora con espátula.", 1);
insert into procedureRecipeBook (procedureRecipeBookStep, idHeaderProcedureRecipeBook) values ("6. Agregar aceite y mezclar por 1 min. En 2da velocidad.", 1);
insert into procedureRecipeBook (procedureRecipeBookStep, idHeaderProcedureRecipeBook) values ("7. Colocar esta preparación en una bandeja de panadería con papel mantequilla.", 1);
insert into procedureRecipeBook (procedureRecipeBookStep, idHeaderProcedureRecipeBook) values ("8. Hornear a 200°C (392 °F) de 4 a 5 minutos máximo.", 1);
insert into procedureRecipeBook (procedureRecipeBookStep, idHeaderProcedureRecipeBook) values ("9. Dejar enfriar y decorar.", 1);

			#--- Corazones rojos
insert into procedureRecipeBook (procedureRecipeBookStep, idHeaderProcedureRecipeBook) values ("1. Pesar todos los ingredientes.", 2);
insert into procedureRecipeBook (procedureRecipeBookStep, idHeaderProcedureRecipeBook) values ("2. Agregar al tazón de la batidora, harina suave, margarina azúcar glasé y mezclar con paleta en 2da velocidad hasta obtener una mezcla fina y sin grumos.", 2);
insert into procedureRecipeBook (procedureRecipeBookStep, idHeaderProcedureRecipeBook) values ("3. Seguido incorporar las claras de huevo y mezclar a velocidad media hasta lograr una mezcla uniforme.", 2);
insert into procedureRecipeBook (procedureRecipeBookStep, idHeaderProcedureRecipeBook) values ("4. De la mezcla anterior preparar dos colores, Uno rojo para los corazones y otro rosado para los puntos, usar colorante en gel.", 2);
insert into procedureRecipeBook (procedureRecipeBookStep, idHeaderProcedureRecipeBook) values ("5. Colocar en refrigeración esta preparación  por un tiempo de 1 hora. Con esto evitara que el diseño se pegue en el papel a la hora de desmoldar. ", 2);
insert into procedureRecipeBook (procedureRecipeBookStep, idHeaderProcedureRecipeBook) values ("6. Imprimir en una hoja de papel bond una plantilla con corazones y colocarla  a lo ancho de la bandeja, encima de la plantilla colocar el papel mantequilla para repasar los corazones con la pasta cigarrete previamente preparada.", 2);
insert into procedureRecipeBook (procedureRecipeBookStep, idHeaderProcedureRecipeBook) values ("7. Seguido agregar la mezcla de brazo gitano con mucho cuidado para evitar dañar el diseño, puede ayudarse con una espátula para que quede bien distribuido.", 2);
insert into procedureRecipeBook (procedureRecipeBookStep, idHeaderProcedureRecipeBook) values ("8. Hornear a temperatura de 200°C (392°F) de 4 a 5 min.", 2);
insert into procedureRecipeBook (procedureRecipeBookStep, idHeaderProcedureRecipeBook) values ("9. Al sacar del horno, dejar enfriar unos minutos para luego enrollarlo con una manta húmeda. Ya enrollado dejar reposar unos minutos.", 2);
insert into procedureRecipeBook (procedureRecipeBookStep, idHeaderProcedureRecipeBook) values ("10. Desenrolle su brazo gitano y rellene con crema batida de su preferencia. Seguido enrrollar nuevamente.", 2);

			#--- Brazo Gitano con Anicillos
insert into procedureRecipeBook (procedureRecipeBookStep, idHeaderProcedureRecipeBook) values ("1. Con la misma formulación preparar una plancha de brazo gitano de vainilla.", 3);
insert into procedureRecipeBook (procedureRecipeBookStep, idHeaderProcedureRecipeBook) values ("2. Seguir los pasos anteriores de preparación y horneo.", 3);
insert into procedureRecipeBook (procedureRecipeBookStep, idHeaderProcedureRecipeBook) values ("3. Aplicarle el relleno de su preferencia y enrollar.", 3);
insert into procedureRecipeBook (procedureRecipeBookStep, idHeaderProcedureRecipeBook) values ("4. Para la decoración, aplicar una cantidad mínima de crema batida como cobertura.", 3);
insert into procedureRecipeBook (procedureRecipeBookStep, idHeaderProcedureRecipeBook) values ("5. En una bandeja pequeña aplicar las mismas proporciones de anicillos color blanco, rojo y rosado donde volcaremos el brazo gitano.", 3);
insert into procedureRecipeBook (procedureRecipeBookStep, idHeaderProcedureRecipeBook) values ("6. Con mucho cuidado rebosar el brazo gitano sobre los anicillos para que se adhieran a la cobertura.", 3);
insert into procedureRecipeBook (procedureRecipeBookStep, idHeaderProcedureRecipeBook) values ("7. Por ultimo montarlo en una bandeja especial para brazo y a disfrutar!!", 3);


# -- Register from headerIngredient
insert into headerIngredientRecipeBook (headerName,idRecipeBook) values ("AMOR EN UN BRAZO GITANO",1);
insert into headerIngredientRecipeBook (headerName,idRecipeBook) values ("PASTA CIGARRETE",1);


# -- Register from ingredientBook

	#--- Amor en brazo gitano
insert into ingredientRecipeBook (ingredientDatail,percentage, quantityPounds,quantityOunces, idHeaderIngredientRecipeBook) values ("Premezcla de Vainilla Chocolate o Blanco MM","100%","1","-", 1);
insert into ingredientRecipeBook (ingredientDatail,percentage, quantityPounds,quantityOunces, idHeaderIngredientRecipeBook) values ("Huevo","75%","-","12.00", 1);
insert into ingredientRecipeBook (ingredientDatail,percentage, quantityPounds,quantityOunces, idHeaderIngredientRecipeBook) values ("Aceite","12.5%","-","2.00", 1);
insert into ingredientRecipeBook (ingredientDatail,percentage, quantityPounds,quantityOunces, idHeaderIngredientRecipeBook) values ("Manteca/ Aceite","12.5%","-","2.00", 1);

	#--- PASTA CIGARRETE
insert into ingredientRecipeBook (ingredientDatail,percentage, quantityPounds,quantityOunces, idHeaderIngredientRecipeBook) values ("Harina Suave","4.00","LB","-", 2);
insert into ingredientRecipeBook (ingredientDatail,percentage, quantityPounds,quantityOunces, idHeaderIngredientRecipeBook) values ("Margarina","4.00","Onzas","-", 2);
insert into ingredientRecipeBook (ingredientDatail,percentage, quantityPounds,quantityOunces, idHeaderIngredientRecipeBook) values ("Azucar Glass","3.00","Onzas","-", 2);



#------------------------------------------------------------------Inserts Recipe-------------------------------------------------------------------------------------------------
insert into recipe (recipeName,performance,descriptionRecipe,img,url, idAuth) values ("RoscaPintada","2 unidades","Revise la calidad de sus ingredientesVerifique que los utensilios a utilizar estén limpios .Una onza equivale a 28 gramos. Una libra equivale a 0.453592 kilo.","https://cmiharinaslivescc.sana-cloud.net/content/files/images/recetario/portada-recetario/rosca-pintada.jpg","https://cmiharinaslivescc.sana-cloud.net/recetario_roscapintada",1);



#-- Register from headerProcedureRecipe
insert into headerProcedureRecipe (headerProcedure, idRecipe) values ("Proceso","1");



# -- Register from procedureRecipe
insert into procedureRecipe (procedureRecipeStep, idHeaderProcedureRecipe) values ("1. Pesa muy bien los ingredientes. Amasa todos los ingredientes por 2 minutos y desarrolla el gluten hasta lograr una textura elástica.", 1);
insert into procedureRecipe (procedureRecipeStep, idHeaderProcedureRecipe) values ("2. Ponla a reposar durante 5 minutos.", 1);
insert into procedureRecipe (procedureRecipeStep, idHeaderProcedureRecipe) values ("3. Pesa unidades de 300 a 400 gramos o de 11 a 14 onzas y ponlas a reposar durante 3 minutos.", 1);
insert into procedureRecipe (procedureRecipeStep, idHeaderProcedureRecipe) values ("4. Figura y fermenta por 3 horas. 5. Haz cortes y hornea.", 1);


# -- Register from headerIngredientRecipe
insert into headerIngredientRecipe (headerName,idRecipe) values ("Ingredientes",1);
insert into headerIngredientRecipe (headerName,idRecipe) values ("(Masa madre 10-30%)",1);
select *from headerIngredientRecipe;


# -- Register from ingredient
       #--- Header Ingredient
insert into ingredientRecipe (ingredientDatail,percentage, quantityPounds,quantityOunces, idHeaderIngredientRecipe) values ("Harina Espiga Artesana	","100%","2","-", 1);
insert into ingredientRecipe (ingredientDatail,percentage, quantityPounds,quantityOunces, idHeaderIngredientRecipe) values ("Agua fría","54%","1","11/4", 1);
insert into ingredientRecipe (ingredientDatail,percentage, quantityPounds,quantityOunces, idHeaderIngredientRecipe) values ("Sal","2%","-","3/2", 1);
insert into ingredientRecipe (ingredientDatail,percentage, quantityPounds,quantityOunces, idHeaderIngredientRecipe) values ("Levadura roja","2%","-","1/4", 1);
insert into ingredientRecipe (ingredientDatail,percentage, quantityPounds,quantityOunces, idHeaderIngredientRecipe) values ("Azúcar","1%","-","1/4", 1);

       #--- Header Masa Madre
insert into ingredientRecipe (ingredientDatail,percentage, quantityPounds,quantityOunces, idHeaderIngredientRecipe) values ("Harina Espiga Artesana","100%","1","8", 2);
insert into ingredientRecipe (ingredientDatail,percentage, quantityPounds,quantityOunces, idHeaderIngredientRecipe) values ("Levadura fresca","0.15%","-","1 gramo", 2);
insert into ingredientRecipe (ingredientDatail,percentage, quantityPounds,quantityOunces, idHeaderIngredientRecipe) values ("Agua","60%","-","14", 2);





