DROP TABLE IF EXISTS "Photo";
DROP SEQUENCE IF EXISTS id_photo;
CREATE SEQUENCE id_photo INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 CACHE 1;

CREATE TABLE "public"."Photo" (
    "id" bigint DEFAULT nextval('id_photo') NOT NULL,
    "name" character(36) NOT NULL,
    "lat" double precision,
    "lon" double precision,
    "image" uuid,
    "theme" json,
    CONSTRAINT "Photo_pkey" PRIMARY KEY ("id")
) WITH (oids = false);

INSERT INTO "Photo" ("id", "name", "lat", "lon", "image", "theme") VALUES
    (1,	'Porte de la Craffe',	48.6989,6.1778,'ca6a2d0c-9649-4b61-9dc8-da0bd8643a10','["Nancy"]'),
    (2,	'Cathédrale Notre Dame de l''Annonciat',48.6914,6.1864,'0f009026-273a-45eb-8426-12f51e4e15ae','["Nancy"]'),
    (3,	'Porte Désilles',	48.6981,6.1742,'2543587d-5198-482c-98a8-3fa89ac626cf',	'["Nancy"]'),
    (4,	'Place de la Carrière',48.6958,6.1817,'07366ca4-feb8-478e-a098-8007af6a9753','["Nancy"]'),
    (5,	'Place Stanislas',48.6936,	6.1833,	'51f75935-a14e-405c-a9c9-889eca48b5ac','["Nancy"]'),
    (6,	'Place d''Alliance',48.6939,6.1864,'3280bee1-5b75-477d-8408-8cff0f1cab50','["Nancy"]'),
    (8,	'Immeuble Génin-Louis',48.69,6.1792,'6b40350c-e9a9-493f-84cb-f0e75fe51fe7','["Nancy"]'),
    (10,	'Parc Sainte-Marie',48.6806,6.1708,'9c17d5bc-b714-42c8-ba55-d8955edb6251','["Nancy"]'),
    (7,	'Parc de la Pépinière',48.6981,6.185,'b931c2ca-4c4f-4250-970f-9a860e00b4bc','["Nancy"]'),
    (9,	'La villa Les Clématites',48.6778,6.165,'4c60f9e8-58cc-440d-ab8c-006940c75a26','["Nancy"]');
