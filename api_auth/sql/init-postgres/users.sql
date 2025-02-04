DROP TABLE IF EXISTS "users";
CREATE TABLE "public"."users" (
    "id" uuid NOT NULL,
    "email" character varying(128) NOT NULL,
    "password" character varying(256) NOT NULL,
    "pseudo" character varying(128) NOT NULL,
    "role" smallint DEFAULT '0' NOT NULL,
    CONSTRAINT "users_email" UNIQUE ("email"),
    CONSTRAINT "users_id" PRIMARY KEY ("id")
) WITH (oids = false);

INSERT INTO "users" ("id", "email", "password",  "pseudo", "role") VALUES
('17112082-ff0c-4de2-a2da-7152cdddb458',	'durand@britot.fr',	'$2y$10$N8Ako4Ccxi5akzNLPiad8e5Myif1Yw195tR1TDNSP9e.dGXttN23m','durrand',	1),
('f1bd4aa0-4a73-4788-8df4-c79a92597536',	'duranda@britot.fr',	'$2y$10$zOwVlhTMwPxVAI4ayYVkZOhHCZ7lvnkQfLL763iBVs8Qk0n9A2/s2',' '	,1);