create table foas(
folio int,
foa bigint,
lat float,
lon float,
zon varchar(25),
q varchar(15),
fecha varchar(20))

drop table foas
select * from foas


CREATE TABLE usuarios (
    id INT IDENTITY(1,1) PRIMARY KEY,
    nombre VARCHAR(30),
    usuario VARCHAR(30),
    rol VARCHAR(30),
    pass VARCHAR(300),
    estado VARCHAR(20),
	correo VARCHAR(200),
	codigo varchar(10)
);
select * from usuarios
delete usuarios
drop table usuarios

CREATE TABLE sesiones (
    id VARCHAR(128) NOT NULL PRIMARY KEY,
    ip_address VARCHAR(45) NOT NULL,
    timestamp INT NOT NULL,
    data TEXT
);

select * from sesiones
delete sesiones
drop table ci_sessions
CREATE TABLE ci_sessions (
    id varchar(128) NOT NULL,
    ip_address varchar(45) NOT NULL,
    timestamp bigint DEFAULT 0 NOT NULL,
    data varchar(max) DEFAULT '' NOT NULL
);


/*ids*/
CREATE TABLE ids(
CLAVE_PQG varchar(7),
NOMBRE_INDICADOR varchar(150),
NOMBRE_META varchar(300),
DescripcionOA varchar(400),
Modalidad varchar(150),
Nombre_Simplificado varchar(200),
ID_META_SED int,
id_Categoria int,
subcategoria int,
idTipoObraAccion int,
idTipo int,
idStatusObraAccion int,
idStatusAvance int,
idSituacion int,
Detallado_meta int,
idTipoBeneficiario_Hombre int,
idTipoBeneficiario_Mujer int,
AlineaciónPSPG int,
Como_abona varchar(150),
Alineación_PEJ int,
Como_abona_2 varchar(200),
idEnfoque_1 int,
Justificacion_1 varchar(50),
idEnfoque_2 int,
Justificacion_2 varchar(100)
)
drop table ids
select * from ids
/*archivos*/
CREATE TABLE archivos (
fecha VARCHAR (30),
beneficiarios VARCHAR(150),
igto varchar(150),
igto_ varchar(150),
estado varchar(60),
mes int,
ano int)

select * from archivos
delete archivos
drop table archivos

/* cEstados no tiene primary key*/
select * from cEstados

/*metas*/
CREATE TABLE cmetas (
programa VARCHAR (6),
indicador VARCHAR(300),
nombre varchar(350),
id_entregable int,
categoria int,
subcategoria int)

select * from cmetas
drop table metas

/*cMontos*/
CREATE TABLE cMontos (
programa VARCHAR (6),
modalidad VARCHAR(300),
monto int)

select * from cMontos

/*cCategorias*/
CREATE TABLE cCategorias (
idCategoria INT PRIMARY KEY,
Categoria VARCHAR(100))

select * from cCategorias

/*cTiposObrasAcciones*/
CREATE TABLE cTiposObrasAcciones (
idTipoObraAccion INT PRIMARY KEY,
TipoObraAccion VARCHAR(30))

select * from cTiposObrasAcciones

/*04.- cSubCategorias*/
CREATE TABLE cSubCategorias (
idCategoria INT,
idSubCategoria INT,
SubCategoria VARCHAR(150))

select * from cSubCategorias
drop table cSubCategorias

/*05.- cEnfoques*/
CREATE TABLE cEnfoques (
idEnfoque INT,
Enfoque VARCHAR(50),
idTipoEnfoque INT)

select * from cEnfoques
/*drop table cEnfoques*/


/*08.- cTipos*/
CREATE TABLE cTipos (
idTipo INT,
Tipo VARCHAR(50),
Obra INT,
Accion INT)

select * from cTipos
/*drop table cEnfoques*/


/*09. cStatusObrasAcciones*/
CREATE TABLE cStatusObrasAcciones (
idStatusObraAccion INT,
StatusObraAccion VARCHAR(50),
Representacion VARCHAR(20),
DescripcionDGPI VARCHAR(50))

select * from cStatusObrasAcciones
/*drop table cStatusObrasAcciones*/

/*13.- cStatusAvance*/
CREATE TABLE cStatusAvance (
idStatusAvance INT,
StatusAvance VARCHAR(50),
Descripcion VARCHAR(150),
idStatusEjecutivo INT,
Tipo VARCHAR(50))

select * from cStatusObrasAcciones
/*drop table cStatusAvance*/


/*14.- cDependencias*/
CREATE TABLE cDependencias (
idDependencia INT,
idEje INT,
cveDependencia INT,
Dependencia VARCHAR(150),
Siglas VARCHAR(50))

select * from cDependencias
/*drop table cDependencias*/


/*15.- cMunicipios*/
CREATE TABLE cMunicipios (
idMunicipio INT,
idEstado INT,
ClaveMunicipio VARCHAR (5),
NombreMunicipio VARCHAR(100))

select * from cMunicipios
/*drop table cMunicipios*/


/*18.- cLocalidades*/
CREATE TABLE cLocalidades (
idLocalidad INT,
ClaveLocalidad VARCHAR(4),
Localidad VARCHAR (150),
idEstado INT,
idMunicipio INT,
TipoLocalidad VARCHAR(50),
Latitud FLOAT,
Longitud FLOAT,
Altitud INT,
PoblacionTotal INT,
PoblacionMasculina INT,
PoblacionFemenina INT,
TotalViviendasHabitadas INT)

CREATE TABLE cLocalidades_ (
idMunicipio INT,
idLocalidad varchar(9))

select * from cLocalidades
/*drop table cLocalidades_*/


/*19.- cZonasImpulso*/
CREATE TABLE cZonasImpulso (
Ejercicio INT,
idZonaImpulso INT,
nombre VARCHAR (15),
cve_mun INT,
origen VARCHAR (50),
poblacion_total INT,
viviendas_totales INT,
personas_encuestadas INT,
viviendas_encuestadas INT,
coordenadasCentro INT,
Etapa INT,
cve_impuls VARCHAR(15))

select * from cZonasImpulso
/*drop table cZonasImpulso*/


/*22.- cCentrosTrabajo*/
CREATE TABLE cCentrosTrabajo (
idCCT INT,
ClaveCCT VARCHAR(50),
NombreCCT VARCHAR(300),
Nivel VARCHAR (50),
Modalidad VARCHAR(300),
Sostenimiento VARCHAR (300),
Estatus VARCHAR(10),
Domicilio VARCHAR(300),
Region VARCHAR(100),
idMunicipio INT,
CP VARCHAR(10),
Poblacion VARCHAR(30),
Marginacion VARCHAR(40),
Longitud FLOAT,
Latitud FLOAT,
Turno VARCHAR(30),
Provisional VARCHAR(10))

select * from cCentrosTrabajo
/*drop table cCentrosTrabajo*/


/*32.- cTiposAsentamientos*/
CREATE TABLE cTiposAsentamientos (
idTipoAsentamiento INT,
TipoAsentamiento VARCHAR(50))

select * from cTiposAsentamientos
/*drop table cTiposAsentamientos*/


/*33.- cTiposVialidades*/
CREATE TABLE cTiposVialidades (
idTipoVialidad INT,
TipoVialidad VARCHAR(20))

select * from cTiposVialidades
/*drop table cTiposVialidades*/

/*35.- cSituaciones*/
CREATE TABLE cSituaciones (
idSituacion INT,
Situacion VARCHAR(30),
DescSituacion VARCHAR(20))

select * from cSituaciones
/*drop table cSituaciones*/


/*37.- vwmd_ProgramaSectorial2021*/
CREATE TABLE vwmd_ProgramaSectorial (
ProgramaSectorial VARCHAR(300),
LineaEstrategica VARCHAR(300),
Objetivo VARCHAR(300),
LineaAccion VARCHAR(400),
Vigente INT)

select * from vwmd_ProgramaSectorial
/*drop table vwmd_ProgramaSectorial*/

/*38.- cAgendas*/
CREATE TABLE cAgendas (
idAgenda INT,
Descripcion VARCHAR(200),
idTipoAgenda INT,
NombreCorto VARCHAR(150))

select * from cAgendas
/*drop table cAgendas*/


/*45.- cTiposBeneficiarios*/
CREATE TABLE cTiposBeneficiarios (
idTipoBeneficiario INT,
clave VARCHAR(5),
descripcion VARCHAR(50))

select * from cTiposBeneficiarios
/*drop table cTiposBeneficiarios*/

/*catPais*/
CREATE TABLE catPais (
idPais INT,
nombreCortoIngles VARCHAR(100))

select * from catPais
/*drop table catPais*/


/*cCalificacionesCualitativas*/
CREATE TABLE cCalificacionesCualitativas (
idCalificacion INT,
Calificacion VARCHAR(30))

select * from cCalificacionesCualitativas
/*drop table cCalificacionesCualitativas*/

/*cCalificacionesCualitativas*/
CREATE TABLE cCodigosSepomex (
d_codigo INT,
d_asenta VARCHAR(50),
d_tipo_asenta VARCHAR(50),
D_mnpio VARCHAR(50),
d_estado VARCHAR(30),
d_ciudad VARCHAR (50),
d_CP INT,
c_estado INT,
c_oficina INT,
c_CP VARCHAR(10),
c_tipo_asenta VARCHAR(5),
c_mnpio VARCHAR(6),
id_asenta_cpcons VARCHAR(7),
d_zona VARCHAR(20),
c_cve_ciudad VARCHAR(5),
idCodigoPostal INT)

select * from cCodigosSepomex
/*drop table cCodigosSepomex*/


/*45.- cEjes*/
CREATE TABLE cEjes (
idEje INT,
Eje VARCHAR(70),
Periodo VARCHAR(20)
)

select * from cEjes
/*drop table cEjes*/

/*cEjesEstrategicos*/
CREATE TABLE cEjesEstrategicos (
idEjeEstrategico INT,
EjeEstrategico VARCHAR (20)
)

select * from cEjesEstrategicos
/*drop table cEjesEstrategicos*/

/*cEstadosCivils*/
CREATE TABLE cEstadosCivil (
idEstadoCivil INT,
DescripcionEstadoCivil VARCHAR (20)

)

select * from cEstadosCivil
/*drop table cEstadosCivil*/

/*cEstrategias_PG*/
CREATE TABLE cEstrategias_PG (
idEstrategiaPG INT,
idObjetivoPG INT,
ClaveEstrategia VARCHAR(30),
NombreEstrategia VARCHAR(300)


)

select * from cEstrategias_PG
/*drop table cEstrategias_PG*/


/*cGrupoCategorias*/
CREATE TABLE cGrupoCategorias (
idGrupoCategoria INT,
GrupoCategoria VARCHAR(30)
)

select * from cGrupoCategorias
/*drop table cGrupoCategorias*/

/*cMeses*/
CREATE TABLE cMeses (
idMes INT,
Mes VARCHAR(15),
NombreCortoMes VARCHAR(3)
)

select * from cMeses
/*drop table cMeses*/

/*cModalidadesContratacion*/
CREATE TABLE cModalidadesContratacion (
idModalidadContratacion INT,
Modalidad VARCHAR(100)
)

select * from cModalidadesContratacion
/*drop table cModalidadesContratacion*/

/*cObjetivos_PG*/
CREATE TABLE cObjetivos_PG (
idObjetivoPG INT,
ClaveObjetivo VARCHAR(16),
NombreObjetivo VARCHAR(150),
idEje INT
)

select * from cObjetivos_PG
/*drop table cObjetivos_PG*/


/*cTiposAgendas*/
CREATE TABLE cTiposAgendas (
idTipoAgenda INT,
TipoAgenda VARCHAR(30)
)

select * from cTiposAgendas
/*drop table cTiposAgendas*/


/*cTiposConcurrencias*/
CREATE TABLE cTiposConcurrencias (
idTipoConcurrencia INT,
TipoConcurrencia VARCHAR(30)
)

select * from cTiposConcurrencias
/*drop table cTiposConcurrencias*/


/*cTiposEnfoques*/
CREATE TABLE cTiposEnfoques (
idTipoEnfoque INT,
TipoEnfoque VARCHAR(20)

)

select * from cTiposEnfoques
/*drop table cTiposEnfoques*/


/*cTiposObrasAccionesG1*/
CREATE TABLE cTiposObrasAccionesG1 (
idTipoObraAccionG1 INT,
TipoObraAccionG1 VARCHAR(20)
)

select * from cTiposObrasAccionesG1
/*drop table cTiposObrasAccionesG1*/
